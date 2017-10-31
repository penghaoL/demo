    <?php
       //需求：实现数据修改
       //判断id是否存在 
       if(empty($_GET["id"])){
        exit('<h1>没有指定参数</h1>');
       }
      $id = $_GET["id"];
      //连接数据库
      $concent =  mysqli_connect('127.0.0.1','root','liupenghao','demo2');
      if(!$concent){
        exit('<h1>连接数据库失败</h1>');
      }
      //执行sql语句
      $query = mysqli_query($concent,"select * from users where id = $id;");
      if(!$query){
        exit('<h1>查询数据失败</h1>');
      }
      //获取文件
      $row = mysqli_fetch_assoc($query);
      //edit函数
      function edit(){
        global $row;
        //判断用户名是否存在
        if(empty($_POST['name'])){
          echo '请输入用户名';
          return;
        }
        //判断性别有没有选择
        if(!(isset($_POST['gender'])) || $_POST['gender'] === '-1'){
          echo "请选择性别";
          return;
        }
        //判断日期是否存在
        if(empty($_POST["birthday"])){
          echo '请选择日期';
          return;
        }
        //取值
        $row['name'] = $_POST['name'];
        $row['gender'] = $_POST['gender'];
        $row['birthday'] = $_POST['birthday'];
        //如果用户上传数据则修改数据
        if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK){
          $after = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
          $target = './assets/img/' . uniqid() . '.' . "$after";
          if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target)){
            echo '文件移动失败';
            return;
          }
          $row['avatar'] = substr($target,2);
        }
       //修改数据并将数据返回数据库
        global $concent;
        $fasdf = mysqli_query($concent,"update users set name='" . $row['name'] . "',gender='" . $row['gender'] . "',birthday='" . $row['birthday'] . "',avatar='" . $row['avatar'] . "' where id='" . $row['id'] . "';");
        header('Location: index.php');
        
      } 
      //若请求方式为post则与执行下面的函数（edit）
      if($_SERVER["REQUEST_METHOD"] === 'POST'){
        edit();
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
        <h1 class="heading">编辑信息</h1>
        <?php if (isset($error_message)): ?>
        <div class="alert alert-warning">
          <?php echo $error_message; ?>
        </div>
        <?php endif ?>
        <form action="<?php $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
          <img src="<?php echo $row['avatar']?>" alt="">
          <div class="form-group">
            <label for="avatar">头像</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
          </div>
          <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row["name"];?>">
          </div>
          <div class="form-group">
            <label for="gender">性别</label>
            <select class="form-control" id="gender" name="gender">
              <option value="-1">请选择性别</option>
              <option value="1" <?php echo $row['gender'] === '1'? 'selected' : ''?> >男</option>
              <option value="0" <?php echo $row['gender'] === '0'? 'selected' : ''?>>女</option>
            </select>
          </div>
          <div class="form-group">
            <label for="birthday">生日</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $row["birthday"]?>">
          </div>
          <button class="btn btn-primary">保存</button>
        </form>
      </main>
    </body>
    </html>