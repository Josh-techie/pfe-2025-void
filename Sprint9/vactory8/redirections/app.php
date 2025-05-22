<?php

/**
 * @todo: localhost term is to be updated to project production domain name.
 */
define('APP_PROD_HOST', 'localhost');

$csv = [];
// Chcek whether APCu is usable in the current environment.
$apcuAvailabe = function_exists('apcu_enabled') && apcu_enabled();
$filename = './sites/default/files/redirections/urls.csv';
$size = file_exists($filename) ? filesize($filename) : NULL;
function csv_to_array($filename = '', $delimiter = ',')
{
  if (!file_exists($filename) || !is_readable($filename)) {
    return FALSE;
  }

  $header = NULL;
  $data = [];
  $isValid = 2;
  if (($handle = fopen($filename, 'r')) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
      if (!$header) {
        $header = $row;
        $isValid = count($row);
      } else if (count($row) === $isValid) {
        $data[] = array_combine($header, $row);
      }
    }
    fclose($handle);
  }
  return $data;
}
/*
 * Returns an array that group each url with /fr
 */

function group_by($key, $data)
{
  $return = [];
  foreach ($data as $val) {
    // Moves the internal pointer to the first element of the array.
    $from = reset($val);
    // Removes 'http://' or "https://' from the url.
    $from = str_replace(['http://', 'https://'], [''], $from);

    // Removes 'www' from the url.
    $enhance = preg_replace('/www./', '', $from, 1);
    // Place the pointer at the end of the array , ruturns '/fr'
    $to = end($val);
    $return[$from] = $to;
    $return[$enhance] = $to;
  }
  return $return;

}

if (file_exists($filename)) {
  if ($apcuAvailabe && apcu_exists('redirection_csv') && apcu_exists('redirection_csv_size') && apcu_fetch('redirection_csv_size') == $size) {
    $csv = apcu_fetch('redirection_csv');

  } else {
    $csv = csv_to_array($filename, ',');
    $csv = group_by('Source', $csv);
    if ($apcuAvailabe) {
      apcu_delete(['redirection_csv', 'redirection_csv_size']);
      apcu_store('redirection_csv', $csv);
      apcu_store('redirection_csv_size', $size);
    }
  }
}

$domain = $_SERVER['SERVER_NAME'];
$current_url = "$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
$location = '';
$current_url = explode('?', $current_url);
$current_url = $current_url[0];
$query = $_SERVER['QUERY_STRING'];


if (isset($csv)) {
  if (isset($csv[$current_url])) {
    $row = $csv[$current_url];
    if (strpos($row, 'https://') === FALSE && strpos($row, 'http://') === FALSE) {
      $row = 'https://' . $domain . $row;
    }
    $location = $row;
    $location = str_replace($domain, APP_PROD_HOST, $location);
    $location = empty($query) ? $location : $location . '?' . $query;
  } else {
    $param = explode('/', $current_url);
    $var = 0;
    for ($i = 1; $i < count($param); $i++) {
      if (!$var) {
        // Remove the last element form url.
        array_splice($param, count($param) - 1, 1);
        $value = implode("/", $param);
        $key = $value . "/*";
        // Check if it exists in the csv.
        if (isset($csv[$key])) {
          $location = str_replace($domain, APP_PROD_HOST, $csv[$key]);
          $var = 1;
        }
      }
    }
  }
}

if (!empty($location)) {
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: " . $location);
  exit();
}
