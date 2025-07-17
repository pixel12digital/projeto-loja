<?php
// Teste simples do admin
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Teste Admin</title>";
echo "</head>";
echo "<body>";
echo "<h1>Teste Admin Funcionando!</h1>";
echo "<p>Se você está vendo esta página, o admin está funcionando.</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Timestamp: " . date('Y-m-d H:i:s') . "</p>";
echo "</body>";
echo "</html>";
?> 