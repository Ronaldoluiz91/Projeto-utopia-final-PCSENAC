<?php
header('Content-Type: application/json');
include("../model/Contato.model.php");


$CONTATO = new CONTATO();


$mtContato = $_POST['mtContato'];

switch ($mtContato) {
    case 'Contato':
        // Obtém os dados enviados via POST
        $nome = $_POST['nome'];
        $celular = $_POST['telefone'];
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['mensagem'];
        

        // Verifica se todos os campos estão preenchidos
        if (empty($nome) || empty($celular) || empty($assunto) || empty($mensagem)) {
            // Retorna uma resposta de erro
            $result = [
                'status' => false,
                'msg' => "Por favor, preencha todos os campos."
            ];
        } else {
            // Define os valores no objeto RESERVA
            $CONTATO->setNome($nome);
            $CONTATO->setCelular($celular);
            $CONTATO->setAssunto($assunto);
            $CONTATO->setMensagem($mensagem);
            

            // Tenta cadastrar a reserva e captura o retorno
            $result = $CONTATO->GravarContato();
        }
        break;

        case 'relatorio':
        
    $assunto = $_POST['assunto']; // Assunto selecionado

    if (empty($assunto)) {
        $result = [
            'status' => false,
            'msg' => "O assunto devem ser preenchido."
        ];
    } else {
        try {
            // Chame o método para obter contatos filtrados por assunto e datas
            $contatos = $CONTATO->getContato($assunto);

            if (!empty($contatos)) {
                $result = [
                    'status' => true,
                    'contatos' => $contatos // Certifique-se de que contatos contém um array de dados
                ];
            } else {
                $result = [
                    'status' => false,
                    'msg' => "Nenhum contato encontrado neste período e assunto selecionados."
                ];
            }
        } catch (Exception $e) {
            $result = [
                'status' => false,
                'msg' => "Erro ao buscar mensagens de contatos: " . $e->getMessage()
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