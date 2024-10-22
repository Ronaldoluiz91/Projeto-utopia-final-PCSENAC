//MENU DA VERSÃO MOBILE

var btnmostrar = document.getElementById('iconMenu'); // icone  do menu
var menu = document.getElementById('itens'); // menu a ser ocultado e/ou mostrado
var logo = document.getElementById('logotipo'); // logotipo do site
var btnOcultar = document.getElementById('iconClose') // icone fechar do menu


btnmostrar.addEventListener('click', function () {
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }

})

btnmostrar.addEventListener('click', function () {
    if (logo.style.display === 'none') {
        logo.style.display = 'block';
    } else {
        logo.style.display = 'none';

    }

})

btnOcultar.addEventListener('click', function () {
    menu.style.display = 'none';
    logo.style.display = 'block'
});





// Slider de abertura da pagina Index

var image = 1;
var totalImages = 7;


function dissolveImages() {
    var currentImg = document.getElementById('img' + image);

    var nextImage = image === totalImages ? 1 : image + 1;

    var nextImg = document.getElementById('img' + nextImage);

    // Alterna entre as imagens
    currentImg.style.opacity = 0;
    nextImg.style.opacity = 1;

    // Atualiza o número da próxima imagem
    image = nextImage;

    // Chama a função novamente após um intervalo
    setTimeout(dissolveImages, 5000); // Tempo de transição entre as imagens
}

// Inicia a dissolução das imagens
dissolveImages();

// slider- cardapio pagina index

var slides = document.querySelector('.slides');
var slide = document.querySelectorAll('.slide');
var intervalTime = 3000; // Tempo de troca de slide
var slideIndex = 0;

var nextSlide = () => {
    slideIndex++;
    if (slideIndex === slide.length) {
        slideIndex = 0;
    }
    updateSlide();
}

var updateSlide = () => {
    slides.style.transform = `translateX(-${slideIndex * 100}%)`;
}

setInterval(nextSlide, intervalTime);



//Pagina reserva

// function enviarReserva() {

//     var nome = document.getElementById('nomeReserva').value;
//     var telefone = document.getElementById('telefoneReserva').value;
//     var reserva = document.getElementById('reserva').value;
//     var quantidade = document.getElementById('quantidade').value;
//     var horario = document.getElementById('horarioReserva').value;
//     var status = document.getElementById('status')

//     var inputDate = document.getElementById('dataReserva');
//     // Adicionando um ouvinte de evento 'change' para capturar a mudança de valor
//     inputDate.addEventListener('change', function () {
//         // Obtendo o valor do input
//         var dataReserva = this.value;
//     });


//     // Função para mostrar o modal de preencha todos os campos
//     function mostrarModalPreenchaCampos() {
//         document.getElementById('modalPreenchaCampos').style.display = 'block';
//     }

//     //verifica se todos os campos estão preenchidos
//     if (nome === "" || telefone === "" || reserva === "" || quantidade === "" || dataReserva === "" || horario === "") {
//         mostrarModalPreenchaCampos();
//     } else {

//         // Mostrar o loading
//         document.getElementById('loading').style.display = 'block';

//         document.getElementById('reservaRelatorio').innerHTML = nome
//         document.getElementById('telRelatorio').innerHTML = telefone
//         document.getElementById('tipoRelatorio').innerHTML = reserva
//         document.getElementById('quantRelatorio').innerHTML = quantidade
//         document.getElementById('dataRelatorio').innerHTML = dataReserva.value
//         document.getElementById('horaRelatorio').innerHTML = horario

//         status.style.display = 'block'

//         var modalRelatorio = document.getElementById('modal-relatorio')

//         setTimeout(function () {
//             // Esconder o loading e mostrar o modal
//             document.getElementById('loading').style.display = 'none';
//             document.getElementById('modal-relatorio').style.display = 'block';
//         }, 3000);


//         // Limpar os campos após enviar
//         document.getElementById('nomeReserva').value = "";
//         document.getElementById('telefoneReserva').value = "";
//         document.getElementById('reserva').value = "";
//         document.getElementById('quantidade').value = "";
//         document.getElementById('dataReserva').value = "";
//         document.getElementById('horarioReserva').value = "";

//     }

// }


