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
    $Country = "basic";
//    $Country = "uk";

if (array_key_exists('min', $_GET))
    $min = $_GET['min'];
else
    $min = "0";


//echo "#EXTM3U". chr(10) . chr(13);
print_header($Country);
if($Country == "all"){
    loop_on_country_to_find_last_good("us", $min);
    loop_on_country_to_find_last_good("ca", 0);
    loop_on_country_to_find_last_good("uk", $min);
    loop_on_country_to_find_last_good("fr", 0);
    loop_on_country_to_find_last_good("sp", 0);
} else {
    if($Country != "basic") loop_on_country_to_find_last_good($Country, $min);
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


function loop_on_country_to_find_last_good($country, $min){
    $m3uFile = new M3UFile();
    $found = false;
    $added_days = 0;


    for ($x = 0; $x <= 10; $x++) {
        //$day_to_test = @date_create(@date('dmy'))->modify('-' . $x . ' days')->format('dmy');
        $day_to_test = DateTime::createFromFormat('dmy',(@date('dmy')))->modify('-' . $x . ' days')->format('dmy');
        $UrlLink = "http://www.iptvsource.com/dl/" . $country . "_" . $day_to_test . "_iptvsource_com.m3u";
        $lastnbr = 0;
        for($y = 1; $y <= 10; $y++){
            if($y > 1){
                $UrlLink = "http://www.iptvsource.com/dl/" . $country . "_" . $day_to_test . "_iptvsource_com" . $y .".m3u";
            }
            $content = internal_check_if_m3u($UrlLink);
            if($content){
                $m3uFile->parse_file_stream($content);
                $found = true;
            } else {
                $lastnbr = $y - 1;
                $added_days += 1;
                break;
            }
        }
        // In case the we found a day that had sources it stop searching with the
        // exception for us and uk where we need days with more than 3 sources
//        if(!(($country == 'us' or $country == 'uk') and $lastnbr < ($min + 1))){
//            if($found) break;
//        }
        if($lastnbr > $min){
            if($found) break;
        }
    }
    $m3uFile->print_all_entries();
}


function print_header($Country){

    $nbc = "http://185.246.209.196:25461/live/fabo6nXpuq/Is3PISvHp7/8393.m3u8?token=Q0ZYUkFcFlgQUgxTXAYAWFJfAAQEAVUGV1JeBlVUUlJcVlFWBwRVUgdHGUQWQBdcVws7CAUWX11SX1UYQEREVUo7WVcQDhZXB1QEU0cYR01fCwFDWwRJRxEPAhZYEwAJDlMJER4WURpGAEcIBFg6XVMQDQIEFl8LFAoKGEBeWW9cAV1SXFAWWBBVF0pHXRZJFFxGIwRYCUUiBwhVBlAVHBoGWUdAVUAHEF8XVF0DVRsaRAcOFFoRFxhEXBYhcBUcGgFIR1daRwtdCxdcR1lWTA5ESEMIRzoXBBUSRgdQWlVKRgoRAhYYQF8ETTkGWwtXUwUQCA5aFkdbRFcWThNaX1YNRFxAa0QLVkcPRFQAXA0HU0Yc";

    echo "#EXTM3U". chr(10) . chr(13);

    if ($Country == "NOT_SET" || $Country == strtolower("us") || $country="basic")
    {
        echo "#EXTINF:0,CNN" . chr(10) . chr(13);
        echo "https://1861340594.rsc.cdn77.org/ls-54548-1/index.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Fox news". chr(10) . chr(13);
        echo "http://1028107998.rsc.cdn77.org/ls-54548-2/index.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:0,HLN" . chr(10) . chr(13);
        echo "https://1161275585.rsc.cdn77.org/LS-ATL-54548-7/index.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,ABC News" . chr(10) . chr(13);
        echo "http://abclive.abcnews.com/i/abc_live4@136330/master.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,CBS News" . chr(10) . chr(13);
        echo "http://cbsnewshd-lh.akamaihd.net/i/CBSNHD_7@199302/master.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,MSNBC" . chr(10) . chr(13);
        echo "https://1686983180.rsc.cdn77.org/ls-54548-2-backup/index.m3u8" . chr(10) . chr(13);
//	      echo "#EXTINF:-1,MSNBC" . chr(10) . chr(13);
//        echo "http://tvemsnbc-lh.akamaihd.net/i/nbcmsnbc_1@122532/master.m3u8" . chr(10) . chr(13);
//        echo "#EXTINF:-1,MSNBC" . chr(10) . chr(13);
//        echo "http://tvemsnbc-lh.akamaihd.net/i/nbcmsnbc_1@122532/index_1296_av-p.m3u8" . chr(10) . chr(13);
//        echo "#EXTINF:-1,MSNBC" . chr(10) . chr(13);
//        echo "http://tvemsnbc-lh.akamaihd.net/i/nbcmsnbc_1@122532/index_1896_av-b.m3u8" . chr(10) . chr(13);
//       echo "#EXTINF:-1,Fox News HD" . chr(10) . chr(13);
//		echo "http://live1.watchnewslive.net/FoxNews/myStream/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTAvMzAvMjAxOCA5OjE1OjE3IFBNJmhhc2hfdmFsdWU9U253YnF4Tjl4SXdNalY3YkFoWHJZQT09JnZhbGlkbWludXRlcz0zNjAmaWQ9MA==" . chr(10) . chr(13);
        //       echo "#EXTINF:0,CNN" . chr(10) . chr(13);
//		echo "http://live1.watchnewslive.net/CNN/myStream/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTAvMzAvMjAxOCA5OjIyOjA0IFBNJmhhc2hfdmFsdWU9UkN3M2ZYbnBQSC9DcTkyYWVmNjRodz09JnZhbGlkbWludXRlcz0zNjAmaWQ9MA==" . chr(10) . chr(13);
        echo "#EXTINF:-1,RDI" . chr(10) . chr(13);
        echo "https://rcavlive.akamaized.net/hls/live/704025/xcanrdi/master_2500.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Ici" . chr(10) . chr(13);
        echo "https://rcavlive.akamaized.net/hls/live/664044/cancbft/master_2500.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,TVA" . chr(10) . chr(13);
        echo "https://chainetvauls-lh.akamaihd.net/i/tvago_1@410563/master.m3u8?__nn__=5529128749001&hdnea=st=1541358000~exp=1541361600~acl=/*~hmac=c4e36a7a0e700790c7e13a7f28d1996111a9326151787e8c1f754932bff26936" . chr(10) . chr(13);
        echo "#EXTINF:-1,V" . chr(10) . chr(13);
        echo "https://bcsecurelivehls-i.akamaihd.net/hls/live/551061/618566855001/master.m3u8" . chr(10) . chr(13);


        // TESTING THE NEW CHANNELS FROM http://www.time4tv.net
        echo "#EXTINF:-1,NBC" . chr(10) . chr(13);
        echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18304.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,HLN" . chr(10) . chr(13);
        echo "https://1161275585.rsc.cdn77.org/LS-ATL-54548-7/index.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Fox News" . chr(10) . chr(13);
        echo "https://1875856221.rsc.cdn77.org/LS-ATL-54548-4/index.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,ABC" . chr(10) . chr(13);
        echo "http://live.field59.com/wwsb/ngrp:wwsb1_all/playlist.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,A&E" . chr(10) . chr(13);
        echo "http://unlockyourtv.com:8000/live/Luis/Luis/866.m3u8" . chr(10) . chr(13);
//		echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18515.m3u8" . chr(10) . chr(13);

//		echo "#EXTINF:-1,AMC" . chr(10) . chr(13);
//		echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18495.m3u8" . chr(10) . chr(13);
//		echo "#EXTINF:-1,Bravo" . chr(10) . chr(13);
//		echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18477.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,CNBC" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/631.m3u8" . chr(10) . chr(13);
//		echo "#EXTINF:-1,Comedy Central" . chr(10) . chr(13);
//		echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18449.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,HBO" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/146.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,History Channel" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/380.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Investigation Discovery" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/327.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,National Geographic" . chr(10) . chr(13);
        echo "http://vivid.ddns.net:25461/live/thePr0vider/USAcanUkCha/18306.m3u8" . chr(10) . chr(13);
//		echo "#EXTINF:-1,NFL Network" . chr(10) . chr(13);
//		echo "https://cdn.hdcast.me/live/TyjPLHhkAG20180910/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTAvMzEvMjAxOCAxOjIwOjIyIEFNJmhhc2hfdmFsdWU9M1VTRHN6ODNsMWNGSndYamx4ODNwUT09JnZhbGlkbWludXRlcz0yMA==" . chr(10) . chr(13);
        echo "#EXTINF:-1,SyFy" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/153.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Spike" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/152.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,TNT" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/155.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,Tru TV" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/738.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,TBS" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/154.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,USA Network" . chr(10) . chr(13);
        echo "http://access.shared-servers.net/live/mJT8uoSk02/EIln7UvtPo/180.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,France 24" . chr(10) . chr(13);
        echo "http://f24hls-i.akamaihd.net/hls/live/221192/F24_FR_LO_HLS/master_900.m3u8" . chr(10) . chr(13);

        // From https://www.stream4free.live
        echo "#EXTINF:-1,France 2" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/francetv2.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,France 3" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/france3.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,France 4" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/france4.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,France 5" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/france5.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,M6" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/m6france.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,W9" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/w9france.m3u8" .chr(10) . chr(13);
        echo "#EXTINF:-1,C8" . chr(10) . chr(13);
        echo "https://sv1.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/d8france.m3u8" .chr(10) . chr(13);
//		echo "#EXTINF:-1,TMC" . chr(10) . chr(13);
//		echo "https://sv4.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/tmc.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,TF1" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/tf3-HD.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,TF1 series films" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/hd1.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,6ter" . chr(10) . chr(13);
        echo "https://sv3.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/6ter.m3u8" . chr(10). chr(13);
        echo "#EXTINF:-1,TFX" . chr(10) . chr(13);
        echo "https://sv7.data-stream.top/d7be7c573724d4a8195f5b79dae008fb7d2fb533b145f4601c6e14e986565567/hls/tfx.m3u8" . chr(10) . chr(13);
        echo "#EXTINF:-1,ITV2" . chr(10) . chr(13);
        echo "http://77.226.204.228:25461/live/test/test/4.m3u8http://77.226.204.228:25461/live/test/test/4.m3u8" . chr(10) . chr(13);


    }
}

