<?php
require_once 'app/autoload.php';
session_start();
?>

<?php
if (isset($_GET['logout']) AND ($_GET['logout'])=='ok'){

    setcookie('user_log_id','',time()-(60*60*24*365));
    setcookie('relog_id','',time()-(60*60*24*365));


    if (isset($_COOKIE['recent_log_id'])) {
        $recent_login = $_COOKIE['recent_log_id'];
       $ra=explode(',', $recent_login);
       array_push($ra,$_SESSION['id']);
       $final=implode(',',$ra);
    }else{
        $final=$_SESSION['id'];
    }

    setcookie('recent_log_id',$final,time()+(60*60*24*365));

    session_destroy();
    header('location:login.php');
}
if (!isset($_SESSION['id'])){
    header('location:login.php');
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $data = $conn->query($sql);
    $all_data = $data->fetch_assoc();
}
if (isset($_GET['view_id'])) {
    $id = $_GET['view_id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $data = $conn->query($sql);
    $all_data = $data->fetch_assoc();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo  $all_data['name'];?></title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

 <style>
    .profile img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        display: block;
        margin: auto;
        border: 10px solid #fff;

    }
    .profile h1{
        text-align: center;
        font-family: Impact;
        font-weight: normal;
    }
</style>


	<div class="wrap">
        <a class="btn btn-primary" href="users.php">All users</a>
		<div class="card shadow">
			<div class="card-body profile">

                <img class="shadow-sm" src="photos/students/<?php echo  $all_data['photo'];?>" alt="">
                <h1></h1>

                <table class="table table-striped">
                    <tr>
                        <td>Name</td>
                        <td><?php echo  $all_data['name'];?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo  $all_data['email'];?></td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td><?php echo  $all_data['cell'];?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?php echo  $all_data['uname'];?></td>
                    </tr>
                </table>
                <a class="btn btn-secondary" href="?logout=ok">Log out</a>
			</div>
		</div>
	</div>
	







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>