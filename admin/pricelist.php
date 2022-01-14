
<?php 
require_once '../config.php'; 
session_start();
// print_r($_POST);
// die;

if(isset($_POST['submit'])){
	if($_POST['name_pricelist'] != '' and $_POST['price'] != ''){
		$name = $_POST['name_pricelist'];
		$price = $_POST['price'];
		$sql = "INSERT INTO pricelist(name_pricelist, price) VALUES('$name', '$price')";
		$res = $conn->query($sql);
		if(!$res){
			echo $conn->error; print_r($res); die;
		}else{
			unset($_POST);
			header("Location: ".$_SERVER['PHP_SELF']);
		}
	}
}

if(isset($_GET['update'])){
	if($_POST['name_pricelist'] != '' and $_POST['id_pricelist'] != '' and $_POST['price']){
		
		$name = $_POST['name_pricelist'];
		$price = $_POST['price'];
		$id = $_POST['id_pricelist'];
		$sql = "UPDATE pricelist SET name_pricelist='$name', price='$price' WHERE id_pricelist='$id'";
		$res = $conn->query($sql);
		if(!$res){
			echo $conn->error; print_r($res); die;
		}else{
			unset($_POST);
		    header("Location: ".$_SERVER['PHP_SELF']);
		}
	}
}

if(isset($_GET['del'])){
	$id = $_GET['del'];
	$sql = "DELETE FROM pricelist WHERE id_pricelist='$id'";
	$res = $conn->query($sql);
	if(!$res){
		echo $conn->error; print_r($res); die;
	}else{
		header("Location: ".$_SERVER['PHP_SELF']);
	}
}


?>
<?php 
if($_SESSION['role']!='admin')header('location: login.php');
require_once 'template/header.php';
require_once 'template/sidebar.php'; 

$halaman = 10; //batasan halaman
$page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;

$keyword = '';
if (isset($_GET['search'])) {
	$keyword = $_GET['search'];
}
$price_sql = "SELECT * FROM pricelist WHERE name_pricelist LIKE '%$keyword%' LIMIT $mulai, $halaman";
$price_list = $conn->query($price_sql);
if (!$price_list) {
	echo $conn->error;
}
?>

<div class="col p-3 m-2">
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between">
				<h2 class="">Daftar Harga</h2>
				<div class="form-add d-flex align-items-end">
					<button class="btn btn-xs btn-primary float-right " data-bs-toggle="modal" data-bs-target="#add-modal" id="btn-add-new">New</button>
				</div>
			</div>
			<div class="card-body">
				<div class="row  justify-content-end mb-3">
						<div class="col-md-4">
					<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
							<div class="form-group input-group">
								<input type="search" placeholder="Masukan Kata Kunci" name="search" class="form-control" value="<?=isset($_GET['search'])?$keyword:''; ?>">
								<button type="submit" class="btn btn-secondary">Cari</button>
							</div>
					</form>
						</div>
				</div>
				<?=isset($_GET['search'])?"<p>Hasil pencarian untuk <b>$keyword</b></p>":''; ?>
				<table class="table table-responsive table-striped table-bordered">
					<tr class="text-center">
						<th>No</th>
						<th>Nama</th>
						<th>Harga</th>
						<th>Aksi</th>
					</tr>

					<?php $n=$mulai+1; while($row = $price_list->fetch_object()):  ?>
					<tr>
						<td class="text-center" ><?=$n?></td>
						<td><?=$row->name_pricelist?></td>
						<td>Rp. <?=number_format($row->price,0,',','.')?></td>
						<td class="text-end">
							<div class="btn-group">
								<button data-bs-toggle="modal" onclick="fillUpdate('<?=$row->name_pricelist?>','<?=$row->price?>','<?=$row->id_pricelist?>')" data-bs-target="#update-modal"  type="button" class="btn btn-sm btn-warning float-right">Update</button>
								<a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$row->id_pricelist?>" type="button" class="btn btn-sm btn-danger float-right">Delete</a>
							</div>

						</td>
					</tr>
				<?php $n++; endwhile ?>
			</table>
		</div>
		<div class="row">
			<!-- PHP PAGINATION -->
			<?php 
			$total = $conn->query("SELECT * FROM pricelist WHERE name_pricelist LIKE '%$keyword%'")->num_rows;
			$pages = ceil($total/$halaman); 
			?>
			<nav aria-label="Page navigation">
			  <ul class="pagination justify-content-end m-2">
			  	<li class="page-item">
			  			<button class="page-link" disabled="true" style="color: black;">	
					  			Page :
			  			</button>
			  	</li>
			  		
			<?php for ($i=1; $i<=$pages ; $i++): ?>
			    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?=$i?></a></li>
			<?php endfor; ?>

			  </ul>
			</nav>
		</div>
	</div>
</div>
</div>

<!-- modal -->
<div class="modal fade" tabindex="-1" id="update-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?=$_SERVER['PHP_SELF']?>?update=true" method="POST">
					<div class="from-group mb-3">
						<label for="nama">Nama Cheat</label>
						<input type="text" class="form-control" id="name_pricelist" name="name_pricelist">
						<input type="hidden" class="form-control" id="id_pricelist" name="id_pricelist">
					</div>
					<div class="from-group mb-3">
						<label for="nama">Harga Cheat</label>
						<input type="text" class="form-control" id="price-input" name="price">
					</div>
					<input type="submit" class="btn btn-primary" value="Update">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

				</form>
			</div>
		</div>
	</div>
</div>
<!-- modal Add -->
<div class="modal fade" tabindex="-1" id="add-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?=$_SERVER['PHP_SELF']?>?update=true" method="POST">
					<div class="from-group mb-2">
						<label for="nama">Nama Cheat</label>
						<input type="text" class="form-control" name="name_pricelist">
					</div>
					<div class="from-group mb-2">
						<label for="nama">Harga</label>
						<input type="number" class="form-control"name="price" autocomplete="off">
					</div>
					<input type="submit" class="btn btn-primary" name="submit" value="Add">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

				</form>
			</div>
		</div>
	</div>
</div>
<?php require_once 'template/footer.php'; ?>
<script type="text/javascript">

	function fillUpdate(name, price, id){
		const name_pricelist = $('#name_pricelist')
		const priceinp = $('#price-input')
		const id_pricelist = $('#id_pricelist')
		name_pricelist.val(name)
		priceinp.val(price)
		id_pricelist.val(id)
	}

</script>