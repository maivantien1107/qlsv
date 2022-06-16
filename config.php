<?php
$host = "localhost";
$user = "root";
$pass = "maivantien1107";
$database = "qldaotao";

$page_title = 'Hệ thống Quản lý đào tạo';
$page_keywords = 'hệ thống, đào tạo, quản lý, quả lý đào tạo';
$page_description = 'Hệ thống Quản lý đào tạo ';


 require_once("./libs/db.php"); 
 require_once("./libs/common.php");
 require_once("./validatefrom/pagination.php"); 

define('ROOT_DIR', "");
 
define ("IMAGES_DIR", ROOT_DIR."images" );
define ("LIBS_DIR", ROOT_DIR."libs");
