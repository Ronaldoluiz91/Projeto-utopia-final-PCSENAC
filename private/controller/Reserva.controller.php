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
    $hora = $_POST['hora'];

    // Verifica se todos os campos estão preenchidos
    if (empty($nome) || empty($whatsapp) || empty($tipoReserva) || empty($quantidade) || empty($dataReserva) || empty($hora)) {
        // Retorna uma resposta de erro
        $result = [
            'status' => false,
            'msg' => "Por favor, preencha todos os campos."
        ];
    } else {
        // Verifica se a data já atingiu o limite de 3 reservas
        $reservasExistentes = $RESERVA->contarReservasPorData($dataReserva);

        if ($reservasExistentes >= 3) { 
            $result = [
                'status' => false,
                'msg' => "Data indisponível."
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
    break;


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
