<?php
ob_start();//turns on output buffering
session_start();

$time_zone = date_default_timezone_set("Europe/Skopje");

$con = mysqli_connect('localhost','root','lucy','twirl');

if(mysqli_connect_errno()){

    die('Connection failed '.mysqli_connect_errno());
}