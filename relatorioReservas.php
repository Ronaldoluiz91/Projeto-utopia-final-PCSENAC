<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio</title>

    <link rel="stylesheet" href="css/estiloRelatorio.css">
</head>

<body>
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

    <script src="js/relatorio.js"></script>
</body>

</html>