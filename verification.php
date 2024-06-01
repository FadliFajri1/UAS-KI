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
                <h2 class="mb-4 text-center">Dekripsi Data</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="encrypted_data" class="form-label">Data Terenkripsi:</label>
                        <textarea id="encrypted_data" name="encrypted_data" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="decryption_method" class="form-label">Metode Dekripsi:</label>
                        <select id="decryption_method" name="decryption_method" class="form-select">
                            <option value="3des_aes">3DES dan AES</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <input type="submit" value="Dekripsi" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>

<?php
require '../phpqrcode/qrlib.php';

// Fungsi untuk dekripsi data menggunakan 3DES
function decrypt_3des($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'des-ede3-cbc', $key, 0, $iv);
}

// Fungsi untuk dekripsi data menggunakan AES
function decrypt_aes($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

// Fungsi untuk dekripsi data yang dienkripsi menggunakan 3DES dan AES secara berurutan
function decrypt_3des_aes($data, $key) {
    $first_decryption = decrypt_aes($data, $key);
    $second_decryption = decrypt_3des($first_decryption, $key);
    return $second_decryption;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $encrypted_data = $_POST['encrypted_data'];
    $decryption_method = $_POST['decryption_method'];

    $key = 'your_secret_key'; // Ganti dengan kunci rahasia Anda

    if ($decryption_method == '3des') {
        $decrypted_data = decrypt_3des($encrypted_data, $key);
    } else if ($decryption_method == 'aes') {
        $decrypted_data = decrypt_aes($encrypted_data, $key);
    } else if ($decryption_method == '3des_aes') {
        $decrypted_data = decrypt_3des_aes($encrypted_data, $key);
    }

    echo "Data setelah dekripsi: " . htmlspecialchars($decrypted_data);
}
?>
