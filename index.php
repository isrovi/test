<?php 

include 'koneksi.php';
session_start();

if (isset($_POST['simpan'])) {
	if ($_POST['id'] == "") {
		$nama_produk = $_POST['nama_produk'];
		$keterangan = $_POST['keterangan'];
		$harga = $_POST['harga'];
		$jumlah = $_POST['jumlah'];

		$query = "INSERT INTO produk (nama_produk,keterangan,harga,jumlah)VALUES('$nama_produk','$keterangan',$harga,$jumlah)";
		$sql = mysqli_query($conn, $query);
		if ($sql) {
			$_SESSION['alert'] = "Berhasil menambahkan data";
			$_SESSION['type'] = "success";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}else{
			$_SESSION['alert'] = "Gagal menambahkan data";
			$_SESSION['type'] = "danger";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}
	}else {
		$id = $_POST['id'];
		$nama_produk = $_POST['nama_produk'];
		$keterangan = $_POST['keterangan'];
		$harga = $_POST['harga'];
		$jumlah = $_POST['jumlah'];

		$query = "UPDATE produk SET nama_produk='$nama_produk', keterangan='$keterangan', harga=$harga, jumlah=$jumlah WHERE  id=$id";
		$sql = mysqli_query($conn, $query);
		if ($sql) {
			$_SESSION['alert'] = "Berhasil mengubah data";
			$_SESSION['type'] = "success";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}else{
			$_SESSION['alert'] = "Gagal mengubah data";
			$_SESSION['type'] = "danger";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}
	}
}

if (isset($_GET['hapus']) && isset($_GET['id'])) {
	$id = $_GET['id'];

	$query = "DELETE FROM produk WHERE id=$id";
	$sql = mysqli_query($conn, $query);
		if ($sql) {
			$_SESSION['alert'] = "Berhasil menghapus data";
			$_SESSION['type'] = "success";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}else{
			$_SESSION['alert'] = "Gagal menghapus data";
			$_SESSION['type'] = "danger";
			?>
			<script>
				window.location.href="index.php"
			</script>
			<?php
		}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CRUD PRODUK</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<div class="container">
		<?php 
		if (isset($_GET['tambah']) OR isset($_GET['ubah'])) {
			$id= "";
			$nama_produk = "";
			$keterangan = "";
			$harga = "";
			$jumlah = "";

			if (isset($_GET['ubah']) && isset($_GET['id'])) {
				$id = $_GET['id'];
				$query = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
				while ($row = mysqli_fetch_object($query)) {
					$id=$row->id;
					$nama_produk=$row->nama_produk;
					$keterangan=$row->keterangan;
					$harga=$row->harga;
					$jumlah=$row->jumlah;
				}
			}

			?>
			<?php
			if(isset($_GET['tambah'])){
				$page = "Form Tambah";	
			}else {
				$page = "Form Ubah";
			}	
			?>
			<h3 class="mt-5"><?=$page ?></h3>
			<hr>
			<form method="post">
				<div class="col-lg-12 mt-3">
					<input type="hidden" name="id" value="<?=$id ?>">
					<div class="form-group">
						<label for="">Nama Produk</label>
						<input type="text" class="form-control" name="nama_produk" placeholder="nama produk" value="<?=$nama_produk ?>">
					</div>
					<div class="form-group">
						<label for="">Keterangan</label>
						<input type="text" class="form-control" name="keterangan" placeholder="keterangan" value="<?=$keterangan ?>">
					</div>
					<div class="form-group">
						<label for="">harga</label>
						<input type="number" class="form-control" name="harga" placeholder="harga" value="<?=$harga ?>">
					</div>
					<div class="form-group">
						<label for="">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" placeholder="jumlah" value="<?=$jumlah ?>">
					</div>
					<button type="submit" name="simpan" class="btn btn-success">Simpan</button>
					<a href="index.php" class="btn btn-primary">Kembali</a>
				</div>
			</form>
		<?php }else{ ?>
			<?php if (isset($_SESSION['alert'])): ?>
				<div class="alert alert-<?=$_SESSION['type']; ?> alert-dismissible fade show mt-5" role="alert">
					<?=$_SESSION['alert']; unset($_SESSION['alert']); ?>
				</div>
			<?php endif ?>
			<div class="bg-secondary p-3 mt-5">
				<a href="index.php?tambah" class="btn btn-success">Tambah Produk</a>
			</div>

			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama Produk</th>
						<th>Keterangan</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$query = mysqli_query($conn, "SELECT * FROM produk");
					$no = 1;
					while($row = mysqli_fetch_object($query)){
						?>
						<tr>
							<td><?=$no++  ?></td>
							<td><?=$row->nama_produk ?></td>
							<td><?=$row->keterangan ?></td>
							<td><?=$row->harga ?></td>
							<td><?=$row->jumlah ?></td>
							<td><a href="index.php?ubah&id=<?=$row->id ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="fa fa-edit"></i></a>
								<a href="index.php?hapus&id=<?=$row->id ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus" onclick="return confirm('Apakah ingin menghapusnya?')"><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

	</body>
	</html>