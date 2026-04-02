<?php 
include "../../base/check.php";  
include "../../base/main.php"; 
session_start(); 

function pigpenCipher($input, $decrypt = false) {
    $pigpen = [
        'A' => '⍟', 'B' => '☩', 'C' => '✤', 'D' => '✦', 'E' => '☸', 
        'F' => '✈', 'G' => '✙', 'H' => '>', 'I' => '✈', 'J' => '✾', 
        'K' => '✲', 'L' => '✳', 'M' => '✦', 'N' => '✰', 'O' => '✺', 
        'P' => '✼', 'Q' => '✽', 'R' => '✿', 'S' => '✾', 'T' => '✵', 
        'U' => '✶', 'V' => '✷', 'W' => '✸', 'X' => '✹', 'Y' => '✺', 
        'Z' => '✻', ' ' => '*', 'a' => '!', 'b' => '@', 'c' => ')', 
        'd' => '%', 'e' => '<', 'f' => '"', 'g' => '(', 'h' => '^', 
        'i' => '.', 'j' => ',', 'k' => '$', 'l' => '~', 'm' => ']', 
        'n' => '+', 'o' => ':', 'p' => '`', 'q' => '#', 'r' => '}', 
        's' => '=', 't' => ';', 'u' => '¬', 'v' => '{', 'w' => '?', 
        'x' => '-', 'y' => '|', 'z' => '¦'
    ];
    $reversePigpen = array_flip($pigpen);
    
    $output = '';
    for ($i = 0; $i < strlen($input); $i++) {
        $char = $input[$i];
        if ($decrypt) {
            $output .= isset($reversePigpen[$char]) ? $reversePigpen[$char] : $char;
        } else {
            $output .= isset($pigpen[$char]) ? $pigpen[$char] : $char;
        }
    }

    return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $textToEncode = $_POST['text'] ?? '';
    $action = $_POST['action'] ?? 'encode';
    
    if ($action === 'encode') {
        $resultText = pigpenCipher($textToEncode);
    } else {
        $resultText = pigpenCipher($textToEncode, true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pigpen Cipher</title>
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
        <h1>Pigpen Cipher</h1>
        
        <form method="POST">
            <label for="text">Enter text: (A-Z and a-z and SPACE)</label><br>
            <input type="text" name="text" placeholder="Enter text" required>
            <br>
            <select name="action">
                <option value="encode">Encode</option>
                <option value="decode">Decode</option>
            </select>
            <br>
            <button type="submit">Submit</button>
        </form>

        <?php if (isset($resultText)): ?>
            <h2>Result:</h2>
            <p><?php echo htmlspecialchars($resultText); ?></p>
        <?php endif; ?>
        <br> 
        <button onclick="toggleDescription()">Show/Hide Description</button>
        
        <div id="description">
            <p>The Pigpen cipher, also known as the Freemason's cipher, is a simple substitution cipher that uses geometric symbols to represent letters of the alphabet. In this cipher, each letter is replaced by a unique symbol that resembles a part of a grid or a series of interconnected shapes, often resembling a grid of dots and lines.</p>
            <p>For example, the letter 'A' might be represented by a specific symbol such as ⍟, while 'B' is denoted by ☩. The cipher accommodates both uppercase and lowercase letters, often treating them as equivalent; however, it can also use distinct symbols for lowercase letters, as shown in the implementation where both 'A' and 'a' are represented by different symbols.</p>
            <p>Spaces are usually denoted by a specific character, such as '*', allowing for separation between words. The Pigpen cipher is not case-sensitive in its basic form, making it easy to encode and decode messages.</p>
            <p>Decoding involves reversing the process, translating the symbols back into their corresponding letters. The Pigpen cipher is one of the simpler forms of encryption and is often used in puzzles, games, and educational contexts to introduce basic cryptography concepts. Its visually distinctive symbols make it appealing and fun for users to engage with, while still being a basic introduction to the principles of encryption.</p>
        </div>
        <br>
        
        <a href="../index.php">Home</a>
    </div>
    <script>
        function toggleDescription() {
            var description = document.getElementById("description");
            description.style.display = (description.style.display === "none") ? "block" : "none";
        }
    </script>

    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
</body>
</html>
