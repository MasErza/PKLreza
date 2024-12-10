<?php
// Pastikan sesi hanya dimulai jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'True') {
    echo "<script>alert('Silakan login terlebih dahulu.');</script>";
    header("Location: login.php");
    exit;
}

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bendahara';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Logika Hapus Transaksi
if (isset($_GET['delete'])) {
    // Periksa apakah pengguna adalah admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "<script>
        alert('Akses ditolak! Hanya admin yang dapat menghapus transaksi.');
        window.location.href = 'transaksi.php'; // Redirect dengan JavaScript
        </script>";
        exit;
    }

    $id_transaksi = intval($_GET['delete']);
    $sqlDelete = "DELETE FROM transaksi WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sqlDelete);

    if ($stmt) {
        $stmt->bind_param('i', $id_transaksi);
        if ($stmt->execute()) {
            echo "<script>alert('Transaksi berhasil dihapus!');</script>";
            header("Location: transaksi.php");
            exit;
        } else {
            echo "<script>alert('Gagal menghapus transaksi: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyiapkan query: " . $conn->error . "');</script>";
    }
}

// Logika Tambah Transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah pengguna adalah admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "<script>alert('Akses ditolak! Hanya admin yang dapat menambahkan transaksi.');
        window.location.href = 'transaksi.php'; // Redirect dengan JavaScript
        </script>";
        exit;
    }

    $tipe = $_POST['tipe'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    // Validasi tipe transaksi
    if (!in_array($tipe, ['pemasukan', 'pengeluaran'])) {
        echo "<script>alert('Tipe transaksi tidak valid! Harus berupa pemasukan atau pengeluaran.');</script>";
    } else {
        $sqlInsert = "INSERT INTO transaksi (tipe, jumlah, keterangan, tanggal) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);

        if ($stmt) {
            $stmt->bind_param('sdss', $tipe, $jumlah, $keterangan, $tanggal);
            if ($stmt->execute()) {
                echo "<script>alert('Transaksi berhasil ditambahkan!');</script>";
                header("Location: transaksi.php");
                exit;
            } else {
                echo "<script>alert('Gagal menambahkan transaksi: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal menyiapkan query: " . $conn->error . "');</script>";
        }
    }
}

// Ambil data transaksi
$sqlTransaksi = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$resultTransaksi = $conn->query($sqlTransaksi);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi</title>
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
                <h1 class="mt-4">Daftar Transaksi</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Transaksi
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="tipe">Tipe Transaksi</label>
                                <select name="tipe" id="tipe" class="form-control" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="pemasukan">Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
                        </form>
                        <table class="table table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultTransaksi->num_rows > 0): ?>
                                    <?php while ($row = $resultTransaksi->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['tipe'] ?></td>
                                            <td>Rp<?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                            <td><?= $row['tanggal'] ?></td>
                                            <td><?= $row['keterangan'] ?></td>
                                            <td>
                                                <a href="transaksi.php?delete=<?= $row['id_transaksi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Tidak ada data transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
