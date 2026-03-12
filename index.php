<?php


function show() {
    $html = file_get_contents('index.html');
    $nome = '';
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
    }
    $html = str_replace("{nome}", htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'), $html);
    echo $html;
}
// Redireciona apenas quando o formulário for submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    header("Location: notas.php?nome=" . urlencode($_POST['nome']));
    exit;
}

show();