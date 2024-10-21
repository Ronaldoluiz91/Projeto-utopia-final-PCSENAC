<?php
class RESERVA
{
    private $conn;
    private $nome;
    private $whatsapp;
    private $tipoReserva;
    private $quantidade;
    private $dataReserva;
    private $hora;

    public function __construct()
    {
        require(__DIR__ . '/../config/db/conn.php'); // Conexão ao banco de dados
        $this->conn = $conn;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function setTipoReserva($tipoReserva)
    {
        $this->tipoReserva = $tipoReserva;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function setDataReserva($dataReserva)
    {
        $this->dataReserva = $dataReserva;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function contarPessoasPorHora($dataReserva, $idHoraReserva)
    {

        $queryDescricao = "SELECT descricao FROM tbl_hora WHERE idHora = :idHoraReserva";
        $stmtDescricao = $this->conn->prepare($queryDescricao);
        $stmtDescricao->bindParam(':idHoraReserva', $idHoraReserva, PDO::PARAM_INT);
        $stmtDescricao->execute();

        // descricao da hora
        $descricaoHora = $stmtDescricao->fetchColumn();

        // Verificar se a descricao foi encontrada
        if ($descricaoHora === false) {
            return 0;
        }

        $query = "
            SELECT SUM(c.capacidade) AS totalCapacidade
            FROM tbl_reserva r
            JOIN tbl_capacidade c ON r.FK_idCapacidade = c.idCapacidade
            JOIN tbl_hora h ON r.FK_idHoraReserva = h.idHora
            WHERE r.dataReserva = :dataReserva AND h.descricao = :descricaoHora
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dataReserva', $dataReserva, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoHora', $descricaoHora, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchColumn() ?: 0;
    }

    public function contarPessoasPorData($dataReserva)
    {
        $query = "
            SELECT 
                SUM(c.capacidade) AS totalCapacidade,
                tr.descricao AS tipoReservaDescricao
            FROM tbl_reserva r
            JOIN tbl_capacidade c ON r.FK_idCapacidade = c.idCapacidade
            JOIN tbl_tiporeserva tr ON r.FK_idTipoReserva = tr.idTipoReserva
            WHERE r.dataReserva = :dataReserva
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dataReserva', $dataReserva, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: ['totalCapacidade' => 0, 'tipoReservaDescricao' => null];
    }




    public function criarReserva()
    {
        // Insere os dados da reserva no banco de dados
        $statusReserva = 1;

        $query = "INSERT INTO tbl_reserva (nome, whatsapp, dataReserva, FK_idCapacidade, FK_idStatusReserva, FK_idHoraReserva, FK_idTipoReserva) 
              VALUES (:nome, :whatsapp, :dataReserva, :capacidadeId, :statusReservaId, :horaId, :tipoReservaId)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':whatsapp', $this->whatsapp);
        $stmt->bindParam(':tipoReservaId', $this->tipoReserva);
        $stmt->bindParam(':capacidadeId', $this->quantidade);
        $stmt->bindParam(':dataReserva', $this->dataReserva);
        $stmt->bindParam(':horaId', $this->hora);
        $stmt->bindParam(':statusReservaId', $statusReserva);

        if ($stmt->execute()) {
            $tipoReservaDescricao = $this->getTipoReservaDescricao($this->tipoReserva);
            $capacidadeDescricao = $this->getCapacidadeDescricao($this->quantidade);
            $horaDescricao = $this->getHoraDescricao($this->hora);
            // $statusDescricao = $this->getStatusDescricao($this->$statusReserva);


            return [
                'status' => true,
                'msg' => "Reserva criada com sucesso",
                'tipoReserva' => $tipoReservaDescricao,
                'capacidade' => $capacidadeDescricao,
                'hora' => $horaDescricao,
                'dataReserva' => $this->dataReserva,
                // 'status' => $statusDescricao
            ];
        } else {
            return ['status' => false, 'msg' => "Erro ao criar a reserva"];
        }
    }


    private function getStatusDescricao($statusReservaId)
    {
        $query = "SELECT descricao FROM tbl_statusreserva WHERE idstatusreserva = :";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statusReservaId', $statusReservaId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    private function getTipoReservaDescricao($tipoReservaId)
    {
        $query = "SELECT descricao FROM tbl_tiporeserva WHERE idTipoReserva = :tipoReservaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipoReservaId', $tipoReservaId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    private function getCapacidadeDescricao($capacidadeId)
    {
        $query = "SELECT capacidade FROM tbl_capacidade WHERE idCapacidade = :capacidadeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':capacidadeId', $capacidadeId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    private function getHoraDescricao($horaId)
    {
        $query = "SELECT descricao FROM tbl_hora WHERE idHora = :horaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':horaId', $horaId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }





    public function getReservas($dataInicial, $dataFinal)
    {
        try {
            $query = "SELECT 
                        r.nome, 
                        r.whatsapp, 
                        r.dataReserva, 
                        m.capacidade AS descricaoMesa, 
                        h.descricao AS descricaoHora, 
                        t.descricao AS descricaoTipoReserva 
                      FROM tbl_reserva r
                      JOIN tbl_capacidade m ON r.FK_idCapacidade = m.idCapacidade
                      JOIN tbl_hora h ON r.FK_idHoraReserva = h.idHora
                      JOIN tbl_tiporeserva t ON r.FK_idTipoReserva = t.idTipoReserva
                      WHERE r.dataReserva BETWEEN :dataInicial AND :dataFinal  ORDER BY r.dataReserva ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':dataInicial', $dataInicial);
            $stmt->bindParam(':dataFinal', $dataFinal);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log o erro ou lance uma exceção
            error_log($e->getMessage());
            return [];
        }
    }
}