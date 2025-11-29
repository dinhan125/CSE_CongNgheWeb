<?php
// functions.php

define('DATA_FILE', __DIR__ . '/data.json');

// SỬA Ở ĐÂY: Thêm '/src' vào đường dẫn để khớp với thư mục thật
define('IMAGES_DIR', __DIR__ . '/../src/images/'); 

/**
 * Load flowers array from JSON file.
 * Returns array of flowers each: ['id'=>int,'name'=>string,'description'=>string,'image'=>string]
 */
function load_flowers() {
    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, json_encode([]));
    }
    $json = file_get_contents(DATA_FILE);
    $arr = json_decode($json, true);
    if (!is_array($arr)) $arr = [];
    return $arr;
}

/**
 * Save flowers array to JSON file.
 */
function save_flowers($flowers) {
    // ensure numeric keys stable
    file_put_contents(DATA_FILE, json_encode(array_values($flowers), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Generate next id
 */
function next_id($flowers) {
    $max = 0;
    foreach ($flowers as $f) {
        if (isset($f['id']) && $f['id'] > $max) $max = $f['id'];
    }
    return $max + 1;
}

/**
 * Handle image upload. Returns saved filename or null on failure.
 * Allowed extensions: jpg,jpeg,png,gif
 */
function handle_image_upload($fileInputName, $existingFilename = null) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
        // no new file: keep existing filename if provided
        return $existingFilename;
    }
    $f = $_FILES[$fileInputName];
    if ($f['error'] !== UPLOAD_ERR_OK) return null;

    // validate
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;

    // sanitize name and create unique filename
    $base = pathinfo($f['name'], PATHINFO_FILENAME);
    $base = preg_replace('/[^a-zA-Z0-9_-]/u','_', $base);
    $filename = $base . '_' . time() . '.' . $ext;

    // Tự động tạo thư mục src/images nếu chưa có
    if (!is_dir(IMAGES_DIR)) mkdir(IMAGES_DIR, 0755, true);

    $dest = IMAGES_DIR . $filename;
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        // optionally remove old file
        if ($existingFilename && file_exists(IMAGES_DIR . $existingFilename) && $existingFilename !== $filename) {
            // unlink(IMAGES_DIR . $existingFilename); // uncomment if you want to delete old images
        }
        return $filename; // Trả về tên file (VD: hoa_123456.jpg)
    }
    return null;
}
?>