<?php require_once 'app/autoload.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Development Area</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
	<?php
    if (isset($_POST['add'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $cell=$_POST['cell'];
        $uname=$_POST['uname'];
        $pass=$_POST['pass'];
        $cpass=$_POST['cpass'];

        $hash_pass=password_hash($pass,PASSWORD_DEFAULT);

        $status='disagree';
        if (isset($_POST['status'])){
            $status=$_POST['status'];
        }
        // valu cheeking
        $email_cheek=valucheek('users','email',$email);
        $cell_cheek=valucheek('users','cell',$cell);
        $uname_cheek=valucheek('users','uname',$uname);

        //photo getting
        $file_name=$_FILES['photo']['name'];
        $file_tmp_name=$_FILES['photo']['tmp_name'];
        $file_size=$_FILES['photo']['size'];

        $unique_file_name=md5(time().rand()).$file_name;
 }

    if (empty($name) || empty($email) || empty($cell) || empty($uname) || empty($pass) || empty($cpass) || empty($status)){
        $mass=validationmsg('All fiedls update are requred','warning');
    }elseif ($status == 'disagree'){
        $mass=validationmsg('You should agree first','warning');
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $mass = validationmsg('Invalid Email', 'info');
    }elseif ($cpass != $pass){
        $mass = validationmsg('Password did not match', 'warning');
    }elseif ($email_cheek > 0){
        $mass = validationmsg('Email already exist', 'warning');
    }elseif ($cell_cheek > 0){
        $mass = validationmsg('Cell already exist', 'warning');
    }elseif ($uname_cheek > 0){
        $mass = validationmsg('Uname already exist', 'warning');
    }else {

         insert("INSERT INTO users(name,email,cell,uname,password,photo,status) VALUES ('$name','$email','$cell','$uname','$hash_pass','$unique_file_name','$status')");
         move_uploaded_file($file_tmp_name,'photos/students/'.$unique_file_name);
       header('location:login.php');
    }

    ?>
	

	<div class="wrap">
		<div class="card shadow">
			<div class="card-body">
				<h2>Create your account</h2>
                <?php include 'templates/message.php';?>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Name</label>
						<input name="name" class="form-control" value="<?php old('name');?>" type="text">
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input name="email" class="form-control" value="<?php old('email');?>" type="text">
					</div>
					<div class="form-group">
						<label for="">Cell</label>
						<input name="cell" class="form-control" value="<?php old('cell');?>" type="text">
					</div>
					<div class="form-group">
						<label for="">Username</label>
						<input name="uname" class="form-control" value="<?php old('uname');?>" type="text">
					</div>
                    <div class="form-group">
                        <label for="">Passwor</label>
                        <input name="pass" class="form-control" type="password">
                    </div> <div class="form-group">
                        <label for="">Confirm Passwor</label>
                        <input name="cpass" class="form-control" type="password">
                    </div>
                    <div class="form-group">
                        <label for="">Profile photo</label>
                        <input name="photo" class="form-control-file" type="file">
                    </div>
                    <div class="form-group">
                        <input name="status" value="agree" type="checkbox"  id="agree"><label for="agree">I agree to go</label>
                    </div>
					<div class="form-group">
						<input name="add" class="btn btn-primary" type="submit" value="Sign Up">
					</div>
				</form>
                <hr>
                <a class="btn btn-sm btn-secondary" href="login.php">Go to login page</a>
            </div>
		</div>
	</div>
    <br>
    <br>
    <br>
    <br>
    <br>









	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>