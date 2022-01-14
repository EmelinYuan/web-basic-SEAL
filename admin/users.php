
<?php 
require_once '../config.php'; 
session_start();
// print_r($_POST);
// die;

if(isset($_POST['submit'])){
	if($_POST['name'] != '' and $_POST['email'] != '' and $_POST['username'] != '' and $_POST['password'] != ''){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$sql = "INSERT INTO users(name, email, username, password, role) VALUES('$name', '$email', '$username', '$password', '$role')";
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
	if($_POST['name'] != '' and $_POST['email'] != '' and $_POST['username'] != '' and $_POST['password'] != ''){
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$id = $_POST['id'];
		$sql = "UPDATE users SET  name='$name', email='$email', username='$username', password='$password', role='$role' WHERE id='$id'";
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
	$sql = "DELETE FROM users WHERE id='$id'";
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
$user_sql = "SELECT * FROM users WHERE name LIKE '%$keyword%' OR username LIKE '%$keyword%' OR email LIKE '%$keyword%' LIMIT $mulai, $halaman";
$user_list = $conn->query($user_sql);
if (!$user_list) {
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
						<th>Usename</th>
						<th>Email</th>
						<th>Role</th>
						<th>Aksi</th>
					</tr>

					<?php $n=$mulai+1; while($row = $user_list->fetch_object()):  ?>
					<tr>
						<td class="text-center" ><?=$n?></td>
						<td><?=$row->name?></td>
						<td><?=$row->username?></td>
						<td><?=$row->email?></td>
						<td><?=$row->role?></td>
						<td class="text-end">
							<div class="btn-group">
								<button data-bs-toggle="modal" 
								onclick="fillUpdate('<?=$row->name?>','<?=$row->username?>','<?=$row->email?>','<?=$row->password?>','<?=$row->role?>','<?=$row->id?>')" 
								data-bs-target="#update-modal"  
								type="button" class="btn btn-sm btn-warning float-right">Update</button>
								<a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$row->id?>" type="button" class="btn btn-sm btn-danger float-right">Delete</a>
							</div>

						</td>
					</tr>
				<?php $n++; endwhile ?>
			</table>
		</div>
		<div class="row">
			<!-- PHP PAGINATION -->
			<?php 
			$total = $conn->query("SELECT * FROM users WHERE name LIKE '%$keyword%' OR username LIKE '%$keyword%' OR email LIKE '%$keyword%'")->num_rows;
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
					<div class="from-group mb-2">
						<label for="nama">Nama</label>
						<input type="text" class="form-control" id="name" name="name">
						<input type="hidden" id="id" name="id">
					</div>
					<div class="from-group mb-2">
						<label for="nama">Username</label>
						<input type="text" class="form-control" id="username" name="username">
					</div>
					<div class="from-group mb-2">
						<label for="nama">Email</label>
						<input type="email" class="form-control" id="email" name="email">
					</div>

					<div class="from-group mb-2">
						<label for="nama">Password</label>
						<input type="text" class="form-control" id="password" name="password">
					</div>
					<div class="from-group mb-2">
						<label for="role">Role</label>
						<select id="role" name="role" id="" class="form-control">
							<option value="admin">Admin</option>
							<option value="user">User</option>
						</select>
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
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<div class="from-group mb-2">
						<label for="nama">Nama</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="from-group mb-2">
						<label for="nama">Username</label>
						<input type="text" class="form-control" name="username">
					</div>
					<div class="from-group mb-2">
						<label for="nama">Email</label>
						<input type="email" class="form-control" name="email">
					</div>

					<div class="from-group mb-2">
						<label for="nama">Password</label>
						<input type="text" class="form-control" name="password">
					</div>
					<div class="from-group mb-2">
						<label for="role">Role</label>
						<select name="role" id="" class="form-control">
							<option value="admin">Admin</option>
							<option value="user">User</option>
						</select>
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

	function fillUpdate(name, username, email, password, role, id){
		const named = $('#name')
		const usernamed = $('#username')
		const emaild = $('#email')
		const passwordd = $('#password')
		const roled = $('#role')
		const idd = $('#id')
		named.val(name)
		usernamed.val(username)
		emaild.val(email)
		passwordd.val(password)
		roled.val(role)
		idd.val(id)
	}

</script>