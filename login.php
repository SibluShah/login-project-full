<?php include_once 'app/autoload.php'?>
<?php
session_start();

if (isset($_GET['relog_id'])){

    $_SESSION['id']=$_GET['relog_id'];
    setcookie('relog_id',$_GET['relog_id'],time()+(60*60*24*365));
    header('location:profile.php');
}
if (isset($_COOKIE['relog_id'])){
    $user_id=$_COOKIE['relog_id'];
    $sql="SELECT * FROM users WHERE id='$user_id'";
    $data=$conn->query($sql);
    $all_data=$data->fetch_assoc();

    $_SESSION['id'] = $all_data['id'];
    header('location:profile.php');

}

if (isset($_COOKIE['user_log_id'])){
    $user_id=$_COOKIE['user_log_id'];
    $sql="SELECT * FROM users WHERE id='$user_id'";
    $data=$conn->query($sql);
    $all_data=$data->fetch_assoc();


    $_SESSION['id'] = $all_data['id'];

    header('location:profile.php');
}

if (isset($_SESSION['id'])){
    header('location:profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login page</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
<?php
if (isset($_POST['add'])){
    $un_em=$_POST['log'];
    $pass=$_POST['pass'];



    if (empty($un_em) || empty($pass)){
        $mass = validationmsg('All fields are requred', 'warning');
    }else{
        $sql="SELECT * FROM users WHERE email='$un_em' OR uname='$un_em'";
        $data=$conn->query($sql);
        $all_data=$data->fetch_assoc();
        $cheek=$data->num_rows;

        if ($cheek == 1){
            if (password_verify($pass,$all_data['password'])){


                $_SESSION['id'] = $all_data['id'];

                setcookie('user_log_id',$all_data['id'],time()+(60*60*24*365));

                header('location:profile.php');
            }else{
                $mass = validationmsg('invalid password', 'warning');
            }
        }else{
            $mass = validationmsg('invalid email or username', 'warning');
        }
    }
}

?>

<style>
.recent-log{
    padding: 10px;
}
.rl-item img{
    width: 100%;
    height: 100px;
}
.rl-item {
    width: 25%;
    float: left;
    text-align: center;

}
.rl-item h3{
    font-size: 25px;
    text-align: center;
}



</style>

	<div class="wrap">
		<div class="card shadow-sm">
			<div class="card-body">
				<h2>Log in here</h2>
                <?php include 'templates/message.php'?>
				<form action="" method="post">
					<div class="form-group">
						<label for="">Username/email</label>
						<input name="log" class="form-control" type="text">
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input name="pass" class="form-control" type="password">
					</div>
					<div class="form-group">
						<input name="add" class="btn btn-primary" type="submit" value="login now">
					</div>
				</form>
			</div>
            <div class="card-footer">
                <a class="card-link" href="register.php">Create an account</a>
            </div>
		</div>
        <div class="recent-log clearfix">
          <?php
          $b='';
          if (isset($_COOKIE['recent_log_id'])){
              $b=$_COOKIE['recent_log_id'];
          }
          if (!empty($b)):
          $sql = "SELECT * FROM users WHERE id IN($b)";
          $data = $conn->query($sql);

          while ($all_data = $data->fetch_assoc()):
              ?>

            <div class="card rl-item">
                <img class="card-img" src="photos/students/<?php echo $all_data['photo'];?>" alt="">
                <div class="card-body">
                    <h3 style="display:inline-block;"><?php echo $all_data['name'];?></h3>
                    <a class="btn btn-primary btn-sm" href="?relog_id=<?php echo $all_data['id'];?>">login</a>
                </div>
            </div>

            <?php endwhile; endif;?>
        </div>

	</div>
	







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>