
<?php 
require_once '../config.php'; 
session_start();
// print_r($_POST);
// die;

if(isset($_POST['submit'])){
	if($_POST['cheat_name'] != ''){
		$name = $_POST['cheat_name'];
		$sql = "INSERT INTO cheatlist(cheat_name) VALUES('$name')";
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
	if($_POST['cheat_name'] != '' and $_POST['id_cheat'] != ''){
		$name = $_POST['cheat_name'];
		$id = $_POST['id_cheat'];
		$sql = "UPDATE cheatlist SET cheat_name='$name' WHERE id_cheat='$id'";
		$res = $conn->query($sql);
		if(!$res){
			echo $conn->error; print_r($res); die;
		}else{
			unset($_POST);
		    // header("Location: ".$_SERVER['PHP_SELF']);
		}
	}
}

if(isset($_GET['del'])){
	$id = $_GET['del'];
	$sql = "DELETE FROM cheatlist WHERE id_cheat='$id'";
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
$cheat_sql = "SELECT * FROM cheatlist WHERE cheat_name LIKE '%$keyword%' LIMIT $mulai, $halaman";
$cheat_list = $conn->query($cheat_sql);
if (!$cheat_list) {
	echo $conn->error;
}
?>

<div class="col p-3 m-2">
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between">
				<h2 class="">Daftar Cheat</h2>
				<div class="form-add d-flex align-items-end">
					<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
						<div class="input-group hidden" id="input-new-cheat">
							<script type="text/javascript">
								$('#input-new-cheat').hide()
							</script>
							<input type="text" name="cheat_name" id="cheat-name" class="form-control" placeholder="Masukan Nama Cheat" required>
							<input type="submit" value="&check;" name="submit" class="btn btn-xs btn-success float-right">
							<button class="btn btn-xs btn-danger float-right" id="btn-add-cancel">&times;</button>
						</div>
					</form>
					<button class="btn btn-xs btn-primary float-right " data-mdb-toggle="animation" data-mdb-animation-reset="true" data-mdb-animation="slide-out-right" id="btn-add-new">New</button>
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
						<th>Aksi</th>
					</tr>

					<?php $n=$mulai+1; while($row = $cheat_list->fetch_object()):  ?>
					<tr>
						<td class="text-center" ><?=$n?></td>
						<td><?=$row->cheat_name?></td>
						<td class="text-end">
							<div class="btn-group">
								<button data-bs-toggle="modal" onclick="fillUpdate('<?=$row->cheat_name?>','<?=$row->id_cheat?>')" data-bs-target="#update-modal"  type="button" class="btn btn-sm btn-warning float-right">Update</button>
								<a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$row->id_cheat?>" type="button" class="btn btn-sm btn-danger float-right">Delete</a>
							</div>

						</td>
					</tr>
				<?php $n++; endwhile ?>
			</table>
		</div>
		<div class="row">
			<!-- PHP PAGINATION -->
			<?php 
			$total = $conn->query("SELECT * FROM cheatlist WHERE cheat_name LIKE '%$keyword%'")->num_rows;
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
						<input type="text" class="form-control" id="cheat_name" name="cheat_name">
						<input type="hidden" class="form-control" id="id_cheat" name="id_cheat">
					</div>
					<input type="submit" class="btn btn-primary" value="Update">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

				</form>
			</div>
		</div>
	</div>
</div>
<?php require_once 'template/footer.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){
		const btnAdd = $('#btn-add-new')
		const btnCancel = $('#btn-add-cancel')
		const form = $('#input-new-cheat')
		form.hide()
		btnAdd.on('click', function(){
			btnAdd.hide()
			form.fadeIn()
		})

		btnCancel.on('click', function(event){
			btnAdd.fadeIn()
			form.hide()
			event.preventDefault()
		})
	})

	function fillUpdate(name, id){
		const cheat_name = $('#cheat_name')
		const id_cheat = $('#id_cheat')
		cheat_name.val(name)
		id_cheat.val(id)
	}
</script>