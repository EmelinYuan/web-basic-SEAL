<?php require_once('template/header.php'); ?>
<?php require_once('config.php'); ?>
<?php 
$sql = "SELECT * FROM pricelist";
$cheat_list = $conn->query($sql);
?>
  <div class="container">
    <h2 align="center">Daftar Harga</h2>
    <div class="row">
      <?php while($row = $cheat_list->fetch_object()): ?>
      <div class="card col-md-3 m-4 p-0">
        <div class="card-body text-center">
          <h1><?=$row->name_pricelist?></h1>
        </div>
        <div class="card-footer bg-dark text-white text-center p-0 m-0">
          <p class="p-0 m-1">Rp. <?=number_format($row->price,0,',','.')?>,-</p>
        </div>
      </div>
    <?php endwhile?>
    </div>
  </div>
<?php require_once 'template/footer.php'; ?>
    