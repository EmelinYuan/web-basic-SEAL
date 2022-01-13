<?php require_once 'template/header.php' ?>
<?php 
session_start();
if(isset($_SESSION['id']))header('location: index.php');
$error = null;
require_once '../config.php';
if(isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM users WHERE role='admin' AND username='$username' AND password='$password'";
	$res = $conn->query($sql);
	if ($res->num_rows>0) {
		$user = $res->fetch_object();
		$_SESSION['username'] 	= $user->username;
		$_SESSION['name'] 		= $user->name;
		$_SESSION['id'] 		= $user->id;
		$_SESSION['role'] 		= $user->role;
	}else{
		$error = "Username atau password salah";
	}
}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-5 mx-auto p-4">
			<main class="form-signin mt-5">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<h1 class="h3 mb-4 fw-normal">Please sign in</h1>
					<p class="text-danger"><?=$error!=null?$error:''?></p>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="username" id="floatingInput" placeholder="username">
						<label for="floatingInput">Username</label>
					</div>
					<div class="form-floating mb-3">
						<input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
						<label for="floatingPassword">Password</label>
					</div>

					<div class="checkbox mb-3">
						<label>
							<input type="checkbox" value="remember-me"> Remember me
						</label>
					</div>
					<input class="w-100 btn btn-lg btn-primary" type="submit" name="submit" value="Login">
					<p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
				</form>
			</main>
		</div>
	</div>
</div>
<?php require_once 'template/footer.php' ?>