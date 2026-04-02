<?php 
include "../../base/chech.php";  
include "../../base/main.php"; 
session_start(); 

function generateKey($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $key;
}

function oneTimePadEncrypt($plaintext, $key) {
    $ciphertext = '';
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $p = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $plaintext[$i]);
        $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$i]);
        if ($p !== false && $k !== false) {
            $c = ($p + $k) % 63;
            $ciphertext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$c];
        } else {
            $ciphertext .= $plaintext[$i];
        }
    }
    return $ciphertext;
}

function oneTimePadDecrypt($ciphertext, $key) {
    $plaintext = '';
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $c = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $ciphertext[$i]);
        $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$i]);
        if ($c !== false && $k !== false) {
            $p = ($c - $k + 63) % 63;
            $plaintext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$p];
        } else {
            $plaintext .= $ciphertext[$i];
        }
    }
    return $plaintext;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['text'];
    $key = $_POST['key'];
    
    if (strlen($key) < strlen($text)) {
        $key = generateKey(strlen($text));
    }

    $encrypted = oneTimePadEncrypt($text, $key);
    $decrypted = oneTimePadDecrypt($text, $key);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>One-Time Pad Cipher</title>
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
            <h1>One-Time Pad Cipher</h1>
            <form method="post">
                <label for="text">Text:</label><br>
                <input type="text" id="text" name="text" required><br>
                <label for="key">Key (optional):</label><br>
                <input type="text" id="key" name="key"><br><br>
                <input type="submit" value="Encrypt & Decrypt">
            </form>
            <?php if (isset($encrypted)): ?>
                <h3>Encrypted Text:</h3>
                <p><?php echo htmlspecialchars($encrypted); ?></p>
                <h3>Decrypted Text:</h3>
                <p><?php echo htmlspecialchars($decrypted); ?></p>
                <h3>Used Key:</h3>
                <p><?php echo htmlspecialchars($key); ?></p>
            <?php endif; ?>
            <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
                
            <div id="description">
                <p>One-Time Pad Cipher Description
The One-Time Pad cipher is a theoretically unbreakable encryption technique that employs a randomly generated key that is as long as the message being encrypted. This method is unique in that each letter of the plaintext is combined with a corresponding letter from a random key, ensuring that the key is used only once and never reused for any other message.

To encrypt a message, each character in the plaintext is matched with a character in the key, with both characters mapped to their respective positions in a predefined set of characters (e.g., A-Z, a-z, and space). For example, if the plaintext character is 'A' (position 0) and the key character is 'B' (position 1), the resulting ciphertext character is determined by adding their positions modulo the total number of characters. This means that each letter is effectively shifted in the alphabet by the value of the corresponding key character, resulting in a ciphertext that appears random and is difficult to decode without knowledge of the key.

Decryption is accomplished by reversing this process. Each character of the ciphertext is matched with the corresponding character in the key, and their positions are subtracted to retrieve the original plaintext. This process preserves the case of letters and spaces, ensuring that the original message is accurately restored.

The One-Time Pad cipher exemplifies the principles of perfect secrecy in cryptography. As long as the key is truly random, at least as long as the message, and kept secret, the ciphertext generated offers no information about the plaintext, making it a robust choice for secure communications. However, the practical challenges of generating, distributing, and securely managing the keys limit its widespread use in modern encryption applications. Despite these challenges, the One-Time Pad remains a foundational concept in the study of cryptography, illustrating the importance of randomness and secrecy in achieving secure communication.</p>
            </div>
            <br>
                
            <a href ="../index.php">Home</a>
        </div>
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
        <script src="https://theme.house-778.theorangecow.org/background.js"></script>
        <script src="https://house-778.theorangecow.org/base/main.js"></script>
        <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
    </body>
</html>
