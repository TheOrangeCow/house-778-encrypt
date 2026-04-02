<?php 
include "../../base/chech.php";  
include "../../base/main.php"; 
session_start(); 

function createVigenereTable() {
    $chars = array_merge(range('A', 'Z'), range('a', 'z'), [' ']);
    $table = [];

    for ($i = 0; $i < 53; $i++) {
        $table[$i] = [];
        for ($j = 0; $j < 53; $j++) {
            $table[$i][$j] = $chars[($i + $j) % 53];
        }
    }
    return $table;
}

function vigenereEncrypt($plaintext, $key) {
    $table = createVigenereTable();
    $ciphertext = '';
    $keyLen = strlen($key);
    
    for ($i = 0, $j = 0; $i < strlen($plaintext); $i++) {
        $p = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $plaintext[$i]);
        if ($p !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$j % $keyLen]);
            $ciphertext .= $table[$k][$p];
            $j++;
        } else {
            $ciphertext .= $plaintext[$i];
        }
    }
    return $ciphertext;
}

function vigenereDecrypt($ciphertext, $key) {
    $table = createVigenereTable();
    $plaintext = '';
    $keyLen = strlen($key);
    
    for ($i = 0, $j = 0; $i < strlen($ciphertext); $i++) {
        $c = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $ciphertext[$i]);
        if ($c !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$j % $keyLen]);
            $p = (53 + $c - $k) % 53;
            $plaintext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$p];
            $j++;
        } else {
            $plaintext .= $ciphertext[$i];
        }
    }
    return $plaintext;
}

function autokeyEncrypt($plaintext, $key) {
    $table = createVigenereTable();
    $ciphertext = '';
    $keyExtended = $key; 
    $keyLen = strlen($key);
    $plaintextLen = strlen($plaintext);
    
    for ($i = 0; $i < $plaintextLen; $i++) {
        $p = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $plaintext[$i]);
        if ($p !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $keyExtended[$i]);
            $ciphertext .= $table[$k][$p];
            if ($i >= $keyLen) {
                $keyExtended .= $ciphertext[$i]; 
            }
        } else {
            $ciphertext .= $plaintext[$i]; 
        }
    }
    return $ciphertext;
}

function autokeyDecrypt($ciphertext, $key) {
    $table = createVigenereTable();
    $plaintext = '';
    $keyExtended = $key; 
    $keyLen = strlen($key);
    $ciphertextLen = strlen($ciphertext);
    
    for ($i = 0; $i < $ciphertextLen; $i++) {
        $c = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $ciphertext[$i]);
        if ($c !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $keyExtended[$i]);
            $p = (53 + $c - $k) % 53;
            $plaintext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$p];
            if ($i >= $keyLen) {
                $keyExtended .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$p]; 
            }
        } else {
            $plaintext .= $ciphertext[$i]; 
        }
    }
    return $plaintext;
}


function beaufortEncrypt($plaintext, $key) {
    $table = createVigenereTable();
    $ciphertext = '';
    $keyLen = strlen($key);
    
    for ($i = 0, $j = 0; $i < strlen($plaintext); $i++) {
        $p = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $plaintext[$i]);
        if ($p !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$j % $keyLen]);
            $c = (53 + $k - $p) % 53;
            $ciphertext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$c];
            $j++;
        } else {
            $ciphertext .= $plaintext[$i];
        }
    }
    return $ciphertext;
}

