<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bendahara';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Hitung total pemasukan dari tabel transaksi
$sqlTotalPemasukan = "SELECT SUM(jumlah) AS total_pemasukan FROM transaksi WHERE tipe = 'pemasukan'";
$resultTotalPemasukan = $conn->query($sqlTotalPemasukan);
$totalPemasukan = 0;
if ($resultTotalPemasukan->num_rows > 0) {
    $row = $resultTotalPemasukan->fetch_assoc();
    $totalPemasukan = $row['total_pemasukan'];
}

// Hitung total pengeluaran dari tabel transaksi
$sqlTotalPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM transaksi WHERE tipe = 'pengeluaran'";
$resultTotalPengeluaran = $conn->query($sqlTotalPengeluaran);
$totalPengeluaran = 0;
if ($resultTotalPengeluaran->num_rows > 0) {
    $row = $resultTotalPengeluaran->fetch_assoc();
    $totalPengeluaran = $row['total_pengeluaran'];
}


// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Hitung total pengeluaran dari tabel transaksi
$sqlTotalPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM transaksi WHERE tipe = 'pengeluaran'";
$resultTotalPengeluaran = $conn->query($sqlTotalPengeluaran);
$totalPengeluaran = 0;
if ($resultTotalPengeluaran->num_rows > 0) {
    $row = $resultTotalPengeluaran->fetch_assoc();
    $totalPengeluaran = $row['total_pengeluaran'];
}


// Hitung total dari tabel tbbulan (jumlah uang masuk per bulan per karyawan)
$sqlTotalTbbulan = "SELECT SUM(Jan + Feb + Mar + Apr + May + Jun + Jul + Aug + Sep + Oct + Nov + Des) AS total_bulanan FROM tbbulan";
$resultTotalTbbulan = $conn->query($sqlTotalTbbulan);
$totalBulanan = 0;
if ($resultTotalTbbulan->num_rows > 0) {
    $row = $resultTotalTbbulan->fetch_assoc();
    $totalBulanan = $row['total_bulanan'];
}

// Hitung total pemasukan dari tabel transaksi
$sqlTotalPemasukan = "SELECT SUM(jumlah) AS total_pemasukan FROM transaksi WHERE tipe = 'pemasukan'";
$resultTotalPemasukan = $conn->query($sqlTotalPemasukan);
$totalPemasukan = 0;
if ($resultTotalPemasukan->num_rows > 0) {
    $row = $resultTotalPemasukan->fetch_assoc();
    $totalPemasukan = $row['total_pemasukan'];
}

// Hitung total keseluruhan (saldo bersih)
$totalKeseluruhan = ($totalBulanan + $totalPemasukan) - $totalPengeluaran;

// Hitung total pemasukan dari tabel transaksi
$sqlTotalPemasukan = "SELECT SUM(jumlah) AS total_pemasukan FROM transaksi WHERE tipe = 'pemasukan'";
$resultTotalPemasukan = $conn->query($sqlTotalPemasukan);
$totalPemasukan = 0;
if ($resultTotalPemasukan->num_rows > 0) {
    $row = $resultTotalPemasukan->fetch_assoc();
    $totalPemasukan = $row['total_pemasukan'];
}

// Hitung total pengeluaran dari tabel transaksi
$sqlTotalPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM transaksi WHERE tipe = 'pengeluaran'";
$resultTotalPengeluaran = $conn->query($sqlTotalPengeluaran);
$totalPengeluaran = 0;
if ($resultTotalPengeluaran->num_rows > 0) {
    $row = $resultTotalPengeluaran->fetch_assoc();
    $totalPengeluaran = $row['total_pengeluaran'];
}
?>

<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bendahara';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari tabel tbbulan
$sql = "SELECT * FROM tbbulan";
$result = $conn->query($sql);

