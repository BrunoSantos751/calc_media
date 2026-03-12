<?php

function calcularMedia($notas, $nota_corte = 7) {
    if (empty($notas)) {
        return array(0, "Nenhuma nota fornecida");
    }
    if (nota < 0 || nota > 10) {
        return array(0, "Notas devem ser entre 0 e 10");
    }

    $media = array_sum($notas) / count($notas);
    if ($media >= $nota_corte) {
        $status = "Aprovado";
    } else {
        $status = "Reprovado";
    }
    return array($media, $status);
}