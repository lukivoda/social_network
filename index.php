<?php
$con = mysqli_connect('localhost','root','lucy','twirl');


if(mysqli_connect_errno()){

    die('Connection failed '.mysqli_connect_errno());
}

$query = mysqli_query($con,"INSERT INTO test VALUES(2,'Lucija') ");