<?php 
include "../../base/check.php";  
include "../../base/main.php"; 
session_start(); 

function scytaleCipher($text, $key) {
    $text = preg_replace('/[^A-Za-z\s]/', '', $text);
    $length = strlen($text);
    $rows = ceil($length / $key);
    $ciphertext = '';

    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $key; $j++) {
            $index = $i + $j * $rows;
            if ($index < $length) {
                $ciphertext .= $text[$index];
            }
        }
    }

    return $ciphertext;
}



function scytaleDecipher($ciphertext, $key) {
    $length = strlen($ciphertext);
    $rows = ceil($length / $key);
    $text = str_repeat(' ', $length);
    
    $index = 0;
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $key; $j++) {
            $pos = $i + $j * $rows;
            if ($pos < $length) {
                $text[$pos] = $ciphertext[$index];
                $index++;
            }
        }
    }

    return $text;
}






$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $key = (int)$_POST['key'];
    $mode = $_POST['mode'];
    
    if ($mode == 'encrypt') {
        echo "here";
        $result = scytaleCipher($message, $key);
    } else {
        echo "hi";
        $result = scytaleDecipher($message, $key);
    }
    

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scytale Cipher</title>
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
            <h1>Scytale Cipher</h1>
            <form method="POST">
                <label for="message">Message: (A-Z and a-z and SPACE)</label>
                <input type="text" id="message" name="message" required>
                <label for="key">Key (Number of Columns):</label>
                <input type="number" id="key" name="key" min="1" required>
                <label for="mode">Select mode:</label>
                <select name="mode" id="mode" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
                <button type="submit" name="action" value="Submit">Submit</button>
            </form>
            <?php if ($result): ?>
                <h2>Result:</h2>
                <p><?php echo htmlspecialchars($result); ?></p>
            <?php endif; ?>
            <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
            <div id="description">
                <p>The Scytale cipher is an ancient encryption technique that involves wrapping a strip of parchment around a cylindrical object, creating a unique pattern for encoding messages. Each letter of the plaintext is arranged in rows according to a specified number of columns, or key. For instance, if the key is 3, the letters are written in three vertical columns. To encrypt, the message is read vertically from top to bottom, creating a ciphertext that appears scrambled.</p>
                <p>During decryption, the process is reversed: the ciphertext is arranged back into the specified number of columns, and the message is read horizontally to reveal the original text. This method is relatively simple but effective, relying on the physical arrangement of letters. The Scytale cipher was used by the ancient Greeks and Romans for secure communication, demonstrating the enduring principles of transposition in cryptography.</p>
            </div>
            <br>
            <a href="../index.php">Home</a>
        </div>
        <script>
            function toggleDescription() {
                var description = document.getElementById("description");
                description.style.display = description.style.display === "none" ? "block" : "none";
            }
        </script>
        
        <script src="https://theme.house-778.theorangecow.org/background.js"></script>
        <script src="https://house-778.theorangecow.org/base/main.js"></script>
        <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
    </body>
</html>
