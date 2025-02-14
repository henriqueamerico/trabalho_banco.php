<?php
function gerarAposta($jogo, $numDezenas) {
    $regras = [
        "Mega-Sena" => [6, 20, 60, 5.00],
        "Quina" => [5, 15, 80, 2.00],
        "Lotomania" => [50, 50, 100, 2.50],
        "Lotofácil" => [15, 20, 25, 2.50]
    ];

    list($min, $max, $total, $preco) = $regras[$jogo];
    if ($numDezenas < $min || $numDezenas > $max) {
        echo "Número de dezenas inválido! Escolha entre $min e $max.\n";
        return null;
    }

    $numeros = range(1, $total);
    $aposta = array_rand(array_flip($numeros), $numDezenas);
    sort($aposta);
    $custo = $preco * ($numDezenas / $min);
    
    return [$aposta, $custo];
}
echo "Bem vindo a loteria!! :)\n";
echo "Escolha o jogo que deseja:\n";
echo "1 - Mega-Sena\n2 - Quina\n3 - Lotomania\n4 - Lotofácil\n";

$jogos = ["1" => "Mega-Sena", "2" => "Quina", "3" => "Lotomania", "4" => "Lotofácil"];
$escolha = readline("Escolha o jogo: ");

if (!isset($jogos[$escolha])) {
    echo "Opção inválida!\n";
    exit;
}

$jogo = $jogos[$escolha];
$numApostas = (int)readline("Quantas apostas deseja gerar? ");
$numDezenas = (int)readline("Quantas dezenas deseja para $jogo? ");

$totalGasto = 0;
echo "\nApostas para $jogo:\n";
for ($i = 0; $i < $numApostas; $i++) {
    $resultado = gerarAposta($jogo, $numDezenas);
    if ($resultado) {
        list($aposta, $custo) = $resultado;
        echo "Aposta " . ($i + 1) . ": " . implode(", ", $aposta) . " - R$ " . number_format($custo, 2, ',', '.') . "\n";
        $totalGasto += $custo;
    }
}

echo "\nTotal gasto: R$ " . number_format($totalGasto, 2, ',', '.') . "\n";
