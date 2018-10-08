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
    $Country = "ca";

if (array_key_exists('index', $_GET))
    $Index = $_GET['index'];
else
    $Index = "";


loop_on_country_to_find_last_good("ca");
//loop_on_country_to_find_last_good("us");
//loop_on_country_to_find_last_good("uk");


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

function loop_on_country_to_find_last_good($country){
    $m3uFIle = new M3UFile();
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
            } else {
                echo $UrlLink . " ..  " . $x . " - NOT FOUND" . "</br>";
            }
        } catch (Exception $e) {
            print "ABC" . "</br>";
            echo 'Exception : ',  $e->getMessage(), "\n";

        }
        echo "END LOOP" ."</br>";
    }
    $m3uFIle->print_all_entries();

//    echo " *** OUT ***" ."</br>";

}
