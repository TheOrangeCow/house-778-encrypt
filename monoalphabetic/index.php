<?php 
include "../../base/chech.php";  
include "../../base/main.php"; 
session_start(); 

function createCipherAlphabet() {
    $alphabet = range('A', 'Z');
    $lowerAlphabet = range('a', 'z');
    
    $alphabet[] = ' ';
    $lowerAlphabet[] = ' ';
    
    $shuffledAlphabet = $alphabet;
    shuffle($shuffledAlphabet);
    $shuffledLowerAlphabet = $lowerAlphabet;
    shuffle($shuffledLowerAlphabet);
    
    return [
        'upper' => array_combine($alphabet, $shuffledAlphabet),
        'lower' => array_combine($lowerAlphabet, $shuffledLowerAlphabet)
    ];
}

function encrypt($plaintext, $cipher) {
    $ciphertext = '';
    
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $char = $plaintext[$i];
        
        if (ctype_upper($char)) {
            $ciphertext .= $cipher['upper'][$char];
        } elseif (ctype_lower($char)) {
            $ciphertext .= $cipher['lower'][$char];
        } else {
            $ciphertext .= $char;
        }
    }
    
    return $ciphertext;
}

function decrypt($ciphertext, $cipher) {
    $plaintext = '';
    
    $upperToLower = array_flip($cipher['upper']);
    $lowerToUpper = array_flip($cipher['lower']);
    
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $char = $ciphertext[$i];
        
        if (ctype_upper($char)) {
            $plaintext .= $upperToLower[$char];
        } elseif (ctype_lower($char)) {
            $plaintext .= $lowerToUpper[$char];
        } else {
            $plaintext .= $char;
        }
    }
    
    return $plaintext;
}

if (!isset($_SESSION['cipher'])) {
    $_SESSION['cipher'] = createCipherAlphabet();
}

$cipher = $_SESSION['cipher'];
$ciphertext = '';
$plaintext = '';
$decryptedText = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    
    if (!empty($_POST['text'])) {
        if ($action === "Encrypt") {
            $plaintext = $_POST['text'];
            $ciphertext = encrypt($plaintext, $cipher);
        } elseif ($action === "Decrypt") {
            $ciphertext = $_POST['text'];
            $decryptedText = decrypt($ciphertext, $cipher);
        }
    } else {
        $errorMessage = "Please enter text to encrypt or decrypt.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monoalphabetic Cipher</title>
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
        <h1>Monoalphabetic Cipher</h1>
        <form method="POST" action="">
            <label for="text">Enter text: (A-Z and a-z and Space)</label>
            <input type="text" name="text" placeholder="Enter text here..."><br>
            <input type="submit" name="action" value="Encrypt"><br>
            <input type="submit" name="action" value="Decrypt">
        </form>
        <h2>Result:</h2>
        <p>Plaintext: <?php echo htmlspecialchars($plaintext); ?></p>
        <p>Ciphertext: <?php echo htmlspecialchars($ciphertext); ?></p>
        <p>Decrypted Text: <?php echo htmlspecialchars($decryptedText); ?></p>
        <?php if (isset($errorMessage)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <br> 
        <button onclick="toggleDescription()">Show/Hide Description</button>
        
        <div id="description">
            <p>
Monoalphabetic Cipher Description
The Monoalphabetic cipher is a substitution encryption technique where each letter in the plaintext is replaced with a corresponding letter from a fixed shuffled alphabet. Unlike more complex ciphers, this method uses a single key throughout the entire message, which means the same plaintext letter will always be replaced by the same ciphertext letter.

To encrypt a message, a randomly shuffled alphabet is generated, creating a unique mapping for each letter, including spaces. For example, if the original alphabet is A-Z and the shuffled alphabet is X-Y-Z-A-B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W, then every instance of 'A' in the plaintext would be replaced by 'X', 'B' by 'Y', and so on. Spaces are treated like letters, so they also undergo the same substitution, adding an additional layer of complexity.

Decryption reverses this process: the ciphertext is analyzed, and each letter is replaced with its corresponding plaintext letter based on the same shuffled alphabet. This method is straightforward yet effective, making it easy to implement while still providing a level of security. The Monoalphabetic cipher is one of the earliest known encryption methods and remains a fundamental concept in the study of cryptography, illustrating the principles of substitution and the importance of maintaining a consistent key for secure communication.</p>
        </div>
        <br>
        
        <a href="../index.php">Home</a>
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
