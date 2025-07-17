<?php
// Teste de carregamento do admin
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>Teste de Carregamento do Admin</h1>";

// Capturar output do admin
ob_start();

try {
    // Simular carregamento do admin
    include 'admin/index.php';
    $admin_output = ob_get_contents();
    ob_end_clean();
    
    echo "<h2>✅ Admin carregado com sucesso!</h2>";
    echo "<p>Tamanho do output: " . strlen($admin_output) . " bytes</p>";
    
    // Mostrar primeiros 1000 caracteres
    echo "<h3>Primeiros 1000 caracteres:</h3>";
    echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars(substr($admin_output, 0, 1000));
    echo "</div>";
    
} catch (Exception $e) {
    ob_end_clean();
    echo "<h2>❌ Erro ao carregar admin</h2>";
    echo "<p><strong>Erro:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
}

// Verificar se há erros de output
$errors = error_get_last();
if ($errors) {
    echo "<h2>⚠️ Últimos erros detectados:</h2>";
    echo "<p><strong>Tipo:</strong> " . $errors['type'] . "</p>";
    echo "<p><strong>Mensagem:</strong> " . $errors['message'] . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $errors['file'] . "</p>";
    echo "<p><strong>Linha:</strong> " . $errors['line'] . "</p>";
}

echo "<hr>";
echo "<h2>Links de Teste</h2>";
echo "<p><a href='admin/'>Acessar Admin</a></p>";
echo "<p><a href='admin/test_simple.php'>Teste Simples</a></p>";
echo "<p><a href='debug_admin.php'>Debug Completo</a></p>";
?> 