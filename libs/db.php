<?php

global $db;
$db = @new mysqli($host, $user, $pass, $database);

if ($db->connect_errno){
	die("Không thể kết nối CSDL <br> ". $db->connect_errordb);
}
$db->query("SET NAMES utf8");
function disconnect(){
    global $db;
    if ($db){
        mysqli_close($db);
    }
}
 
// Hàm đếm tổng số thành viên
function count_all_member($table,$tmp)
{
    global $db;
    $query = mysqli_query($db, "select count(*) as total from $table where MaMH like  '$tmp%'   ");
    if ($query){
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['total'];
    }
    return 0;
}
 
// Lấy danh sách thành viên
function get_all_member($limit, $start,$table,$tmp)
{
    global $db;
    $sql = "select * from $table  where MaMH like '$tmp%'  limit ".(int)$start . ",".(int)$limit;
    $query = mysqli_query($db, $sql);
     
    $result = array();
     
    if ($query)
    {
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $result[] = $row;
        }
    }
     
    return $result;
}
