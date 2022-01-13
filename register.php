<?php require_once('template/header.php'); ?>
<?php require_once 'config.php'; ?>

<?php 
if(isset($_SESSION['id'])){
  header('location: index.php');
}
$error =null;
$name   = null;
$username   = null;
$email  = null;
$password1  = null;
$password2  = null;
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  // if password match
  if($password2 === $password1){

    // chech if email is existsor  if username exists
    $sql = "SELECT * FROM users WHERE role='user' AND email='$email' OR username='$username'";
    $res = $conn->query($sql);
    if ($res->num_rows<1) {
      // check clear do insert
      $insert_sql = "INSERT INTO users (name, username, email, password, role) 
      VALUES('$name', '$username', '$email', '$password1', 'user')";
      $res_insert = $conn->query($insert_sql);
      if ($res_insert) {
        header('location: login.php?reg=true');
      }
    }else{
      $error = "username atau email sudah digunakan";
    }
  }else{
    $error = "Password tidak sama";
  }

}
?>


<div class="container">
  <div class="row">
    <div class="col-md-4 mt-4 p-0 mx-auto">
      <h3 class="text-center">Daftar</h3>
      <p class="text-danger"><?php if($error!=null){ echo $error; }?></p>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
      <div class="form-group p-0 mb-2">
        <input type="text" name="name" value="<?=$name?>" class="form-control" placeholder="Nama Lengkap">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="text" name="username" value="<?=$username?>" class="form-control" placeholder="Username">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="email" name="email" value="<?=$email?>" class="form-control" placeholder="Email">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="password" name="password1" value="<?=$password1?>" class="form-control" placeholder="Kata Sandi">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="password" name="password2" value="<?=$password2?>" class="form-control" placeholder="Konfirmasi Kata Sandi">
      </div>
      <div class="form-group p-0 mb-2">
        <input type="submit" name="submit" class="form-control btn btn-primary" value="Daftar">
      </div>
      </form>
    </div>
  </div>
</div>
<?php require_once 'template/footer.php'; ?>
