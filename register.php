<?php 
    include "service/database.php";
    session_start();

    $register_message = "";

    if(isset($_SESSION["is_login"])){
        header("location: dashboard.php");
    }


    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $nama = $_POST["nama_pasien"];
        $email = $_POST["email"];
        $no_hp = $_POST["no_hp"];
        $password = $_POST["password"];

        $hash_password = hash("md5", $password);

        try{
            $sql = "INSERT INTO pasien (username, nama_pasien, email, no_telepon, password) VALUES ('$username', '$nama', '$email', $no_hp, '$hash_password')";

        if($db->query($sql)){
            $register_message = "Registrasi Berhasil, silakan login";
        }else{
            $register_message = "Registrasi gagal, silakan ulangi kembali";
        }

        }catch(mysqli_sql_exception $e){
            $register_message = $e;
        }
        $db->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "layout/header.html" ?>
    <?= $register_message ?>
    <form action="register.php" method="POST">
    <input type="text" placeholder= "Username" name="username"/>
        <input type="text" placeholder= "Nama" name="nama_pasien"/>
        <input type="text" placeholder= "E-mail" name="email"/>
        <input type="number" placeholder= "Nomor Handphone" name="no_hp"/>
        <input type="password" placeholder= "Password" name="password"/>
        <button type="submit" name="register">Daftar</button>
    </form>
    <?php include "layout/footer.html" ?>
</body>
</html>