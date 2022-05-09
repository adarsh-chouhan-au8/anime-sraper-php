<?php

function get_anime_data_from_url($url)
//returns name, image,type, plot,genre,year,status,sections,goanime_anime_id of a anime form a url
//*** plot may come empty
{
  $dt = file_get_html($url);
  $result = [];
  $ep_sections = [];

  $img_src = $dt->find('.anime_info_body_bg img', 0)->attr['src'];
  $name = $dt->find('.anime_info_body_bg h1', 0)->plaintext;
  $type = trim(str_replace('Type:', '', $dt->find('.type', 0)->plaintext));
  $plot = trim(str_replace('Plot Summary:', '', $dt->find('.type', 1)->plaintext));
  $genre = trim(str_replace('Genre:', '', $dt->find('.type', 2)->plaintext));
  $year = trim(str_replace('Released:', '', $dt->find('.type', 3)->plaintext));
  $status = trim(str_replace('Status:', '', $dt->find('.type', 4)->plaintext));
  $goanime_anime_id = $dt->find('input#movie_id', 0)->attr['value'];


  foreach ($dt->find('#episode_page a') as $key => $a) {
    $ep_sections[] = [(int)$a->attr['ep_start'], (int)$a->attr['ep_end']];
  }
  $ep_sections = json_encode($ep_sections);


  $result = ["name" => $name, "img_src" => $img_src, "category" => $type, "plot" => $plot, "genre" => $genre, "year" => $year, "status" => $status, "sections" => $ep_sections, 'goanime_anime_id' => $goanime_anime_id];

  return $result;
}


function get_episode_data_from_anime_episode($url)
{
  // gets episode data from anime episode 
  // return array of download link, episode name,links json,anime_url

  $ep_dt = file_get_html($url);
  $download = $ep_dt->find('.download-anime  a', 0)->href;
  $ep_name = $ep_dt->find('.title_name h2', 0)->plaintext;
  $anime_url = $ep_dt->find('.anime-info a', 0)->href;

  foreach ($ep_dt->find('.anime_muti_link li a') as $key => $arr) {
    $json_arr[$key]['name'] = str_replace('Choose this server', '', $arr->plaintext);
    $json_arr[$key]['links'] = $arr->attr['data-video'];
  }

  $link = json_encode($json_arr);

  $ep_arr = ["download" => $download, "ep_name" => $ep_name, "link" => $link, "anime_url" => $anime_url];

  return $ep_arr;
}

function get_anime_url_from_episode_url($url)
{
  // returns anime url from an episode url
  $data = get_episode_data_from_anime_episode($url);

  return SCRAPING_HOST . $data['anime_url'];
}


function anime_exists($name)
{
  //check if anime exists
  global $con;
  $name = mysqli_real_escape_string($con,$name);
  $query = "SELECT * from anime where name='$name' ";
  echo $query;
  $query_dt = query_data($query,'UNITARY');

  if ($query_dt) {
    $id = $query_dt['id'];
    return $id;
  }

  return false;
}

function sanitize($obj)
{
  //data cleanup for sql queries
  global $con;

  foreach ($obj as $key => $value) {
    $obj[$key] = mysqli_real_escape_string($con, $value);
  }

  return $obj;
}

function add_anime($obj)
{
  // takes object of data and add single anime in the db
  global $con;
  $obj = sanitize($obj);
  $query = "INSERT INTO `anime`(`name`, `genre`, `plot`, `year`, `status`, `img_src`, `category`) VALUES ('" . $obj['name'] . "','" . $obj['genre'] . "','" . $obj['plot'] . "','" . $obj['year'] . "','" . $obj['status'] . "','" . $obj['img_src'] . "','" . $obj['category'] . "')";

  if (query_insert($query)) {
    $id = mysqli_insert_id($con);
    return $id;
  }

  return false;
}

function add_episode($obj, $id)
{
  // takes object of data and add single episode in episodes table
  $obj = sanitize($obj);

  $query = "INSERT INTO `episodes`(`anime_id`, `name`, `video_src`, `download`) VALUES ('$id','" . $obj['ep_name'] . "','" . $obj['link'] . "','" . $obj['download'] . "')";

  if (query_insert($query)) {
    return true;
  }
  return false;
}


function operate_section($start, $end, $goanime_anime_id, $anime_id, $break_number = false) 
{
  // runs a section of anime and executes a single section 
  // An anime can contain multiple sections of episodes like this
  // ep=0 to ep=100, ep=100 to ep=200,........
  //**adds all episodes of section to db if breaknumber is not specified*/
  //break number only update for last  episodes until it encounters a duplicate episode witch is already  present
  //**break number only used when we are updating episodes for an existing anime*/

  $url = AJAX_HOST."/ajax/load-list-episode?ep_start=$start&ep_end=$end&id=$goanime_anime_id";
  $data = file_get_html($url);

  foreach ($data->find('#episode_related li a') as $key => $a) {
 

    $ep_url = SCRAPING_HOST . trim($a->href);
    $ep_data = get_episode_data_from_anime_episode($ep_url);
    $if_added_episode = add_episode($ep_data, $anime_id);

    if ($break_number && !$if_added_episode)
    {
      break;
    }

  }
}


function file_get_html_for_latest_episodes_page($url)
{
  $page_dt = file_get_html($url);

  if (count($page_dt->find('.last_episodes a'))==0)
  {
    throw new Exception('content issue in url'.$url);
    return false;
  }

  return $page_dt;


}