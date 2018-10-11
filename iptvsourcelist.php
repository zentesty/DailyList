<?php
/**
 * User: martin-pierre.roy
 * Date: 2018-10-01
 * Time: 09:26
 */
require_once "./M3UFile.php";



// Extract URL parameters
$parameter = $_SERVER['QUERY_STRING'];


if (array_key_exists('country', $_GET))
    $Country = $_GET['country'];
else
    $Country = "NOT_SET";

if (array_key_exists('index', $_GET))
    $Index = $_GET['index'];
else
    $Index = "";


if($Country == "NOT_SET"){
    loop_on_country_to_find_last_good("us");
    loop_on_country_to_find_last_good("ca");
    loop_on_country_to_find_last_good("uk");
} else {
    loop_on_country_to_find_last_good($Country);
}



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


function internal_check_if_m3u($UrlLink){
    try{
        $content = file_get_contents_with_timeout($UrlLink);
        if(substr($content, 0, 7) == "#EXTM3U" or
            substr($content, 0, 7) == "#EXTINF")
        {
            return $content;
        }
    } catch (Exception $e) {
        return false;
    }
    return false;
}


function loop_on_country_to_find_last_good($country){
    $m3uFile = new M3UFile();
    $found = false;

    for ($x = 0; $x <= 10; $x++) {
        $day_to_test = @date_create(@date('dmy'))->modify('-' . $x . ' days')->format('dmy');
        $UrlLink = "http://www.iptvsource.com/dl/" . $country . "_" . $day_to_test . "_iptvsource_com.m3u";
        for($y = 1; $y <= 10; $y++){
            if($y > 1){
                $UrlLink = "http://www.iptvsource.com/dl/" . $country . "_" . $day_to_test . "_iptvsource_com" . $y .".m3u";
            }
            $content = internal_check_if_m3u($UrlLink);
            if($content){
                $m3uFile->parse_file_stream($content);
                $found = true;
            } else {
                break;
            }
        }
        if($found) break;
    }
    $m3uFile->print_all_entries();

}


function loop_on_country_to_find_last_good_ORIGINAL($m3uFIle, $country){

    for ($x = 0; $x <= 10; $x++) {
        $Index = "";
        $day_to_test = @date_create(@date('dmy'))->modify('-' . $x . ' days')->format('dmy');
        $UrlLink = "http://www.iptvsource.com/dl/" . $country . "_" . $day_to_test . "_iptvsource_com" . $Index .".m3u";
        try{
            $contents = file_get_contents_with_timeout($UrlLink);
            if(substr($contents, 0, 7) == "#EXTM3U" or
                substr($contents, 0, 7) == "#EXTINF")
            {
                $m3uFIle->parse_file_stream($contents);
                // echo $contents;
                break;
            }
        } catch (Exception $e) {
//            print "ABC" . "</br>";
        }
    }
//    $m3uFIle->print_all_entries();

}
