<?php

include 'calcMedia.php';

$nomeForForm = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'])) {
        $nomeForForm = $_POST['nome'];
    }
} else {
    if (isset($_GET['nome'])) {
        $nomeForForm = $_GET['nome'];
    }
}

function show($nome) {
    $html = file_get_contents('calcular_media.html');
    $html = str_replace("{nome}", htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'), $html);
    echo $html;
}


show($nomeForForm);

// Só calcula quando o formulário for submetido via POST e existir as notas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num'])) {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : $nomeForForm;

    $notas = array_map('floatval', $_POST['num']);

    list($media, $status) = calcularMedia($nome, $notas);

    // Saída segura
    echo "<h2>Resultado:</h2>";
    echo "<p>Nome: " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p>Média: " . number_format($media, 2) . "</p>";
    echo "<p>Status: " . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</p>";
}