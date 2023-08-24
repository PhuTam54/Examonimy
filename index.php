<?php
// code PHP here
$x = 10;
$x = "Hello world! T2210A";
echo $x;
$y = 20;
if ($y > 10) {

}else{

}

$arr = [];
$arr[] = 10;
//$arr = "Hello";

for($i = 0; $i < count($arr); $i++){

}

foreach ($arr as $item){

}

$sv = [];
$sv["Name"] = "Nguyen Phu Tam";
$sv["age"] = 19;

$teacher = [
    "full name" => "Tran Thi Thuy",
    "age" => 19,
    "email" => "tranthithuy@gmail.com"
];

echo "<ul>";
foreach ($teacher as $k=>$v){
    echo "<li>".$k.": ".$v."</li>";
}
echo "</ul>";

echo "Ten giao vien: ".$teacher["full name"];
function tinhTong($a, $b){
    // return ...
    echo $a + $b;
}

tinhTong(5, 4);