<?php 
include "../../base/chech.php"; 
include "../../base/main.php";
session_start(); 
$resolt ="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    $upload_dir = 'images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $unique_id = uniqid();

    if ($action === 'encrypt' && isset($_FILES['image']) && !empty($_POST['message'])) {
        $uploaded_image = $_FILES['image']['tmp_name'];
        $message = $_POST['message'];
        $output_image = $upload_dir . 'output_' . $unique_id . '.png';

        $input_image_path = $upload_dir . basename($unique_id . '_' . $_FILES['image']['name']);
        move_uploaded_file($uploaded_image, $input_image_path);

        hide_message($input_image_path, $message, $output_image);

        unlink($input_image_path);

        $resolt = "<p>Message hidden in image: <a href='$output_image'>Download Output Image</a></p>";

    } elseif ($action === 'decrypt' && isset($_FILES['image'])) {
        $uploaded_image = $_FILES['image']['tmp_name'];

        $input_image_path = $upload_dir . basename($unique_id . '_' . $_FILES['image']['name']);
        move_uploaded_file($uploaded_image, $input_image_path);

        $revealed_message = reveal_message($input_image_path);

        unlink($input_image_path);

        if ($revealed_message) {
            $resolt = "<p>Revealed Message: '$revealed_message'</p>";
        } else {
            $resolt = "<p>No hidden message found.</p>";
        }
    }
}


function hide_message($image_path, $message, $output_path) {
    $img = imagecreatefromstring(file_get_contents($image_path));
    if (!$img) {
        $resolt =  "Error: Unable to open image.\n";
        return;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $message .= "\0";
    $binary_message = '';
    foreach (str_split($message) as $char) {
        $binary_message .= sprintf("%08b", ord($char));
    }

    $data_index = 0;
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            if ($data_index < strlen($binary_message)) {
                $r = ($r & ~1) | intval($binary_message[$data_index]);
                $data_index++;
            }

            if ($data_index < strlen($binary_message)) {
                $g = ($g & ~1) | intval($binary_message[$data_index]);
                $data_index++;
            }

            if ($data_index < strlen($binary_message)) {
                $b = ($b & ~1) | intval($binary_message[$data_index]);
                $data_index++;
            }

            $new_color = imagecolorallocate($img, $r, $g, $b);
            imagesetpixel($img, $x, $y, $new_color);

            if ($data_index >= strlen($binary_message)) {
                break 2;
            }
        }
    }

    imagepng($img, $output_path);
    imagedestroy($img);
}

function reveal_message($image_path) {
    $img = imagecreatefromstring(file_get_contents($image_path));
    if (!$img) {
        $resolt = "Error: Unable to open image.\n";
        return null;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $binary_message = '';
    
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $binary_message .= ($r & 1);
            $binary_message .= ($g & 1);
            $binary_message .= ($b & 1);
        }
    }

    imagedestroy($img);

    $message = '';
    for ($i = 0; $i < strlen($binary_message); $i += 8) {
        $byte = substr($binary_message, $i, 8);
        if ($byte === '00000000') {
            break;
        }
        $message .= chr(bindec($byte));
    }

    return $message;
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Encrypt - Image</title>
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
            <h2>Encrypt Image</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="action">Choose an action:</label><br>
                <input type="radio" id="encrypt" name="action" value="encrypt" required>
                <label for="encrypt">Encrypt (Hide Message)</label><br>
                <input type="radio" id="decrypt" name="action" value="decrypt" required>
                <label for="decrypt">Decrypt (Reveal Message)</label><br><br>
        
                <label for="image">Upload an image:</label>
                <input type="file" name="image" accept="image/png, image/jpeg" required><br><br>
        
                <div id="message-input">
                    <label for="message">Message to hide:</label>
                    <textarea name="message" id="message"></textarea><br><br>
                </div>
        
                <button type="submit">Submit</button>
            </form>
            <p><?php echo $resolt ?></p>
            <a href = "../index.php">Home</a>
        </div>

        <script>
            const encryptOption = document.getElementById('encrypt');
            const decryptOption = document.getElementById('decrypt');
            const messageInput = document.getElementById('message-input');
    
            decryptOption.addEventListener('change', function() {
                messageInput.style.display = 'none';
            });
    
            encryptOption.addEventListener('change', function() {
                messageInput.style.display = 'block';
            });
        </script>
    </body>
    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
</html>

