<?php
 if(empty($_GET["id"])){
     exit("<h1>没有传入指定参数</h1>");
 }
 $id = $_GET["id"];
 $concent = mysqli_connect('127.0.0.1','root','liupenghao','demo2');
 if(!$concent){
     exit('连接数据库失败');
 }
 $query = mysqli_query($concent,'delete from users where id in (' . $id . ');');
 if(!$query){
    exit('查询数据失败');
}
$affected = mysqli_affected_rows($concent);
if($affected <= 0){
    exit("删除数据失败");

}
header('Location: index.php');
?>