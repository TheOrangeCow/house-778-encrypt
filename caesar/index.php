<?php 
include "../../base/chech.php"; 
include "../../base/main.php";
session_start(); 


function caesarCipher($text, $shift, $mode = 'encrypt') {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ';
    $charLength = strlen($characters);
    $result = "";


    if ($mode === 'decrypt') {
        $shift = $charLength - ($shift % $charLength);
    }

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $pos = strpos($characters, $char);
        if ($pos !== false) {
            $newPos = ($pos + $shift) % $charLength;
            $result .= $characters[$newPos];
        } 
        else {
            $result .= $char;
        }
    }
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    $shift = $_POST['shift'];
    $mode = $_POST['mode'];
    
    $outputText = caesarCipher($inputText, $shift, $mode);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Caesar Cipher</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://house-778.theorangecow.org/base/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <link rel="icon" href="https://house-778.theorangecow.org/base/icon.ico" type="image/x-icon">
        <script>
            function validateShift() {
                const shiftInput = document.getElementById('shift');
                let value = parseInt(shiftInput.value);
                if (value < 1) {
                    shiftInput.value = 1;
                } else if (value > 53) {
                    shiftInput.value = 53;
                }
            }
        </script>
    </head>
    <body>
        <canvas class="back" id="canvas"></canvas>
        <?php include '../../base/sidebar.php'; ?>
        <div class="con">
            <button class="circle-btn" onclick="openNav()">☰</button> 
            <h1>Caesar Cipher</h1>
            <form method="POST">
                <label for="text">Enter text: (A-Z and a-z and SPACE)</label>
                <input type="text" name="text" id="text" required>
                
                <br>
                
                <label for="shift">Enter key: (1-53):</label>
                <input type="number" name="shift" id="shift" min="1" max="53" required oninput="validateShift()">
                
                <br>
                
                <label for="mode">Select mode:</label>
                <select name="mode" id="mode" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
                
                <br>
                
                <button type="submit">Submit</button>
            </form>

            <?php if (isset($outputText)): ?>
                <h2>Result:</h2>
                <p><?php echo htmlspecialchars($outputText); ?></p>
            <?php endif; ?>
            
            <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
            
            <div id="description">
                <p>The Caesar cipher is a classical encryption technique where each letter in the alphabet is shifted by a fixed number of positions. For example, with a shift of 3, 'A' becomes 'D', 'B' becomes 'E', and so on. Both uppercase and lowercase letters are shifted, while non-alphabetic characters (like punctuation or spaces) can be ignored or preserved. The same shift is applied for decryption but in reverse, making it a straightforward substitution cipher. It's one of the simplest forms of encryption, used historically for encoding messages.</p>
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
