<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio</title>

    <link rel="stylesheet" href="css/estiloRelatorio.css">
</head>

<body>

<h1>Relatorio de Reservas</h1>
    <form id="formRelatorioReservas">
        <label>Data Inicial:</label>
        <input type="date" name="dataInicial" required>

        <label>Data Final:</label>
        <input type="date" name="dataFinal" required>

        <input type="hidden" name="mtReserva" id="mtReserva" value="relatorio">

        <button type="submit" class="gerar-relatorio">Gerar Relatório</button>
    </form>

    <table class="relatorio">
        <thead>
            <tr>
                <th>Nome</th>
                <th>WhatsApp</th>
                <th>Data da Reserva</th>
                <th>Quantidade de Pessoas</th>
                <th>Hora</th>
                <th>Tipo de Reserva</th>
            </tr>
        </thead>
        <tbody id="tabelaReservas">
            <!-- Dados do relatório serão inseridos aqui via AJAX -->
        </tbody>
    </table>

    <hr>

<h1>Relatorio de Contatos</h1>

   <form id="formRelatorioContatos">
    <label for="assunto">Selecione o Assunto:</label>
    <select name="assunto" id="assunto" required>
        <option value="">Selecione o Assunto</option>
        <?php
        // Conectar ao banco de dados e buscar assuntos
        try {
            require "private/config/db/conn.php";
            $query = "SELECT idAssunto, descricao FROM tbl_assunto";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['idAssunto'] . '">' . htmlspecialchars($row['descricao']) . '</option>';
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        ?>
    </select>

    <input type="hidden" name="mtContato" id="mtContato" value="relatorio">
    
    <button type="submit" class="gerar-relatorio">Gerar Relatório</button>
</form>

<table class="relatorio">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Celular</th>
            <!-- <th>Assunto</th> -->
            <th>Mensagem</th>
        </tr>
    </thead>
    <tbody id="tabelaContato">
        <!-- Dados do relatório serão inseridos aqui via AJAX -->
    </tbody>
</table>


    <script src="js/relatorio.js"></script>
</body>

</html>