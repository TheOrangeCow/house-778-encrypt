<?php
function clearFolder($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            clearFolder($path);
            rmdir($path);
        } else {
            unlink($path);
        }
    }
    return true;
}


$folderPath = __DIR__ . '/images';
clearFolder($folderPath);
?>
