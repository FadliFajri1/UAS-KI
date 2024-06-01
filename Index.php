<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <?php include 'Assets/header.html'; ?>

    <div class="row">
        <div class="col" style="position:relative; left:30px; top:50px;">
            <h2>How To Use</h2>
        </div>
        <div class="col md d-flex justify-content-end">
            <img src="Assets/img/example.jpg" class="rounded" alt="" style="height: 600px; width: 400px; position:relative; top:50px; right:50px;">
        </div>
    </div>
    <div class="row" style="position:relative; top:-480px; left:40px;">
        <h4>Signature</h4>
    </div>
    <div class="row" style="position:relative; top:-470px; left:40px;">
        <div class="col">
            <h6>Masukan informasi pemilik</h6>
            <h6>Pilih gambar yang ingin diberi signature</h6> 
            <h6>Submit</h6> 
            <h6>Download Gambar</h6>
        </div>
    </div>
    <div class="row" style="position:relative; top:-350px; left:40px;">
        <h4>Verification</h4>
    </div>
    <div class="row" style="position:relative; top:-340px; left:40px;">
        <div class="col">
            <h6>Masukan teks yang keluar setelah menscan qr code</h6>
            <h6>Dekripsi</h6> 
            <h6>Muncul informasi pemilik</h6> 
        </div>
        <div class="col md d-flex justify-content-end">
            <img src="Assets/img/qrcode.png" class="rounded" alt="" style="height: 130px; width: 130px; position:relative; top:70px; right:100px;">
        </div>
    </div>
    </body>
</html>