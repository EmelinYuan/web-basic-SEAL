<?php require_once('template/header.php'); ?>
<?php require_once 'config.php'; ?>
<?php 
$username = null;
if(isset($_SESSION['id'])){
  header('location: index.php');
}
if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $pass = $_POST['password'];

  $sql = "SELECT * FROM users WHERE role='user' AND username='$username' AND password='$pass'";
  $res = $conn->query($sql);
  if ($res->num_rows>0) {
    $user = $res->fetch_object();
    $_SESSION['username'] = $user->username;
    $_SESSION['name'] = $user->name;
    $_SESSION['id'] = $user->id;
    $_SESSION['role'] = $user->role;

    header('location: index.php');
  }
}
?>

 <div class="container">
  <div class="row">
    <div class="col-md-4 mt-4 p-0 mx-auto">
      <h3 class="text-center">Login</h3>
      <p class="text-success"><?php if(isset($_GET['reg'])){ echo 'Registrasi Berhasil, Silahkan login'; }?></p>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
      <div class="form-group p-0 mb-2">
        <input type="text" name="username" class="form-control" placeholder="Username"  autocomplete="off" value="<?=$username?>">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" autocomplete="off">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="submit" name="submit" class="form-control btn btn-primary" value="Masuk">
      </div>
      </form>
    </div>
  </div>
</div>
<?php require_once 'template/footer.php'; ?>
