<?php
class CONTATO
{
    private $conn;
    private $nome;
    private $celular;
    private $assunto;
    private $mensagem;

    public function __construct()
    {
        require(__DIR__ . '/../config/db/conn.php'); // Conexão ao banco de dados
        $this->conn = $conn;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }


    public function GravarContato()
    {
        // Insere os dados do contato no banco de dados



        $query = "INSERT INTO tbl_contato (idContato, nome, celular, mensagem, Fk_Assunto) 
                  VALUES (null, :nome, :celular, :mensagem, :assunto  )";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':celular', $this->celular);
        $stmt->bindParam(':assunto', $this->assunto);
        $stmt->bindParam(':mensagem', $this->mensagem);


        if ($stmt->execute()) {
            return ['status' => true, 'msg' => "Contato enviado com sucesso"];
        } else {
            return ['status' => false, 'msg' => "Erro ao enviar o contato"];
        }
    }


    public function getDescricaoAssunto($idAssunto)
    {
        try {
            $query = "SELECT descricao FROM tbl_assunto WHERE idAssunto = :assunto";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idAssunto', $idAssunto);
            $stmt->execute();

            // Retorna a descrição do assunto
            return $stmt->fetchColumn(); // fetchColumn() é usado porque estamos esperando um único valor
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null; // Retorna null em caso de erro
        }
    }




    public function getContato($assunto)
    {
        try {
            $query = "SELECT 
                c.nome, 
                c.celular, 
                c.mensagem, 
                a.descricao AS descricaoAssunto
              FROM tbl_contato c
              JOIN tbl_assunto a ON c.Fk_Assunto = a.idAssunto
              WHERE c.Fk_Assunto = :assunto
               ORDER BY a.descricao ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':assunto', $assunto); // Bind para o assunto
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log o erro ou lance uma exceção
            error_log($e->getMessage());
            return [];
        }
    }
}
