<?php

include 'calcMedia.php';

$nomeForForm = $_POST['nome'] ?? $_GET['nome'] ?? '';
if (empty($nomeForForm)) {
    header('Location: index.php');
    exit;
}
$resultadoHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num'])) {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : $nomeForForm;

    $notas = array_map('floatval', $_POST['num']);
    $nota_corte = isset($_POST['media']) ? floatval($_POST['media']) : 7;

    $calculadora = new CalculadoraMedia($notas, $nota_corte);
    list($media, $status) = $calculadora->calcular();

    $statusColor = (stripos($status, 'reprovado') !== false || stripos($status, 'recupera') !== false || stripos($status, 'vermelha') !== false || stripos($status, 'dp') !== false) ? '#ef4444' : '#10b981';
    $statusBg = (stripos($status, 'reprovado') !== false || stripos($status, 'recupera') !== false || stripos($status, 'vermelha') !== false || stripos($status, 'dp') !== false) ? '#fef2f2' : '#ecfdf5';

    $resultadoHtml = "
    <div class='result' style='margin-top: 1.5rem; padding: 1.25rem; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; font-family: Inter, Roboto, sans-serif;'>
        <h2 style='margin-top: 0; margin-bottom: 1rem; color: var(--text); border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; font-size: 1.15rem;'>Resultado</h2>
        <div style='display: flex; flex-direction: column; gap: 0.75rem;'>
            <div style='display: flex; justify-content: space-between; align-items: center;'><strong style='color: var(--muted); font-size: 0.95rem;'>Nome:</strong> <span style='font-weight: 500; color: var(--text);'>" . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "</span></div>
            <div style='display: flex; justify-content: space-between; align-items: center;'><strong style='color: var(--muted); font-size: 0.95rem;'>Média Final:</strong> <span style='font-weight: 600; color: var(--text);'>" . number_format($media, 2) . "</span></div>
            <div style='display: flex; justify-content: space-between; align-items: center;'><strong style='color: var(--muted); font-size: 0.95rem;'>Situação:</strong> <span style='color: {$statusColor}; background: {$statusBg}; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.85rem;'>" . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</span></div>
        </div>
    </div>";
}

function show($nome, $resultadoHtml) {

    $html = file_get_contents('calcular_media.html');

    $nums = $_POST['num'] ?? ['', '', '', ''];

    $notasHtml = '';

    foreach ($nums as $i => $nota) {
        $n = $i + 1;

        $notasHtml .= "
        <div style='display: flex; align-items: center; gap: 1rem;'>
            <label for='num$n' style='margin-bottom: 0; min-width: 60px;'>Nota $n:</label>
            <input type='number'
                   id='num$n'
                   name='num[]'
                   value='".htmlspecialchars($nota, ENT_QUOTES, 'UTF-8')."'
                   step='0.01'
                   min='0'
                   max='10'
                   style='margin-bottom: 0; flex: 1;'
                   required>
        </div>";
    }

    $media = $_POST['media'] ?? '';

    $html = str_replace("{nome}", htmlspecialchars($nome), $html);
    $html = str_replace("{notas}", $notasHtml, $html);
    $html = str_replace("{media}", $media, $html);
    $html = str_replace("{resultado}", $resultadoHtml, $html);

    echo $html;
}

show($nomeForForm, $resultadoHtml);