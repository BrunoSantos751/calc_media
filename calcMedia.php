<?php

function calcularMedia($nome, $notas) {
    var_dump($notas);
    $media = array_sum($notas) / count($notas);
    if ($media >= 7) {
        $status = "Aprovado";
    } else {
        $status = "Reprovado";
    }
    return array($media, $status);
}