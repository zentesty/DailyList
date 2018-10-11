<?php
require_once "M3UFile.php";

/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 3:46 PM
 */
//echo @date('dmy') . "</br>" ;

//$m3ufile = new M3UFile();
//$m3ufile->is_ready();


//echo @date_create(@date('dmy'))->modify('-15 days')->format('dmy');
//echo "</br>" ;
//
//$x = 0;
//echo @date_create(@date('dmy'))->modify('-' . $x .' days')->format('dmy');
//echo "</br>" ;
//
//$a = [];
//array_push($a, 10);
//array_push($a, 20);
//array_push($a, 30);
//foreach($a as $entry){
//    echo $entry . "</br>";
//}

//$sub = "#EXTINF:-1,CA: BBC WORLD NEWS | HD";
//echo substr($sub, 0, 8) . "</br>";
//if(substr($sub, 0, 8) == "#EXTINF:"){
//    echo "____YES_____" . "</br>";
//
//}
//echo substr($sub, 1, 8) . "</br>";

$ret = test_link("http://54.37.188.76:80/live/test1/test1/23642.ts");
if($ret){
    echo $ret . " -- TRUE </br>";
} else {
    echo $ret . " -- FALSE </br>";
}

$ret = test_link("http://1028107998.rsc.cdn77.org/ls-54548-2/index.m3u8");
if($ret){
    echo $ret . " -- TRUE </br>";
} else {
    echo $ret . " -- FALSE </br>";
}

$ret = test_link("http://54.37.188.76:80/live/new4tec/new4tec/23630.ts");
if($ret){
    echo $ret . " -- TRUE </br>";
} else {
    echo $ret . " -- FALSE </br>";
}

//http://1028107998.rsc.cdn77.org/ls-54548-2/index.m3u8  // FoxNews
//http://54.37.188.76:80/live/new4tec/new4tec/23630.ts   // E!



function test_link($url){
    ini_set('default_socket_timeout', 1);

    if(!$fp = @fopen($url, "r")) {
        return false;
    } else {
        fclose($fp);
        return true;
    }

}
