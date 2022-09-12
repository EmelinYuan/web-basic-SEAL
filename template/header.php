<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VVIP ENJOYERS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/davito1.css">
</head>
<body>
  <nav>
    <div class="wrapper">
      <div class="logo"><a href=''>HOLADOC ! </a></div>
      <div class="menu">
        <ul>
          <li><a  href = "index.php">Home</a></li>
          <li><a href = "listcheat.php">List Cheat</a></li>
          <li><a href = "price.php">Price</a></li>
          <li><a href = "contact.php">Contact</a></li>
            
          <?php if (!isset($_SESSION['id'])):?>
          <li><a href="login.php" class="tbl-biru">Sign In</a></li>
          <li><a href="register.php">Sign Up</a></li>
        <?php else: ?>
          <li><a href = "pesanan.php">Pesanan</a></li>
          <li><a href = "#" style="padding: 0px;"><?=$_SESSION['name']?></a></li>
          <li><a href = "logout.php">Logout</a></li>
        <?php endif ?>
        </ul>
      </div>
      </ul>
    </div>
  </nav>