function enviarReserva() {
    const nome = document.getElementById('nomeReserva').value;
    const whatsapp = document.getElementById('telefoneReserva').value;
    const tipoReserva = document.getElementById('reserva').value;
    const quantidade = document.getElementById('quantidade').value;
    const data = document.getElementById('dataReserva').value;
    const horario = document.getElementById('horarioReserva').value;
    const mtReserva = document.getElementById('mtReserva').value;

    // Verifica se todos os campos estão preenchidos
    if (nome === "" || whatsapp === "" || tipoReserva === "" || quantidade === "" || data === "" || horario === "") {
        mostrarModalPreenchaCampos();
        return;
    }

    const dados = new FormData();
    dados.append('mtReserva', mtReserva);
    dados.append('nome', nome);
    dados.append('whatsapp', whatsapp);
    dados.append('tipoReserva', tipoReserva);
    dados.append('quantidade', quantidade);
    dados.append('dataReserva', data);
    dados.append('hora', horario);

    document.getElementById('loading').style.display = 'block';

    fetch('private/controller/Reserva.controller.php', {
            method: 'POST',
            body: dados
        })
        .then(response => response.json())
        .then(data => {

            setTimeout(() => {
                document.getElementById('loading').style.display = 'none';

                if (data.status) {

                    // alert(data.msg);

                    // Se a reserva foi bem-sucedida, abre o modal com os dados da reserva
                    abreModal({
                        nome: nome,
                        whatsapp: whatsapp,
                        descricaoTipoReserva: data.tipoReserva,
                        quantidade: data.capacidade,
                        dataReserva: data.dataReserva,
                        descricaoHora: data.hora
                    });
                } else {
                    alert(data.msg); // Exibe mensagem de erro
                }
            }, 5000);
        })
        .catch(error => console.error('Erro:', error));
}

function abreModal(reserva) {
    // Preenchendo os campos do modal com os dados da reserva
    document.getElementById('reservaRelatorio').innerHTML = reserva.nome;
    document.getElementById('telRelatorio').innerHTML = reserva.whatsapp;
    document.getElementById('tipoRelatorio').innerHTML = reserva.descricaoTipoReserva;
    document.getElementById('quantRelatorio').innerHTML = reserva.quantidade;
    document.getElementById('dataRelatorio').innerHTML = reserva.dataReserva;
    document.getElementById('horaRelatorio').innerHTML = reserva.descricaoHora;
    document.getElementById('status').innerText = "Reserva confirmada";

    // Exibir o modal
    document.getElementById('modal-relatorio').style.display = 'block';
}




// Função para mostrar o modal de "Preencha todos os campos"
function mostrarModalPreenchaCampos() {
    document.getElementById('modalPreenchaCampos').style.display = 'block';
}


function fecharModalPreenchaCampos() {
    document.getElementById('modalPreenchaCampos').style.display = 'none';
}

function fechaModalRelatorio() {
    // Seleciona o modal de relatório pelo ID
    const modalRelatorio = document.getElementById('modal-relatorio');

    // Esconde o modal de relatório
    modalRelatorio.style.display = 'none';
}



//Função para enviar contato pro controller



function mostrarEnviado() {
    document.getElementById('modalEnviado').style.display = 'block';
}

function fecharModalEnviado() {
    document.getElementById('modalEnviado').style.display = 'none';
}



function enviarContato() {
    const nome = document.getElementById('nome').value;
    const telefone = document.getElementById('telefone').value;
    const assunto = document.getElementById('assunto').value;
    const mensagem = document.getElementById('mensagem').value;

    const mtContato = document.getElementById('mtContato').value;

    // Verifica se todos os campos estão preenchidos
    if (nome === "" || telefone === "" || assunto === "" || mtContato === "" || mensagem === '') {
        mostrarModalPreenchaCampos();
        return;
    }

    const dados = new FormData();
    dados.append('mtContato', mtContato);
    dados.append('nome', nome);
    dados.append('telefone', telefone);
    dados.append('assunto', assunto);
    dados.append('mensagem', mensagem);


    fetch('private/controller/Contato.controller.php', {
            method: 'POST',
            body: dados
        })
        .then(response => {
            console.log(response); // Verifique a resposta do servidor
            return response.json();
        })
        .then(data => {
            console.log(data); // Verifique os dados recebidos
            if (data.status) {
                // alert(data.msg);
                mostrarEnviado();

            } else {
                alert(data.msg); // Exibe mensagem de erro
            }
        })
        .catch(error => console.error('Erro:', error));
}





// pagina contato

// function enviarFormulario() {
//     var nome = document.getElementById("nome").value;
//     var telefone = document.getElementById("telefone").value;
//     var assunto = document.getElementById("assunto").value;
//     var mensagem = document.getElementById("mensagem").value;

//     if (nome && telefone && assunto && mensagem) {
//         mostrarModal('modal-enviado');
//         limparFormulario();
//     } else {
//         mostrarModal('modal-nao-preenchido');
//     }
// }

// function mostrarModal(id) {  //Esta função recebe um parâmetro id, que é o ID do modal que deve ser exibido. 
//     //Ela encontra o modal correspondente usando document.getElementById(id)
//     var modal = document.getElementById(id);
//     modal.style.display = "block";
// }

// function fecharModal(id) { //esta função recebe um parâmetro id, que é o ID do modal que deve ser fechado.
//     // Ela encontra o modal correspondente usando document.getElementById(id)
//     var modal = document.getElementById(id);
//     modal.style.display = "none";
// }

// function limparFormulario() {
//     document.getElementById("nome").value = "";
//     document.getElementById("telefone").value = "";
//     document.getElementById("assunto").value = "";
//     document.getElementById("mensagem").value = "";
// }