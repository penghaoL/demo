<?php
    $connection = mysqli_connect('127.0.0.1','root','liupenghao','demo2');
    $query = mysqli_query($connection,"select * from users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>管理系统</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">后台管理系统</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">用户管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">商品管理</a>
      </li>
    </ul>
  </nav>
  <main class="container">
    <h1 class="heading">用户管理 <a class="btn btn-link btn-sm" href="add.php">添加</a></h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>头像</th>
          <th>姓名</th>
          <th>性别</th>
          <th>年龄</th>
          <th class="text-center" width="140">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($query)):?>
        <tr>
          <th scope="row"><?php echo $row["id"];?></th>
          <td><img src="<?php echo $row["avatar"];?>" class="rounded" alt="张三"></td>
          <td><?php echo $row["name"];?></td>
          <td><?php echo $row["gender"] == 1?  "♂" :  "♀"?></td>
          <td>18</td>
          <td class="text-center">
            <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $row["id"];?>">编辑</a>
            <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"];?>">删除</a>
          </td>
        </tr>
        <?php endwhile ?>
      </tbody>
    </table>
    <ul class="pagination justify-content-center">
      <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
    </ul>
  </main>
</body>
</html>