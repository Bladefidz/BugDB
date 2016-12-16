<?php
/**
 * Validate image file and move to upload directory
 * @param  array $file      Array of $_FILE
 * @param  string $upload_dir Directory's name
 * @return bool            success or not
 */
function upload_image($file, $upload_dir) {
    if ($file['type'] == "image/gif"
        || $file['type'] == "image/jpeg"
        || $file['type'] == "image/pjpeg"
        || $file['type'] == "image/png")
    {
        // Check its value less than 4 MB or not
        if ($file['size'] <= 4000000) {
            if (strlen($file['name']) < 255) {
                move_uploaded_file($file['tmp_name'], "$upload_dir/{$file['name']}");
                return TRUE;
            } else {
                echo "Image filename too long";
                return FALSE;
            }
        } else {
            echo "Image file more than 4 MB";
            return FALSE;
        }
    } else {
        echo "Invalid file type";
        return FALSE;
    }
}
?>