<?php
echo "PHP is working successfully";

$str="This is Supriya"
// ---------string functions------------
echo strlen($str) #15
echo strrev($str) #ayirus si siht
echo strtolower("STRING IN CAP PRINTED AS LOW") 
echo trim("           spaces been trimmed")
echo explode($str)
echo str_replace("is","was",$str)


$stringvar="hey this is supriya"
$varint=2345
$floatvar=34.6
$bool=true

$array=array("Supriya","Avinash Akula");
echo "string:$stringvar <br>";
echo "integer value:$varint <br>";
echo "float value:$floatvar <br>";
echo "boolean value:$bool <br>";
echo "Array :";
print_r ($array);
echo "<br><br>";



//---------------------------------------------variable scope-------------------------------------------------
//1.globaaaaaaaaaaaaaal scooooooooooooooooooooope
$globalvariable="this is global variable";
function showglobal(){
global $globalvariable;
echo "in the global function $globalvariable";
}

showglobal();
echo "out of gobal function $globalvariable"

//2.locaaaaaaaaaaaal scoooooooooooooooooooo00ooooope
function showlocal(){
$localvar="this one is local var";
echo "inside local function $localvar";
}

showlocal();
// echo $localvar; this will return error
//3.staaaaaaaaaaaaaaaaaatic  scoooooooooooooooooope
function staticDemo(){
static $count=0;
$count++;
echo "value of static variable:$count<br>";
}
staticDemo();

staticDemo();staticDemo();


