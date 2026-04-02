<?php 
include "../../base/chech.php";  
include "../../base/main.php"; 
session_start(); 

function createPolybiusSquare() {
    $letters = array_merge(range('A', 'Z'), range('a', 'z'));
    $square = [];
    foreach ($letters as $index => $letter) {
        $row = intval($index / 5);
        $col = $index % 5;
        $square[$letter] = ($row + 1) . ($col + 1);
    }
    return $square;
}

function polybiusEncrypt($input) {
    $square = createPolybiusSquare();
    $output = '';
    foreach (str_split($input) as $char) {
        if (isset($square[$char])) {
            $output .= $square[$char] . ' ';
        } elseif ($char === ' ') {
            $output .= '00 ';
        }
    }
    return trim($output);
}

function polybiusDecrypt($input) {
    $square = createPolybiusSquare();
    $output = '';
    $pairs = explode(' ', $input);
    $reversedSquare = array_flip($square);
    
    foreach ($pairs as $pair) {
        if (isset($reversedSquare[$pair])) {
            $output .= $reversedSquare[$pair];
        } elseif ($pair === '00') {
            $output .= ' ';
        }
    }
    return $output;
}

$encryptedMessage = '';
$decryptedMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encrypt'])) {
        $encryptedMessage = polybiusEncrypt($_POST['message']);
    } elseif (isset($_POST['decrypt'])) {
        $decryptedMessage = polybiusDecrypt($_POST['message']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polybius Square Cipher</title>
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
        <h1>Polybius Square Cipher</h1>
        <form method="POST" action="">
            <lable for ="text">Enter Text: (A-Z and a-z and Space)</lable>
            <input type ="text" name="message" placeholder="Enter message..." required></input>
            <button type="submit" name="encrypt">Encrypt</button>
            <br>
            <button type="submit" name="decrypt">Decrypt</button>
        </form>
        <?php if ($encryptedMessage): ?>
            <h2>Encrypted Message:</h2>
            <p><?php echo htmlspecialchars($encryptedMessage); ?></p>
        <?php endif; ?>
        <?php if ($decryptedMessage): ?>
            <h2>Decrypted Message:</h2>
            <p><?php echo htmlspecialchars($decryptedMessage); ?></p>
        <?php endif; ?>
        <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
            
            <div id="description">
                <p>Polybius Square Cipher Description
The Polybius Square cipher is a classical substitution encryption technique that utilizes a 5x5 grid to encode letters into pairs of numbers. This method is distinct in that it operates on a fixed square, where each letter corresponds to a unique coordinate, making it a straightforward yet effective means of encryption.

To encrypt a message, the alphabet is arranged into a 5x5 grid, with letters represented by their respective row and column numbers. For instance, the letters A-Z (and a-z, treating them as distinct) are assigned positions in the grid, with spaces represented as a special character (e.g., '00'). For example, in a grid where A is in the first row and first column (1,1), the letter 'B' is at (1,2), 'C' at (1,3), and so forth. The result is a mapping where each letter is transformed into a two-digit number.

Decryption reverses this process, translating each pair of numbers back into the corresponding letters using the same 5x5 grid. This process preserves the original case of letters and allows for clear representation of spaces, making it user-friendly.

The Polybius Square cipher is an early form of encryption that is simple to implement yet illustrates the fundamental principles of substitution ciphers. It serves as an educational tool in cryptography, highlighting how structured systems can secure communication through straightforward transformations while maintaining a consistent mapping throughout the message. Despite its simplicity, the Polybius Square cipher offers valuable insights into the evolution of more complex encryption methods.</p>
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
