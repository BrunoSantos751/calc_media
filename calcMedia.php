<?php

function calcularMedia($notas, $nota_corte = 7) {
    if ($nota_corte < 0 || $nota_corte > 10) {
        return array(0, "Nota de corte deve ser entre 0 e 10");
    }
    foreach ($notas as $nota) {
        if ($nota < 0 || $nota > 10) {
            return array(0, "Notas devem ser entre 0 e 10");
        }
        if (!is_numeric($nota)) {
            return array(0, "Notas devem ser numéricas");
        }
        if (!isset($nota)) {
            return array(0, "Notas não podem ser vazias");
        }
    }

    $media = array_sum($notas) / count($notas);
    if ($media >= $nota_corte) {
        $status = "Aprovado";
    } else {
        $status = "Reprovado";
    }
    return array($media, $status);
}