function beaufortDecrypt($ciphertext, $key) {
    $table = createVigenereTable();
    $plaintext = '';
    $keyLen = strlen($key);
    
    for ($i = 0, $j = 0; $i < strlen($ciphertext); $i++) {
        $c = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $ciphertext[$i]);
        if ($c !== false) {
            $k = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ', $key[$j % $keyLen]);
            $p = (53 + $k - $c) % 53;
            $plaintext .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz '[$p];
            $j++;
        } else {
            $plaintext .= $ciphertext[$i];
        }
    }
    return $plaintext;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigenère Cipher</title>
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
            <h1>Vigenère Cipher</h1>
            
            <form method="POST">
                <label for="cipherType">Cipher Type:</label>
                <select name="cipherType" required>
                    <option value="standard">Standard Vigenère</option>
                    <option value="autokey">Autokey Vigenère</option>
                    <option value="beaufort">Beaufort Cipher</option>
                </select>
                
                <br>
                
                <label for="plaintext">Plaintext: (A-Z and a-z and SPACE)</label>
                <input type="text" name="plaintext" required>
                <br>
                <label for="key">Key: (A-Z and a-z and SPACE)</label>
                <input type="text" name="key" required>
                <br>
                <button type="submit" name="encrypt">Encrypt</button><br>
                <button type="submit" name="decrypt">Decrypt</button>
            </form>
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $plaintext = $_POST['plaintext'];
                $key = $_POST['key'];
                $cipherType = $_POST['cipherType'];
    
                if (isset($_POST['encrypt'])) {
                    if ($cipherType === 'standard') {
                        $ciphertext = vigenereEncrypt($plaintext, $key);
                    } elseif ($cipherType === 'autokey') {
                        $ciphertext = autokeyEncrypt($plaintext, $key);
                    } elseif ($cipherType === 'beaufort') {
                        $ciphertext = beaufortEncrypt($plaintext, $key);
                    }
                    echo "<h2>Encrypted Text: $ciphertext</h2>";
                } elseif (isset($_POST['decrypt'])) {
                    if ($cipherType === 'standard') {
                        $decryptedText = vigenereDecrypt($plaintext, $key);
                    } elseif ($cipherType === 'autokey') {
                        $decryptedText = autokeyDecrypt($plaintext, $key);
                    } elseif ($cipherType === 'beaufort') {
                        $decryptedText = beaufortDecrypt($plaintext, $key);
                    }
                    echo "<h2>Decrypted Text: $decryptedText</h2>";
                }
            }
            ?>
            
            <br> 
            <button onclick="toggleDescription()">Show/Hide Description</button>
            
            <div id="description">
                <h2>Vigenère Cipher</h2>
                <p>
                    The Vigenère cipher is a method of encrypting alphabetic text by using a simple form of polyalphabetic substitution. A keyword is used to determine the shift for each letter of the plaintext. Each letter in the keyword corresponds to a different shift in the alphabet. For example, with the keyword "KEY," the letter 'K' (which is the 10th letter of the alphabet) shifts the plaintext letter by 10 positions. This results in more complex encryption compared to the Caesar cipher, as the same letter in the plaintext can be encrypted differently depending on the corresponding letter in the keyword. Decryption involves reversing the process by shifting in the opposite direction based on the keyword. The Vigenère cipher is more secure than the Caesar cipher due to its use of multiple shifting patterns.
                </p>

                <h2>Autokey Cipher</h2>
                <p>
                    The Autokey cipher enhances the Vigenère cipher by using the plaintext itself to extend the key. In this cipher, the key starts with a predetermined keyword, but after the initial letters, it continues with the plaintext that has already been encrypted. For example, if the plaintext is "HELLO" and the key is "KEY," after encoding the first few letters, the key would begin to incorporate the ciphertext itself, making it more challenging for attackers to determine the key. This method increases the cipher's strength against frequency analysis since the key is not fixed. The Autokey cipher provides even more complexity than the Vigenère cipher due to its dynamic nature.
                </p>

                <h2>Beaufort Cipher</h2><p>
                    The Beaufort cipher is similar to the Vigenère cipher but utilizes a different approach for encryption and decryption. It also employs a keyword for shifting letters, but the process is inverted compared to the Vigenère cipher. The Beaufort cipher effectively encrypts a letter by determining its position and then subtracting the key letter’s position from it (instead of adding, as in Vigenère). For instance, if the plaintext letter is 'A' and the key letter is 'K', the resulting ciphertext letter is derived from the difference. This method means that the encryption and decryption processes are identical, simplifying the implementation. The Beaufort cipher offers a unique take on polyalphabetic substitution but does not provide the same level of security as the Autokey cipher.
                </p>

                <h2>Key Differences</h2>
                <p>
                    <ul>
                        <li>Encryption Method: The Vigenère and Beaufort ciphers use a keyword to determine shifts, but Vigenère adds the key's position to the plaintext, while Beaufort subtracts it. The Autokey cipher extends the key dynamically using the plaintext.</li>
                        <li>Key Complexity: The Vigenère cipher employs a static keyword, whereas the Autokey cipher uses a variable key that changes during encryption. The Beaufort cipher retains the same keyword structure as Vigenère but alters the encryption mechanics.</li>
                        <li>Decryption Process: In the Vigenère and Autokey ciphers, the decryption process is different from encryption, while in the Beaufort cipher, the processes are identical, making it easier to implement.</li>
                        <li>Security: The Autokey cipher generally offers greater security against frequency analysis due to its evolving key, followed by the Vigenère cipher. The Beaufort cipher is more straightforward but does not offer as much protection.</li>
                    </ul>
                </p>
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
