<?php
header('Content-Type: application/json');
include("../model/Reserva.model.php");


$RESERVA = new RESERVA();


$mtReserva = $_POST['mtReserva'];

switch ($mtReserva) {
    case 'Reservar':
        // Obtém os dados enviados via POST
        $nome = $_POST['nome'];
        $whatsapp = $_POST['whatsapp'];
        $tipoReserva = $_POST['tipoReserva'];
        $quantidade = $_POST['quantidade'];
        $dataReserva = $_POST['dataReserva'];
        $hora = $_POST['hora']; // Aqui, assumimos que "hora" é a descrição

        // Verifica se todos os campos estão preenchidos
        if (empty($nome) || empty($whatsapp) || empty($tipoReserva) || empty($quantidade) || empty($dataReserva) || empty($hora)) {
            // Retorna uma resposta de erro
            $result = [
                'status' => false,
                'msg' => "Por favor, preencha todos os campos."
            ];
        } else {



            // Conta o número total de pessoas já existentes na data de reserva
            $pessoasExistentes = $RESERVA->contarPessoasPorData($dataReserva);

            //$pessoasExistentes['totalCapacidade'] >= 100 ||

            if ($pessoasExistentes['tipoReservaDescricao'] == 'Evento (mais de 30 pessoas)') {
                $result = [
                    'status' => false,
                    'msg' => "Data indisponível.",
                ];
            } else {
                // Verifica a capacidade para a hora específica
                $capacidadePorHora = $RESERVA->contarPessoasPorHora($dataReserva, $hora);

                // Verifica se a soma da capacidade atual e a quantidade de novas reservas excedem 20
                if ($capacidadePorHora + $quantidade > 20) {
                    $result = [
                        'status' => false,
                        'msg' => "Limite de reservas para o horário excedido.",
                        'capacidade' => $capacidadePorHora + $quantidade
                    ];
                } else {
                    // Define os valores no objeto RESERVA
                    $RESERVA->setNome($nome);
                    $RESERVA->setWhatsapp($whatsapp);
                    $RESERVA->setTipoReserva($tipoReserva);
                    $RESERVA->setQuantidade($quantidade);
                    $RESERVA->setDataReserva($dataReserva);
                    $RESERVA->setHora($hora);

                    // Tenta cadastrar a reserva e captura o retorno
                    $result = $RESERVA->criarReserva();
                }
            }
        }
        break;



        //     $reservasExistentes = $RESERVA->contarReservasPorQuantidade($quantidade, $dataReserva);

        //     if ($reservasExistentes = ($quantidade >= 20)) { 
        //         $result = [
        //             'status' => false,
        //             'msg' => "Data indisponível."
        //         ];
        //     } else {
        //         // Define os valores no objeto RESERVA
        //         $RESERVA->setNome($nome);
        //         $RESERVA->setWhatsapp($whatsapp);
        //         $RESERVA->setTipoReserva($tipoReserva);
        //         $RESERVA->setQuantidade($quantidade);
        //         $RESERVA->setDataReserva($dataReserva);
        //         $RESERVA->setHora($hora);

        //         // Tenta cadastrar a reserva e captura o retorno
        //         $result = $RESERVA->criarReserva();
        //     }
        // }

    case 'relatorio':
        $dataInicial = $_POST['dataInicial'];
        $dataFinal = $_POST['dataFinal'];

        if (empty($dataInicial) || empty($dataFinal)) {
            $result = [
                'status' => false,
                'msg' => "As datas inicial e final devem ser preenchidas."
            ];
        } else {
            try {
                $reservas = $RESERVA->getReservas($dataInicial, $dataFinal); // Obtenha as reservas

                if (!empty($reservas)) {
                    $result = [
                        'status' => true,
                        'reservas' => $reservas // Certifique-se de que reservas contém um array de dados
                    ];
                } else {
                    $result = [
                        'status' => false,
                        'msg' => "Nenhuma reserva encontrada para o período selecionado."
                    ];
                }
            } catch (Exception $e) {
                $result = [
                    'status' => false,
                    'msg' => "Erro ao buscar reservas: " . $e->getMessage()
                ];
            }
        }

        break;
    default:
        // Se mtAdmin não corresponder a nenhum caso, retorna um erro
        $result = [
            'status' => false,
            'msg' => "Ação inválida."
        ];
        break;
}

// Retorna a resposta em formato JSON
echo json_encode($result);
