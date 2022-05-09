<?php

require("./includes/connect.php");
require("./includes/functions.php");
require("./lib/simple_html_dom.php");
require("./lib/anime_methods.php");
require("./includes/constants.php");


function execute_from_episode_url($episode_url)
{

    $anime_url = get_anime_url_from_episode_url($episode_url);
    $anime_data = get_anime_data_from_url($anime_url);
    $id = anime_exists($anime_data['name']);

    if ($id) {
        $sections = json_decode($anime_data['sections'], 'MYSQLI_ASSOC');
        $last_section = $sections[count($sections) - 1];
        operate_section($last_section[0], $last_section[1], $anime_data['goanime_anime_id'], $id, false);
    } else {
        //add anime
        $inserted_anime_id = add_anime($anime_data);

        if ($inserted_anime_id) {
            //insert_episodes

            $sections = json_decode($anime_data['sections'], 'MYSQLI_ASSOC');

            foreach ($sections as $section) {
                operate_section($section[0], $section[1], $anime_data['goanime_anime_id'], $inserted_anime_id);
            }
        } else {
            throw new Exception('inserted_anime_id_error');
        }
    }
}



function main()
{
    for ($i = 1; $i < 3; $i++) {
        $ajax_url = AJAX_HOST . "/ajax/page-recent-release.html?page=$i&type=1";
        $page_dt = file_get_html_for_latest_episodes_page($ajax_url);

        foreach ($page_dt->find('.last_episodes a') as $key => $a) {

            $episode_url = SCRAPING_HOST . trim($a->href);
            execute_from_episode_url($episode_url);
        }
    }
}

main();