// Cek hak akses pengguna (contoh sederhana dengan session)
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Proses input data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari form
    $jan = $_POST['jan'] ?? 0;
    $feb = $_POST['feb'] ?? 0;
    $mar = $_POST['mar'] ?? 0;
    $apr = $_POST['apr'] ?? 0;
    $may = $_POST['may'] ?? 0;
    $jun = $_POST['jun'] ?? 0;
    $jul = $_POST['jul'] ?? 0;
    $aug = $_POST['aug'] ?? 0;
    $sep = $_POST['sep'] ?? 0;
    $oct = $_POST['oct'] ?? 0;
    $nov = $_POST['nov'] ?? 0;
    $des = $_POST['des'] ?? 0;
    $nourut = $_POST['nourut']; // Pastikan ID baris dikirim melalui form

    // Query untuk memperbarui data di tabel
    $sql = "UPDATE tbbulan SET 
            Jan = ?, Feb = ?, Mar = ?, Apr = ?, May = ?, Jun = ?, 
            Jul = ?, Aug = ?, Sep = ?, Oct = ?, Nov = ?, Des = ? 
            WHERE nourut = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'iiiiiiiiiiiii',
        $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $des, $nourut
    );

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Dashboard</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Home
                    </a>
                    <a class="nav-link" href="transaksi.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Transaksi
                    </a>
                    <div class="sb-sidenav-menu-heading"></div>
                    <div class="sb-sidenav-menu-heading"></div>
                    <div class="sb-sidenav-menu-heading"></div>
                    <a href="logout.php" class="btn btn-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Home</h1>

                <!-- Tabel tbbulan -->
                <div class="card mb-4">
                    <div class="card-header">
    <i class="fas fa-table mr-1"></i>
    UANGKAS DEPT QA TAHUN 2024
    <?php if ($isAdmin): ?>
        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">Tambah Data</button>
    <?php endif; ?>
</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Januari</th>
                                        <th>Februari</th>
                                        <th>Maret</th>
                                        <th>April</th>
                                        <th>Mei</th>
                                        <th>Juni</th>
                                        <th>Juli</th>
                                        <th>Agustus</th>
                                        <th>September</th>
                                        <th>Oktober</th>
                                        <th>November</th>
                                        <th>Desember</th>
                                        <?php if ($isAdmin): ?>
                                            <th>Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['nourut'] ?></td>
                                                <td><?= $row['namakaryawan'] ?></td>
                                                <td>Rp<?= number_format($row['Jan'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Feb'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Mar'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Apr'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['May'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Jun'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Jul'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Aug'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Sep'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Oct'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Nov'], 0, ',', '.') ?></td>
                                                <td>Rp<?= number_format($row['Des'], 0, ',', '.') ?></td>
                                                <?php if ($isAdmin): ?>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row['nourut'] ?>">Edit</button>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>

                                            <!-- Modal Edit Data -->
                                            <div class="modal fade" id="editModal<?= $row['nourut'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Data Bulanan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="edit_tbbulan.php">
                                                                <input type="hidden" name="nourut" value="<?= $row['nourut'] ?>">
                                                                <?php foreach (['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'des'] as $month): ?>
                                                                    <div class="form-group">
                                                                        <label for="<?= $month ?>"><?= ucfirst($month) ?></label>
                                                                        <input type="number" class="form-control" id="<?= $month ?>" name="<?= $month ?>" value="<?= $row[ucfirst($month)] ?>">
                                                                    </div>
                                                                <?php endforeach; ?>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="15" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
</table>
<!-- Tabel Total Keseluruhan Uang Masuk -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-bar mr-1"></i>
        Total Keseluruhan Uang Masuk
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Total Uang Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rp<?= number_format($totalKeseluruhan, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<?php if ($isAdmin): ?>
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Bulanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_tbbulan.php">
                    <div class="form-group">
                        <label for="namakaryawan">Nama Karyawan</label>
                        <input type="text" class="form-control" id="namakaryawan" name="namakaryawan" required>
                    </div>
                    <?php foreach (['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'des'] as $month): ?>
                        <div class="form-group">
                            <label for="<?= $month ?>"><?= ucfirst($month) ?></label>
                            <input type="number" class="form-control" id="<?= $month ?>" name="<?= $month ?>" required>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Tambah</button>

                    <!-- Tabel Total Keseluruhan Uang Masuk -->
                    <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-bar mr-1"></i>
        Total Keseluruhan Uang Masuk
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Total Uang Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rp<?= number_format($totalKeseluruhan, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Reza Agustian Kusnadi</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
<?php
$conn->close();
?>
