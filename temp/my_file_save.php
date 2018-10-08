<?php
/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-04
 * Time: 5:16 PM
 */
$xml = new DOMDocument();
$employees = $xml->createElement("employees");
$employee = $xml->createElement("employee");

$xml->appendChild( $employees );
$employees->appendChild( $employee );


//$employee->nodeValue = "ABC";

$name = $xml->createElement("name");
$name->setAttribute("id", "123");
$employee->appendChild($name);

$phone = $xml->createElement("phone");
$employee->appendChild($phone);
$phone->nodeValue = "515-555-0909";


$xml->save("./my_file_xml.xml");
