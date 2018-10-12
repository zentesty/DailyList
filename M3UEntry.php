<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 4:31 PM
 */


class M3UEntry
{

    var $title = "";
    var $link = "";

    var $name = "";
    var $url = "";
    var $token_prefix = ["CA: ", "CA:", "CA | ", "US: ", "USA: ", "USA | ", "UK: ", "UK | ",
                        "FR: ", "FR:", "KOR | ", "DE: ", "NL: ", "NL:"  ];
    var $token_suffix = [" | SD", " | HD", " HD", " SD", " Backup", " (FR)", " FHD"];



    var $token = "#EXTINF:";


    public function __construct($title, $link) {
        $this->title = $title;
        $this->link = $link;
        $this->extract_name($title);
        $this->extract_url($link);
    }


    private function extract_name($rough){

        $this->name = substr($rough, strpos($rough, ",") + 1, strlen($rough));
        // Clean up the prefixes
        foreach($this->token_prefix as $prefix){
            $pos = strpos($this->name, $prefix);
            if(($pos !== false)){
                $this->name = substr($this->name, $pos + strlen($prefix), strlen($this->name));
            }
        }
        // Clean up the suffixes
        foreach($this->token_suffix as $suffix){
            $pos = strpos($this->name, $suffix);
            if(($pos !== false)){
                $this->name = substr($this->name, 0, $pos);
            }
        }

        $this->name = trim($this->name);




//        echo $this->name . "</br>";
    }

    private function extract_url($rough){
        $rough = str_replace("\n","",$rough);
        $this->url = $rough;
        // Add procesing threatment

    }


    private function test_link($url){
        ini_set('default_socket_timeout', 1);

        if(!$fp = @fopen($url, "r")) {
            return false;
        } else {
            fclose($fp);
            return true;
        }

    }

    public function __destruct() {
//        echo 'Destroying: ', $this->name, PHP_EOL;
    }

    public function output_to_m3u(){
        if($this->url){
            echo "#EXTINF:-1," . $this->name . chr(10) . chr(13) . $this->url . chr(10) . chr(13); // . "</br>";
        }
    }

    public function __toString()
    {
        return $this->name . chr(10) . chr(13) . $this->url  . chr(10) . chr(13);
    }
}