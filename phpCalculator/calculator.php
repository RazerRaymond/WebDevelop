<!DOCTYPE html>
<html lang="en">
<head><title>Result Page</title></head>
<body>
<p> The answer is </p>
<?php


function add($x, $y){
	return $x + $y;
}
function sub($x, $y){
	return $x - $y;
}
function mult($x, $y){
	return $x * $y;
}
function div($x, $y){
    return $x / $y;
}




$first = $_GET['fn'];
$last = $_GET['ln'];
$symbol = $_GET['symbol'];
if (ctype_digit($first)&&ctype_digit($last)==false){
    echo "Wrong Input";
}
else{
    switch ($symbol){
        case "a":
        $res=add($first, $last);
        echo $res;
        break;
        case "s":
        $res=sub($first, $last);
        echo $res;
        break;
        case "m":
        $res=mult($first, $last);
        echo $res;
        break;
        case "d":
        if($last==0){
            echo "Wrong Input";
            break;
        }
        else{
            $res=div($first, $last);
            echo $res;
            break;
        }
        default:
        echo "Wrong Input";
        break;
    }
}
?>




</body>
</html>