<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 4:31 PM
 */
require_once "./M3UEntry.php";

class M3UFile {
    var $name = "";
    var $url = "";
    var $entries = [];
    var $entry_title = "";


    public function parse_file_stream($contents){
        $pos = 0;
        $old = 0;
        $token = "#EXTINF:";

        do {
            $pos = strpos($contents, chr(13) . chr(10), $old);
            if($pos)
            {
                $sub = substr($contents, $old, $pos - $old);
                $old = $pos + 1;

                $subPrefix = substr($sub, 1, strlen($token));
                if($subPrefix == $token){
                    $this->entry_title = $sub;
                } else {
                    if(!$this->entry_title == ""){
                        $m3uEntry = new M3UEntry($this->entry_title, $sub);
                        array_push($this->entries, $m3uEntry);
                        $this->entry_title = "";
                    }
                }
                $pos = strpos($contents, chr(13) . chr(10), $old);
            }
        } while ($pos);
    }

    public function is_ready(){
        return false;
    }

    public function print_all_entries(){
        foreach($this->entries as $entry){
            echo $entry;
        }
    }

}
