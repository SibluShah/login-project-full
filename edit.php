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
        $edit_id=$_GET['edit_id'];
        $edit_photo=$_GET['edite_photo'];

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

 }

    if (empty($name) || empty($email) || empty($cell) || empty($uname) || empty($pass) || empty($cpass) || empty($status)){
        $mass=validationmsg('All fiedls update are requred','warning');
    }elseif ($status == 'disagree'){
        $mass=validationmsg('You should agree first','warning');
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $mass = validationmsg('Invalid Email', 'info');
    }elseif ($cpass != $pass){
        $mass = validationmsg('Password did not match', 'warning');
    }elseif ($email_cheek > 1){
        $mass = validationmsg('Email already exist', 'warning');
    }elseif ($cell_cheek > 1){
        $mass = validationmsg('Cell already exist', 'warning');
    }elseif ($uname_cheek > 1){
        $mass = validationmsg('Uname already exist', 'warning');
    }else {

        //photo getting
        $photo_name='';
        if (empty($_FILES['new_photo']['name'])){
            $photo_name=$_POST['old_photo'];
        }else{
            $file_name=$_FILES['new_photo']['name'];
            $file_tmp_name=$_FILES['new_photo']['tmp_name'];

            $photo_name=md5(time().rand()).$file_name;

            move_uploaded_file($file_tmp_name,'photos/students/'.$photo_name);
            unlink('photos/students/'.$edit_photo);
        }
        update("UPDATE users SET name ='$name',email='$email',cell='$cell',uname='$uname',password='$hash_pass',photo='$photo_name',status='$status' WHERE id='$edit_id'");

        $mass = validationmsg('update success', 'warning');
    }
    if (isset($_GET['edit_id'])){
        $edit_id=$_GET['edit_id'];
        $sql = "SELECT * FROM users WHERE id='$edit_id'";
        $data = $conn->query($sql);
        $all_data = $data->fetch_assoc();
    }

    ?>
	

	<div class="wrap">
        <a class="btn btn-sm btn-primary" href="users.php">Back</a>
		<div class="card shadow">
			<div class="card-body">
				<h2>Update your account</h2>
                <?php include 'templates/message.php';?>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Name</label>
						<input name="name" class="form-control" type="text" value="<?php echo $all_data['name']; ?>">
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input name="email" class="form-control" type="text" value="<?php echo $all_data['email']; ?>">
					</div>
					<div class="form-group">
						<label for="">Cell</label>
						<input name="cell" class="form-control" type="text" value="<?php echo $all_data['cell']; ?>">
					</div>
					<div class="form-group">
						<label for="">Username</label>
						<input name="uname" class="form-control" type="text" value="<?php echo $all_data['uname']; ?>">
					</div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input name="pass" class="form-control" type="password" value="<?php echo $all_data['password']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Passwor</label>
                        <input name="cpass" class="form-control" type="password" value="<?php echo $all_data['password']; ?>">
                    </div>
                    <div class="form-group">
                        <img  style="width: 100px;" src="photos/students/<?php echo $all_data['photo']; ?>" alt="">
                        <input name="old_photo" value="<?php echo $all_data['photo']; ?>" class="form-control-file" type="hidden">
                    </div>
                    <div class="form-group">
                        <label for="">Profile photo</label>
                        <input name="new_photo" class="form-control-file" type="file">
                    </div>
                    <div class="form-group">
                        <input name="status" value="agree" checked type="checkbox"  id="agree"><label for="agree">I agree to go</label>
                    </div>
					<div class="form-group">
						<input name="add" class="btn btn-primary" type="submit" value="update now">
					</div>
				</form>
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