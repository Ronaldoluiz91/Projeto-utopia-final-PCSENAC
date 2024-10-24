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

<body>

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
                <a href="index.php" tabindex="1">Home</a>
                <!--tabindex é utilizado para a acessibilidade-->
                <a href="cardapio.html" tabindex="2">Cardapio</a>
                <a href="reserva.php" tabindex="3">Reserva</a>
                <a href="contato.php" tabindex="4">Contato</a>
                <a href="trabalheConosco.php" tabindex="5">Trabalhe Conosco</a>
            </nav>
        </div>
    </header>
    <div class="titulo-contato">
        <!-- <h3>Vamos Conversar</h3> -->
        <div class="conteudo-contato">

            <h3>Vamos Conversar</h3>

            <p> Deixe-nos uma mensagem e uma forma de contato para resposta.</p>
            <p>Em breve retornaremos</p>

            <form action="" id="form-contato" method="post">
                <p>
                    <label for="nome">Nome:</label>
                    <input tabindex="5" required type="text" id="nome" name="nome">
                </p>
                <p>
                    <label for="telefone">Celular:</label>
                    <input tabindex="6" required type="tel" id="telefone" name="telefone">
                </p>
                <label for="assunto">Assunto:</label>
                <select name="assunto" id="assunto" required>
                    <option value="">Selecione o Assunto</option>
                   <?php
                    // Conectar ao banco de dados e buscar usuários
                    try {
                        require "private/config/db/conn.php";
                        $query = "SELECT idAssunto, descricao FROM tbl_assunto";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['idAssunto'] . '">' . htmlspecialchars($row['descricao']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum horario disponivel</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                    ?>
                </select>
                <p>
                    <label for="mensagem">Mensagem:</label>
                    <textarea tabindex="7" name="mensagem" id="mensagem" cols="30" rows="6" required></textarea>
                </p>

                <input type="hidden" name="mtContato" id="mtContato" value="Contato">

                <!-- <input type="hidden" name="data_criacao" value="<?php echo date('Y-m-d H:i:s'); ?>"> -->

                <p>
                <div tabindex="9" id="enviarContato" name="enviar" onclick="enviarContato()">ENVIAR</div>
                </p>
            </form>

            <div id="modal-enviado" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="fecharModal('modal-enviado')">&times;</span>
                    <h2>Confirmação de Envio</h2>
                    <p>Sua mensagem foi enviada com sucesso!</p>
                </div>
            </div>

            <div id="modal-nao-preenchido" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="fecharModal('modal-nao-preenchido')">&times;</span>
                    <h2>Erro</h2>
                    <p>Por favor, preencha todos os campos antes de enviar.</p>
                </div>
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


    <!-- <footer class="rodape">
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


      <!-- Modal de preencha todos os campos -->
        <div id="modalPreenchaCampos" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModalPreenchaCampos()">&times;</span>
                <p>Preencha todos os campos!</p>
            </div>
        </div>


         <!-- Modal de preencha todos os campos -->
        <div id="modalEnviado" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModalEnviado()">&times;</span>
                <p>Mensagem enviada com sucesso!</p>
            </div>
        </div>

    <script src="js/acoes.js"></script>
</body>

</html>