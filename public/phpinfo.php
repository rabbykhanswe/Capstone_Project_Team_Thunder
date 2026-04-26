<?php
// Show PHP configuration for upload debugging
echo "<h2>PHP Configuration for Uploads</h2>";

echo "<h3>File Upload Settings:</h3>";
echo "file_uploads: " . ini_get('file_uploads') . "<br>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";

echo "<h3>Upload Temp Directory:</h3>";
echo "upload_tmp_dir: " . ini_get('upload_tmp_dir') . "<br>";

echo "<h3>Current Working Directory:</h3>";
echo getcwd() . "<br>";

echo "<h3>Public Directory:</h3>";
echo public_path() . "<br>";

echo "<h3>Public Images Directory:</h3>";
$imagesDir = public_path('images/profile_pictures');
echo $imagesDir . "<br>";
echo "Exists: " . (file_exists($imagesDir) ? "Yes" : "No") . "<br>";
echo "Writable: " . (is_writable($imagesDir) ? "Yes" : "No") . "<br>";
?>
