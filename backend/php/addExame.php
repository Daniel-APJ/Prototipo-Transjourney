<?php
require "auth.php"; // segurança

// Apenas estrutura, sem salvar ainda
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

echo "<p>Backend pronto para integração futura.</p>";

echo '<a href="../../frontend/pages/historico.php">Voltar</a>';
?>
