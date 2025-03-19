<?php
// build-own-framework-symphony

$name = $_GET['name'] ?? 'World!';

// add the header

header('Content-Type: text/html; charset=utf-8');
printf('Hello %s', htmlentities($name, ENT_QUOTES, 'utf-8'));

?>