<?php 

// Globais
$clientes = [];
$contas = [];

function menu(&$clientes, &$contas) {
    while (true) {
        print "\n1. Cadastrar Cliente\n";
        print "2. Criar Conta\n";
        print "3. Depositar\n";
        print "4. Sacar\n";
        print "5. Consultar Saldo\n";
        print "6. Sair\n";
        print "Escolha uma opção: ";
        $opcao = trim(fgets(STDIN));

        if ($opcao == 1) {
            print "Nome: ";
            $nome = trim(fgets(STDIN));
            print "CPF (11 dígitos): ";
            $cpf = trim(fgets(STDIN));
            print "Telefone: ";
            $telefone = trim(fgets(STDIN));
            cadastrarCliente($clientes, $nome, $cpf, $telefone);
        } elseif ($opcao == 2) {
            print "CPF do cliente: ";
            $cpfCliente = trim(fgets(STDIN));
            $numeroConta = cadastrarConta($contas, $cpfCliente);
            print "Conta criada! Número: $numeroConta\n";
        } elseif ($opcao == 3) {
            print "Número da conta: ";
            $numeroConta = trim(fgets(STDIN));
            print "Valor do depósito: ";
            $quantia = floatval(trim(fgets(STDIN)));
            depositar($contas, $numeroConta, $quantia);
        } elseif ($opcao == 4) {
            print "Número da conta: ";
            $numeroConta = trim(fgets(STDIN));
            print "Valor do saque: ";
            $quantia = floatval(trim(fgets(STDIN)));
            sacar($contas, $numeroConta, $quantia);
        } elseif ($opcao == 5) {
            print "Número da conta: ";
            $numeroConta = trim(fgets(STDIN));
            consultarSaldo($contas, $numeroConta);
        } elseif ($opcao == 6) {
            print "Saindo...\n";
            break;
        } else {
            print "Opção inválida.\n";
        }
    }
}

function cadastrarCliente(&$clientes, $nome, $cpf, $telefone) {
    if (strlen($cpf) != 11 || !ctype_digit($cpf)) {
        print "CPF inválido! Deve conter 11 dígitos numéricos.\n";
        return;
    }

    $cliente = [
        "nome" => $nome,
        "cpf" => $cpf,
        "telefone" => $telefone
    ];
    
    $clientes[] = $cliente;
    print "Cliente cadastrado com sucesso!\n";
}

function cadastrarConta(&$contas, $cpfCliente) {
    $conta = [
        "numeroConta" => uniqid(),
        "cpfCliente" => $cpfCliente,
        "saldo" => 0
    ];
    
    $contas[] = $conta;
    return $conta['numeroConta'];
}

function depositar(&$contas, $numeroConta, $quantia) {
    if ($quantia <= 0) {
        print "Valor inválido para depósito.\n";
        return;
    }

    foreach ($contas as &$conta) {
        if ($conta['numeroConta'] == $numeroConta) {
            $conta['saldo'] += $quantia;
            print "Depósito de R$ $quantia realizado com sucesso na conta $numeroConta.\n";
            return;
        }
    }
    print "Conta $numeroConta não encontrada.\n";
}

function sacar(&$contas, $numeroConta, $quantia) {
    foreach ($contas as &$conta) {
        if ($conta['numeroConta'] == $numeroConta) {
            if ($quantia > $conta['saldo']) {
                print "Saldo insuficiente.\n";
                return;
            }
            $conta['saldo'] -= $quantia;
            print "Saque de R$ $quantia realizado com sucesso.\n";
            return;
        }
    }
    print "Conta $numeroConta não encontrada.\n";
}

function consultarSaldo(&$contas, $numeroConta) {
    foreach ($contas as $conta) {
        if ($conta['numeroConta'] == $numeroConta) {
            print "Saldo da conta $numeroConta: R$ {$conta['saldo']}\n";
            return;
        }
    }
    print "Conta $numeroConta não encontrada.\n";
}

menu($clientes, $contas);

?>
