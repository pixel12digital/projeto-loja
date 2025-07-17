<?php
// Teste simples para verificar se o PHP está funcionando
echo "PHP está funcionando!";
echo "<br>Versão do PHP: " . phpversion();
echo "<br>Servidor: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido');
echo "<br>Host: " . ($_SERVER['HTTP_HOST'] ?? 'N/A');
?> 