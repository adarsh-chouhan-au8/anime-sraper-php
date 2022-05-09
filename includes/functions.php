<?php

function query_data($query, $key = 'multi')
{
  global $con;
  $res = mysqli_query($con, $query);

  if ($key == 'multi') {
    $query_data = mysqli_fetch_all($res, MYSQLI_ASSOC);
  } else {
    $query_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
  }

  return $query_data;
}

function query_insert($query)
{
  global $con;

  $res = mysqli_query($con, $query);
  if (!$res) {
    throw new Exception("Error description: " . mysqli_error($con) . " in query ----------------------> $query <br/>");
  }

  return $res;
}



function get_url($Url)
{
  global $httpcode;

  if (!function_exists('curl_init')) {
    throw new Exception('Sorry cURL is not installed!');
  }

  global $ch, $error;
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $error = curl_errno($ch);

  curl_close($ch);

  if (!$error) {
    return $output;
  } else {
    throw new Exception("error code is " . $error . " in the url" . $Url);
  }
}
