<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-10
 * Time: 9:38 PM
 */
require_once "./ObjRef.php";

class ObjList
{
    var $myArray = [];


    public function __construct() {
        for ($i = 1; $i <= 10; $i++) {
            array_push($this->myArray, new ObjRef($this->getRandomWord(7), rand(0, 100)));
        }

    }

    function getRandomWord($len = 10) {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    public function print_out(){
        foreach ($this->myArray as $elem){
            print $elem;
        }
    }

    public function sort_items(){
        // Asc sort
        usort($this->myArray,function($first,$second){
            return $first->tel > $second->tel;
        });
    }

}


$obja = new ObjList();
$obja->sort_items();
$obja->print_out();
