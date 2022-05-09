<?php
$db_user='';
$password='';
$database='';

$con = mysqli_connect('localhost',"$user_name","$password","$database_name");

if(!$con);
{
throw new Exception('DB connection failed');
}
