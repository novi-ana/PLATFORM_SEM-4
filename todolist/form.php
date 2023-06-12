<!DOCTYPE html>
<html>
<head>
	<title>APLIKASI TO-DO LIST</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		body {
			background-color: pink;
		}

		@keyframes slide-up {
			from {
				transform: translateY(100%);
			}
			to {
				transform: translateY(0);
			}
		}

		.slide-up-animation {
			animation: slide-up 1s ease-out;
		}
	</style>
</head>

<body>
	<?php
		$database = "tododb";
		$username = "root";
		$password = "";
		$hostname = "localhost";
		$conn = new mysqli($hostname, $username, $password, $database);
		if($conn->connect_error) {
		    die("Connection failed : " . $conn->connect_error);
		}

		// Insert new task to database
		if (isset($_POST['tambah'])) {
			$kegiatan = $_POST['keg'];
			$sql = "INSERT INTO todolist (kegiatan, status) VALUES ('$kegiatan', 'aktif')";
			if ($conn->query($sql) === TRUE) {
				header("Location: " . $_SERVER['PHP_SELF']);
				exit();
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}

		// Update task status to done
		if (isset($_GET['selesai'])) {
			$id = $_GET['selesai'];
			$sql = "UPDATE todolist SET status='selesai' WHERE idkegiatan=$id";
			if ($conn->query($sql) === TRUE) {
				header("Location: " . $_SERVER['PHP_SELF']);
				exit();
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}

		// Delete task from database
		if (isset($_GET['hapus'])) {
			$id = $_GET['hapus'];
			$sql = "DELETE FROM todolist WHERE idkegiatan=$id";
			if ($conn->query($sql) === TRUE) {
				header("Location: " . $_SERVER['PHP_SELF']);
				exit();
			} else {
				echo "Error deleting record: " . $conn->error;
			}
		}

	?>

	<div class="container p-3 mb-2 bg-light border border-4 border-dark w-50 p-5 slide-up-animation">
		<h3 class="mb-4"><b>APLIKASI TO-DO LIST</b></h3>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<p>
				<label for="keg">Masukan Kegiatan: </label><br>
				<input name="keg" id="keg" type="text">
				<input name="tambah" type="submit" value="Tambahkan">
			</p>
		</form>

		<p>
			<label for="daftarkeg">Daftar Kegiatan: </label><br>
			<?php
				// Display list of tasks from database
				$sql = "SELECT * FROM todolist";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					echo "<table class='table'>";
					echo "<thead><tr><th>No</th><th>Kegiatan</th><th>Status</th><th>Aksi</th></tr></thead>";
					echo "<tbody>";
					while($row = $result->fetch_assoc()) {
						echo "<tr><td>" . $row["idkegiatan"] . "</td><td>" . $row["kegiatan"] . "</td><td>" . $row["status"] . "</td><td>";
						if ($row["status"] == "aktif") {
							echo "<a href='" . $_SERVER['PHP_SELF'] . "?selesai=" . $row["idkegiatan"] . "'>Selesai</a> ";
						}
						echo "<a href='" . $_SERVER['PHP_SELF'] . "?hapus=" . $row["idkegiatan"] . "'>Hapus</a>";
						echo "</td></tr>";
					}
					echo "</tbody></table>";
				} else {
					echo "Tidak ada kegiatan yang tersimpan.";
					$sql = "ALTER TABLE todolist AUTO_INCREMENT=1";
					$query = mysqli_query($conn, $sql);
				}
			?>
		</p>
	</div>
</body>
</html>
