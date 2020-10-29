<?php include_once 'app/autoload.php';
session_start();
?>
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
if (isset($_GET['delete_id'])){
    $delete_photo=$_GET['photo'];
    $delete_id=$_GET['delete_id'];
    $sql="DELETE FROM users WHERE id='$delete_id'";
    $conn->query($sql);
    unlink('photos/students/'. $delete_photo);

    setcookie('user_log_id','',time()-(60*60*24*365));
    setcookie('relog_id','',time()-(60*60*24*365));
    session_destroy();
    header('location:login.php');
}


?>
	<div class="wrap-table">
        <a class="btn btn-primary" href="profile.php">Your profile</a>
		<div class="card shadow">
			<div class="card-body">
				<h2>All Data</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Cell</th>
							<th>Photo</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    $sql="SELECT * FROM users";
                    $data=$conn->query($sql);
                     $i=1;
                    while ($all_data=$data->fetch_assoc()):
                    ?>
						<tr>
							<td><?php echo $i; $i++;?></td>
							<td><?php echo $all_data['name'];?></td>
							<td><?php echo $all_data['email'];?></td>
							<td><?php echo $all_data['cell'];?></td>
							<td><img src="photos/students/<?php echo $all_data['photo'];?>" alt=""></td>
							<td>

                                <?php if ($all_data['id']==$_SESSION['id']) :?>
								<a class="btn btn-sm btn-warning" href="edit.php?edit_id=<?php echo $all_data['id'];?>&edite_photo=<?php echo $all_data['photo'];?>">Edit</a>
								<a class="btn btn-sm btn-danger" href="?delete_id=<?php echo $all_data['id'];?>&photo=<?php echo $all_data['photo'];?>">Delete</a>
                                <?php else:?>
                                    <a class="btn btn-sm btn-info" href="profile.php?view_id=<?php echo $all_data['id'];?>">View</a>
                                <?php endif;?>
							</td>
						</tr>
                    <?php endwhile;?>
					</tbody>
				</table>
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