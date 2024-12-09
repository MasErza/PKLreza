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

// Tangkap data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namakaryawan = $_POST['namakaryawan'];
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

    // Query untuk menambahkan data ke tabel tbbulan
    $total = $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $des;
    $sql = "INSERT INTO tbbulan (namakaryawan, Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Des, total) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error dalam prepare statement: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param(
        'siiiiiiiiiiiii', // 1 string + 12 integer
        $namakaryawan, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $des, $total
    );

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>
