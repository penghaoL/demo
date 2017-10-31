<?php
   function add_user(){
      //判断文本框是否传入数据
      if(empty($_POST['name'])) {
        $GLOBALS['error_message'] = '请输入姓名';
        return;
      }
      if(!(isset($_POST['gender']) && $_POST["gender"] !== "-1")) {
        $GLOBALS['error_message'] = '请选择性别';
        return;
      }
      if(empty($_POST['birthday'])) {
        $GLOBALS['error_message'] = '请选择生日';
        return;
      }
      //取值
      $name = $_POST["name"];
      $gender = $_POST["gender"];
      $birthday = $_POST["birthday"];
      //图片上传
      //判断文本域是否存在
      if (empty($_FILES['avatar'])) {
        $GLOBALS['error_message'] = '请上传头像';
        return;
      }
      $houzhui = $_FILES["avatar"]['name'];
      $houarr = explode(".",$houzhui);
      $target= "assets/img/" . uniqid() . "." . $houarr[1];
      $avatar = $target;
      move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
      //MySQL建立连接
      $connect = mysqli_connect('127.0.0.1','root','liupenghao','demo2');
      if(!$connect){
          exit("建立数据库失败");
      }
      $query = mysqli_query($connect, "insert into users values (null, '{$name}', {$gender}, '{$birthday}', '{$avatar}');");
      header('Location: index.php');
      
   }
   if($_SERVER['REQUEST_METHOD'] === "POST"){
       add_user();
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>后台管理系统</title>
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
    <h1 class="heading">添加用户</h1>
    <?php if (isset($error_message)): ?>
    <div class="alert alert-warning">
      <?php echo $error_message; ?>
    </div>
    <?php endif ?>
    <form action="<?php $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="avatar">头像</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
      </div>
      <div class="form-group">
        <label for="name">姓名</label>
        <input type="text" class="form-control" id="name" name="name" >
      </div>
      <div class="form-group">
        <label for="gender">性别</label>
        <select class="form-control" id="gender" name="gender">
          <option value="-1">请选择性别</option>
          <option value="1">男</option>
          <option value="0">女</option>
        </select>
      </div>
      <div class="form-group">
        <label for="birthday">生日</label>
        <input type="date" class="form-control" id="birthday" name="birthday">
      </div>
      <button class="btn btn-primary">保存</button>
    </form>
  </main>
</body>
</html>
