<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-10
 * Time: 9:36 PM
 */

class ObjRef
{
    var $name = "";
    var $tel = 0;

    public function __construct($name, $tel) {
        $this->name = $name;
        $this->tel = $tel;
    }

    public function __toString()
    {
        return $this->name . " ...... " . $this->tel . "</br>";
    }


}