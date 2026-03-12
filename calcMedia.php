<?php
function calcularMedia(array $notas, float $nota_corte = 7): array
{
    if ($nota_corte < 0 || $nota_corte > 10) {
        return [0, "Nota de corte deve ser entre 0 e 10"];
    }

    if (count($notas) === 0) {
        return [0, "Lista de notas vazia"];
    }

    foreach ($notas as $nota) {

        if ($nota === '' || $nota === null) {
            return [0, "Notas não podem ser vazias"];
        }

        if (!is_numeric($nota)) {
            return [0, "Notas devem ser numéricas"];
        }

        $nota = (float) $nota;

        if ($nota < 0 || $nota > 10) {
            return [0, "Notas devem ser entre 0 e 10"];
        }
    }

    $media = array_sum($notas) / count($notas);

    $status = $media >= $nota_corte ? "Aprovado" : "Reprovado";

    return [$media, $status];
}