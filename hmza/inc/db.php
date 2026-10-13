<?php

$conn = mysqli_connect('localhost','root','','hmza');

if(!$conn){
    
    echo 'Error' . mysqli_connect_error();
}

?>