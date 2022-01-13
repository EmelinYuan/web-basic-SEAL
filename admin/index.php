<?php 
session_start();
if($_SESSION['role']!='admin')header('location: login.php');
require_once 'template/header.php';
require_once 'template/sidebar.php'; 
require_once '../config.php'; 

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

			<?php $n=0; while($row = $order_list->fetch_object()): ?>
			<tr>
				<td><?=$n?></td>
				<td><?=$row->name?></td>
				<td><?=$row->username?></td>
				<td><?=$row->email?></td>
				<td><?=$row->name_pricelist?>x<?=$row->qty?>=<?=$row->qty*$row->price?></td>
				<td></td>
			</tr>
		<?php endwhile ?>
		</table>
			</div>
		</div>
	</div>
</div>
<?php require_once 'template/footer.php'; ?>