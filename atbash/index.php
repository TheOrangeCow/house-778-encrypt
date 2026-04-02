<?php 
include "../../base/chech.php";  
include "../../base/main.php"; 
session_start();

function atbashCipher($input) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ';
    $reversedAlphabet = strrev($alphabet);

    $output = '';
    
    foreach (str_split($input) as $char) {
        if (ctype_upper($char) || $char === ' ') {
            $pos = strpos($alphabet, $char);
            $output .= $reversedAlphabet[$pos];
        } elseif (ctype_lower($char)) {
            $upperChar = strtoupper($char);
            $pos = strpos($alphabet, $upperChar);
            $output .= strtolower($reversedAlphabet[$pos]);
        } else {
            $output .= $char;
        }
    }
    
    return $output;
}

$action = '';
$resultText = '';
if (isset($_POST['action']) && isset($_POST['text'])) {
    $action = $_POST['action'];
    $text = $_POST['text'];

    if ($action === 'encrypt') {
        $resultText = atbashCipher($text);
    } elseif ($action === 'decrypt') {
        $resultText = atbashCipher($text);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Atbash Cipher</title>
        <link rel="stylesheet" href="../style.css"> 
        <link rel="stylesheet" href="https://house-778.theorangecow.org/base/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <link rel="icon" href="https://house-778.theorangecow.org/base/icon.ico" type="image/x-icon">
    </head>
    <body>
        <canvas class="back" id="canvas"></canvas>
        <?php include '../../base/sidebar.php'; ?> 
        <div class="con">
            <button class="circle-btn" onclick="openNav()">☰</button> 
            <h1>Atbash Cipher</h1>
            <form method="post" action="">
                <label for="text">Enter text: (A-Z and a-z and SPACE)</label>
                <input type="text" id="text" name="text" required>
                
                <br>

                <label for="action">Choose action:</label>
                <select id="action" name="action" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
                <br>

                <button type="submit">Process</button>
            </form>

            <?php if ($resultText): ?>
                <h2>Resulting Text:</h2>
                <p><?php echo htmlspecialchars($resultText); ?></p>
            <?php endif; ?>
            <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
            
            <div id="description">
                <p>The Atbash cipher is a classical encryption technique where each letter in the alphabet is mapped to its reverse counterpart. For example, 'A' becomes 'Z', 'B' becomes 'Y', and so on. This cipher is simple and works the same way for both encryption and decryption because of its symmetric nature.</p>
            </div>
            <br>
            <a href ="../index.php">Home</a>
        </div>
        
    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
    <script>
        function toggleDescription() {
            var description = document.getElementById("description");
            if (description.style.display === "none") {
                description.style.display = "block";
            } else {
                description.style.display = "none";
            }
        }
    </script>
    </body>
</html>
