<?php 
session_start();
if($_SESSION['role']!='admin')header('location: login.php');
require_once 'template/header.php';
require_once 'template/sidebar.php'; 
require_once '../config.php'; 

if (isset($_GET['del'])) {
  $id = $_GET['del'];
  $sql = "DELETE FROM order_list where id_order='$id'";
  $res  = $conn->query($sql);
  if ($res) {
    header('location:'.$_SERVER['PHP_SELF']);
  }
}

if (isset($_GET['acc'])) {
  $id = $_GET['acc'];
  $sql = "UPDATE order_list SET status='accepted' where id_order='$id'";
  $res  = $conn->query($sql);
  if ($res) {
    header('location:'.$_SERVER['PHP_SELF']);
  }
}

$order_sql = "SELECT users.*, pricelist.*, order_list.* FROM order_list INNER JOIN users ON order_list.id_user=users.id INNER JOIN pricelist ON order_list.id_pricelist=pricelist.id_pricelist";
$order_list = $conn->query($order_sql);
if (!$order_list) {
	echo $conn->error;
}


?>
<div class="col p-3 m-2">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h2>Daftar Pesanan</h2>
			</div>
			<div class="card-body">
		<table class="table table-responsive table-striped table-bordered">
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>username</th>
				<th>email</th>
				<th>Barang</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>

			<?php $n=0; while($row = $order_list->fetch_object()): $n++; ?>
			<tr>
				<td><?=$n?></td>
				<td><?=$row->name?></td>
				<td><?=$row->username?></td>
				<td><?=$row->email?></td>
				<td><b><?=$row->name_pricelist?></b> x <small><?=$row->qty?></small> = <?=number_format($row->qty*$row->price, 0, ',', '.')?></td>
				<td><?=$row->status?></td>
				<td>
					<?php if($row->status=='on proccess'): ?>
                        <a href="?acc=<?=$row->id_order?>" onclick="return confirm('Konfirmasi pesanan?')">Konfirmasi</a>
                        <a style="color: red;" href="?del=<?=$row->id_order?>" onclick="return confirm('Batalkan pesanan?')">Batalkan</a>
                      <?php endif?>
				</td>
			</tr>
		<?php endwhile ?>
		</table>
			</div>
		</div>
	</div>
</div>
<?php require_once 'template/footer.php'; ?>