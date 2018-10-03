<?php
/**
 * User: martin-pierre.roy
 * Date: 2018-10-01
 * Time: 09:26
 */



// Extract URL parameters
$parameter = $_SERVER['QUERY_STRING'];


if (array_key_exists('country', $_GET))
    $Country = $_GET['country'];
else
    $Country = "us";

if (array_key_exists('index', $_GET))
    $Index = $_GET['index'];
else
    $Index = "";

// Compose and print out the URL
$UrlLink = "http://www.iptvsource.com/dl/" . $Country . "_" . @date('dmy') . "_iptvsource_com" . $Index .".m3u";
//echo $UrlLink . "<br/>";

// Try to load the URL and open the
try{
    $contents = file_get_contents_with_timeout($UrlLink);
    if(substr($contents, 0, 7) == "#EXTM3U"){
        print $contents;
    } else {
        //print "Noop!!";
    }
} catch (Exception $e) {
    echo 'Exception : ',  $e->getMessage(), "\n";
}


//print $contents;

function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}

function file_get_contents_with_timeout($path, $timeout = 30) {
    $ctx = stream_context_create(array('http'=>array('timeout' => $timeout)));
    $ret = @file_get_contents($path, false, $ctx);
    //if($ret != null) print "Return is null" . "<br/>";
    return $ret;
}
