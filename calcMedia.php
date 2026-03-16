<?php
    
class CalculadoraMedia
{
    private array $notas;
    private float $notaCorte;

    public function __construct(array $notas, float $nota_corte = 7)
    {
        $this->notas = $notas;
        $this->notaCorte = $nota_corte;
    }

    public function calcular(): array
    {
        if ($this->notaCorte < 0 || $this->notaCorte > 10) {
            return [0, "Nota de corte deve ser entre 0 e 10"];
        }

        if (count($this->notas) === 0) {
            return [0, "Lista de notas vazia"];
        }

        foreach ($this->notas as $nota) {
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

        $media = array_sum($this->notas) / count($this->notas);
        $status = $media >= $this->notaCorte ? "Aprovado" : "Reprovado";

        return [$media, $status];
    }
}