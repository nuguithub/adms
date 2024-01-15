<?php
$hash = "";

$hashed =  password_hash($hash, PASSWORD_DEFAULT);

echo "Hashed Password of ".$hash. ": " . $hashed;
?>