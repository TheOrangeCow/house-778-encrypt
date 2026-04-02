<?php 
include "../base/chech.php"; 
include "../base/main.php";
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Encrypt</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://house-778.theorangecow.org/base/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <link rel="icon" href="https://house-778.theorangecow.org/base/icon.ico" type="image/x-icon">
    </head>
    <body>
        <canvas class="back" id="canvas"></canvas>
        <?php include '../base/sidebar.php'; ?>
        <div class="con">
            <button class="circle-btn" onclick="openNav()">☰</button> 
            <h1>Wellcome <?php echo $_SESSION["username"] ?> to encrypt</h1>
            <p>What encrypt would you like to use?</p>
            <ul>
                <li><a href ="image">Image cypher</a></li>
                <li><a href ="caesar">Caesar cypher</a></li>
                <li><a href ="vigenere">Vigenere cypher</a></li>
                <li><a href ="scytale">Scytale cypher</a></li>
                <li><a href ="polybius_square">Polybius square cypher</a></li>
                <li><a href ="pigpen">Pigpen cypher</a></li>
                <li><a href ="one-time_pad">One-time pad cypher</a></li>
                <li><a href ="monoalphabetic">Monoalphabetic cypher</a></li>
                <li><a href ="atbash">Atbash cypher</a></li>
                
            </ul>
        </div>
        
    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
    </body>
</html>
