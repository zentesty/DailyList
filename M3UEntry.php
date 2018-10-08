<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 4:31 PM
 */


class M3UEntry
{

    var $name = "";
    var $url = "";


    public function __construct($name, $url) {
        $this->name = $name;
        $this->url = $url;
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }


    public function __toString()
    {

        return $this->name . chr(10) . chr(13) . $this->url  . chr(10) . chr(13);
    }
}