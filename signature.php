<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <?php include 'Assets/header.html'; ?>

    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Formulir Pengiriman Data</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="owner_info" class="form-label">Informasi Pemilik:</label>
                    <input type="text" class="form-control" id="owner_info" name="owner_info" required>
                </div>
                <div class="mb-3">
                    <label for="encryption_method" class="form-label">Metode Enkripsi:</label>
                    <select class="form-select" id="encryption_method" name="encryption_method" required>
                        <option value="3des_aes">3DES & AES</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
    </body>
</html>


<?php
require '../phpqrcode/qrlib.php';

// Fungsi untuk enkripsi data menggunakan 3DES
function encrypt_3des($data, $key) {
    $iv_length = openssl_cipher_iv_length('des-ede3-cbc');
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($data, 'des-ede3-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Fungsi untuk enkripsi data menggunakan AES
function encrypt_aes($data, $key) {
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Fungsi untuk enkripsi data menggunakan 3DES dan AES secara berurutan
function encrypt_3des_aes($data, $key) {
    $first_encryption = encrypt_3des($data, $key);
    $second_encryption = encrypt_aes($first_encryption, $key);
    return $second_encryption;
}

// Fungsi untuk menyematkan QR code pada gambar
function embed_qr_on_image($image_path, $qr_code_path, $output_path) {
    $image = imagecreatefromjpeg($image_path);
    $qr_code = imagecreatefrompng($qr_code_path);

    // Mendapatkan dimensi gambar dan QR code
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $qr_width = imagesx($qr_code);
    $qr_height = imagesy($qr_code);

    // Menempatkan QR code di sudut kanan bawah gambar
    $dest_x = $image_width - $qr_width - 10;
    $dest_y = $image_height - $qr_height - 10;
    imagecopy($image, $qr_code, $dest_x, $dest_y, 0, 0, $qr_width, $qr_height);

    // Menyimpan gambar keluaran
    imagejpeg($image, $output_path);

    // Membersihkan memori
    imagedestroy($image);
    imagedestroy($qr_code);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $owner_info = $_POST['owner_info'];
    $encryption_method = $_POST['encryption_method'];
    $image_path = $_FILES['image']['tmp_name'];
    $output_path = 'output_image.jpg';

    $key = 'your_secret_key'; // Ganti dengan kunci rahasia Anda

    if ($encryption_method == '3des') {
        $encrypted_data = encrypt_3des($owner_info, $key);
    } else if ($encryption_method == 'aes') {
        $encrypted_data = encrypt_aes($owner_info, $key);
    } else if ($encryption_method == '3des_aes') {
        $encrypted_data = encrypt_3des_aes($owner_info, $key);
    }

    // Generate QR code dari data terenkripsi
    $qr_code_path = 'qrcode.png';
    QRcode::png($encrypted_data, $qr_code_path);

    // Embed QR code pada gambar
    embed_qr_on_image($image_path, $qr_code_path, $output_path);

    echo "Gambar dengan QR code telah dibuat: <a href='$output_path'>Download</a>";
}
?>