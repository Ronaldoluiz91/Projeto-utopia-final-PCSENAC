<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utopia [Página principal]</title>
    <meta name="description" content="Projeto para o Utopia Bar">


    <!--Buscando o css externo-->
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>


<body class="body-reserva">

    <header id="topo">
        <div>
            <h1>
                <a id="logotipo" href="index.html"><img src="imagens/utopiaLogo-removebg-preview.png"
                        alt="Logotipo"></a>
            </h1>
            <span id="iconMenu" class="material-symbols-outlined" onclick="clickMenu()">
                menu
            </span>

            <nav id="itens">
                <span id="iconClose" class="material-symbols-outlined" onclick="clickMenu()">
                    close
                </span>
                <a href="index.html" tabindex="1">Home</a>
                <!--tabindex é utilizado para a acessibilidade-->
                <a href="cardapio.html" tabindex="2">Cardapio</a>
                <a href="reserva.html" tabindex="3">Reserva</a>
                <a href="contato.html" tabindex="4">Contato</a>
                <a href="trabalheConosco.html" tabindex="5">Trabalhe Conosco</a>
            </nav>
        </div>
    </header>

    <div class="conteudo-reserva-pai">
        <div class="conteudo-reserva">

            <div class="titulo-reserva">
                <h3>Faça sua reserva</h3>
            </div>

            <form id="form-reserva" method="post">
                <p>Nome</p>
                <input tabindex="1" type="text" id="nomeReserva" name="nomeReserva">
                <p>Whatsapp</p>
                <input tabindex="2" type="text" id="telefoneReserva" name="telefoneReserva">
                <p>Tipo de Reserva:</p>
                <select name="reserva" id="reserva">
                    <option value="">Selecione o tipo de reserva:</option>
                    <?php
                    // Conectar ao banco de dados e buscar usuários
                    try {
                        require "private/config/db/conn.php";
                        $query = "SELECT idTipoReserva, descricao FROM tbl_tiporeserva";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['idTipoReserva'] . '">' . htmlspecialchars($row['descricao']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum horario disponivel</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                    ?>
                </select>

                <p>Quantidade de Pessoas:</p>
                <select type="number" name="quantidade" id="quantidade">
                    <option value="">Selecione a quantidade de pessoas:</option>
                    <?php
                    try {
                        $query = "SELECT idCapacidade, capacidade FROM tbl_capacidade";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['idCapacidade'] . '">' . htmlspecialchars($row['capacidade']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum horario disponivel</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                    ?>
                </select>

                <p>Data</p>
                <input type="date" id="dataReserva" name="dataReserva">


                <p>Horario:</p>
                <select type="times" name="horario" id="horarioReserva">
                    <option value="">Selecione o horario da reserva:</option>
                    <?php
                    // Conectar ao banco de dados e buscar usuários
                    try {
                        $query = "SELECT idHora, descricao FROM tbl_hora";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['idHora'] . '">' . htmlspecialchars($row['descricao']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum horario disponivel</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }

                    $conn = null;
                    ?>
                </select>
                <input type="hidden" name="mtReserva" id="mtReserva" value="Reservar">

                <div tabindex="11" id="reservar" name="enviar" onclick="enviarReserva()"> Reservar</div>
            </form>

            <!-- Elemento de loading -->
            <div id="loading" class="loading"></div>
        </div>


        <!--MODAL RELATORIO DE RESERVA-->

        <div id="modal-relatorio">
            <span id="closeModal" class="material-symbols-outlined" onclick="fechaModalRelatorio()">
                close
            </span>

            <div class="modal1">
                <div class="tituloModal">
                    <p>RESERVA</p>
                    <img src="imagens/reserva-restaurante2-removebg-preview.png" alt="">
                </div>
                <div class="modal-geral">

                    <div class="relatorioReserva1">
                        <p class="relatorio1">Nome:</p>
                        <p class="relatorio1">Whatsapp:</p>
                        <p class="relatorio1">Tipo de Reserva:</p>
                        <p class="relatorio1">Quantidade de Pessoas:</p>
                        <p class="relatorio1">Data:</p>
                        <p class="relatorio1">Horario:</p>
                        <p class="relatorio1">Status:</p>
                    </div>
                    <div>
                        <div class="relatorioReserva">
                            <p id="reservaRelatorio"></p>
                            <p id="telRelatorio"></p>
                            <p id="tipoRelatorio"></p>
                            <p id="quantRelatorio"></p>
                            <p id="dataRelatorio"></p>
                            <p id="horaRelatorio"></p>
                            <p id="status">Reserva confirmada</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de preencha todos os campos -->
        <div id="modalPreenchaCampos" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModalPreenchaCampos()">&times;</span>
                <p>Preencha todos os campos!</p>
            </div>
        </div>
    </div>
    <footer class="rodape">
        <div class="endereco">
            <div id="logo-rodape" class="footerColum">
                <a href="index.html"><img src="imagens/utopiaLogo-removebg-preview.png" alt="Logotipo"></a>
            </div>

            <div class="locali">
                <h1>Localização</h1>
                <img class="iconFooter" src="imagens/icones/localizacao.png" alt="">
                <p>Rua Tito - 31 - Vila Romana</p>
                <p>São Paulo - SP</p>

                <h1>Telefone</h1>
                <img class="iconFooter" src="imagens/icones/chamada-telefonica.png" alt="">
                <p>(11) 3865-8028</p>
            </div>

            <div class="funcionamento">

                <h1>Horário de Funcionamento</h1>
                <img class="iconFooter" src="imagens/icones/relogio.png" alt="">
                <p>Segunda a sexta à partir das 14h</p>
                <p>Sabado: 11:00 as 00:00 horas</p>
                <p>Domingo 15:00 as 2:00 horas</p>

            </div>


            <div class="contato">
                <h1>Redes Sociais</h1>
                <img class="iconFooter" src="imagens/icones/instagram (1).png" alt="">
                <p>@utopiaBar</p>

                <!-- <h1>Whatsapp</h1> -->
                <img class="iconFooter" src="imagens/icones/whatsapp.png" alt="">
                <p>(11)96337-6433</p>


            </div>

    </footer>


    <!-- 
    <footer class="rodape">
        <div class="endereco">
            <div id="logo-rodape" class="footerColum">
                <a href="index.html"><img src="imagens/utopiaLogo-removebg-preview.png" alt="Logotipo"></a>
            </div>

            <div class="locali">
                <h1>Localização</h1>
                <img class="iconFooter" src="imagens/icones/localizacao.png" alt="">
                <p>Rua Tito - 31 - Vila Romana</p>
                <p>São Paulo - SP</p>


                <h1>Redes Sociais</h1>
                <img class="iconFooter" src="imagens/icones/instagram (1).png" alt="">
                <p>@utopiaBar</p>

            </div>

            <div class="contato">
                <h1>Telefone</h1>
                <img class="iconFooter" src="imagens/icones/chamada-telefonica.png" alt="">
                <p>(11) 3865-8028</p>
                <h1>Whatsapp</h1>
                <img class="iconFooter" src="imagens/icones/whatsapp.png" alt="">
                <p>(11)96337-6433</p>
            </div>

            <div class="funcionamento">

                <h1>Horário de Funcionamento</h1>
                <img class="iconFooter" src="imagens/icones/relogio.png" alt="">
                <p>Segunda a sexta à partir das 14h</p>
                <p>Sabado: 11:00 as 00:00 horas</p>
                <p>Domingo 15:00 as 2:00 horas</p>

            </div>
        </div>

    </footer> -->

    <div class="assinatura">
        <p>Desenvolvido por <b>Ronaldo e Kennedy</b> Site acadêmico |
            Todos os direitos reservados |
            SENAC TITO &copy; 2024</p>
    </div>
    <script src="js/acoes.js"></script>
</body>

</html>