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

    $nums = $_POST['num'] ?? ['', '', '', ''];

    $notasHtml = '';

    foreach ($nums as $i => $nota) {
        $n = $i + 1;

        $notasHtml .= "
        <label for='num$n'>Nota $n:</label>
        <input type='number'
               id='num$n'
               name='num[]'
               value='".htmlspecialchars($nota, ENT_QUOTES, 'UTF-8')."'
               step='0.01'
               min='0'
               max='10'
               required><br><br>";
    }

    $media = $_POST['media'] ?? '';

    $html = str_replace("{nome}", htmlspecialchars($nome), $html);
    $html = str_replace("{notas}", $notasHtml, $html);
    $html = str_replace("{media}", $media, $html);

    echo $html;
}

show($nomeForForm);

// Só calcula quando o formulário for submetido via POST e existir as notas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num'])) {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : $nomeForForm;

    $notas = array_map('floatval', $_POST['num']);
    $nota_corte = isset($_POST['media']) ? floatval($_POST['media']) : 7;

    list($media, $status) = calcularMedia($notas, $nota_corte);

    // Saída segura
    echo "<h2>Resultado:</h2>";
    echo "<p>Nome: " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p>Média: " . number_format($media, 2) . "</p>";
    echo "<p>Status: " . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</p>";
}