<?php
require_once "M3UFile.php";

/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 3:46 PM
 */
echo @date('dmy') . "</br>" ;

//$m3ufile = new M3UFile();
//$m3ufile->is_ready();


echo @date_create(@date('dmy'))->modify('-15 days')->format('dmy');
echo "</br>" ;

$x = 0;
echo @date_create(@date('dmy'))->modify('-' . $x .' days')->format('dmy');
echo "</br>" ;

$a = [];
array_push($a, 10);
array_push($a, 20);
array_push($a, 30);
foreach($a as $entry){
    echo $entry . "</br>";
}
