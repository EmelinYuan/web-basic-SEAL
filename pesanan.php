<?php require_once('template/header.php'); ?>
<?php require_once('config.php'); ?>
<?php 
// create 
if (isset($_POST['submit'])) {
  $barang = $_POST['barang'];
  $jumlah = $_POST['jumlah'];
  $id_user = $_SESSION['id'];
  $tgl = date('d-m-Y H:i:s');
  $sql = "INSERT INTO order_list(id_user, id_pricelist, qty, date_created, status) VALUES('$id_user', '$barang', '$jumlah', '$tgl', 'on proccess')";
  $res = $conn->query($sql);
  if ($res) {
    unset($_POST);
    header('location:'.$_SERVER['PHP_SELF']);
  }
}

if (isset($_GET['del'])) {
  $id = $_GET['del'];
  $sql = "DELETE FROM order_list where id_order='$id'";
  $res  = $conn->query($sql);
  if ($res) {
    header('location:'.$_SERVER['PHP_SELF']);
  }
}


$id = $_SESSION['id'];
$sql = "SELECT users.*, pricelist.*, order_list.* FROM order_list INNER JOIN users ON order_list.id_user=users.id INNER JOIN pricelist ON order_list.id_pricelist=pricelist.id_pricelist where order_list.id_user='$id'";
$cheat_list = $conn->query($sql);
$price_sql = "SELECT * FROM pricelist";
$price_list = $conn->query($price_sql);
?>
  <!--Untuk Home-->
  
        <h1 align="center">Daftar Pesanan Anda</h1>
        <hr>
        <div class="row">
        <div class="col-md-3 mx-auto ">
          <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            Buat pesanan baru : 
            <select name="barang" id="barang" class="form-control mb-2">
              <?php while($row = $price_list->fetch_object()): ?>
              <option value="<?=$row->id_pricelist?>"><?=$row->name_pricelist?></option>
            <?php endwhile?>
            </select>
            <label for="">Jumlah :</label>
            <input type="number" class="form-control mb-2" name="jumlah" required autocomplete="off">
            <input type="submit" name="submit" value="Order" onclick="return confirm('Buat pesanan?')">
          </form>
        </div>
        <div class="col-md-8"> 
              <table class="table">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Barang</th>
                  <th>jumlah</th>
                  <th>Total Harga</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                <?php $n=0; while ($row = $cheat_list->fetch_object()): $n++; ?>
                <tr>
                    <td><?=$n?></td>
                    <td><?=$row->date_created?></td>
                    <td><?=$row->name_pricelist?></td>
                    <td><?=$row->qty?></td>
                    <td>Rp. <?=number_format($row->qty*$row->price, 0, ',', '.')?>,-</td>
                    <td><?=$row->status?></td>
                    <td>
                      <?php if($row->status=='on proccess'): ?>
                        <a href="?del=<?=$row->id_order?>" onclick="return confirm('Batalkan pesanan?')">Batalkan</a>
                      <?php endif?>
                    </td>
                </tr>
                <?php endwhile; ?>
              </table> 
        </div> 
        </div>
  
<?php require_once 'template/footer.php'; ?>
    