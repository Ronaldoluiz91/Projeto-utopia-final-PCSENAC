// document.getElementById('formRelatorioReservas').addEventListener('submit', function(event) {
//     event.preventDefault(); // Evita o envio padrão do formulário

//     const formData = new FormData(this);

//     fetch('http://localhost/Utopia-final/private/controller/Reserva.controller.php?action=gerarRelatorio', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status) {
//             // Processar as reservas retornadas
//             console.log(data.result);
//             // Você pode atualizar a tabela ou fazer qualquer outra ação necessária
//         } else {
//             alert(data.msg);
//         }
//     })
//     .catch(error => console.error('Erro:', error));
// });


document.getElementById('formRelatorioReservas').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    const formData = new FormData(this);

    fetch('http://localhost/Utopia-final/private/controller/Reserva.controller.php?action=gerarRelatorio', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Para verificar a resposta completa
        if (data.status) {
            const reservas = data.reservas; // Obtenha as reservas
            const tabela = document.getElementById('tabelaReservas'); // Supondo que você tenha uma tabela com esse ID
            tabela.innerHTML = ''; // Limpa o conteúdo existente da tabela

            // Crie linhas para cada reserva
            reservas.forEach(reserva => {
                const row = document.createElement('tr'); // Cria uma nova linha

                // Adicione células com os dados da reserva
                row.innerHTML = `
                    <td>${reserva.nome}</td>
                    <td>${reserva.whatsapp}</td>
                    <td>${reserva.dataReserva}</td>
                    <td>${reserva.descricaoMesa}</td>
                    <td>${reserva.descricaoHora}</td>
                    <td>${reserva.descricaoTipoReserva}</td>
                `;
                
                tabela.appendChild(row); // Adiciona a linha à tabela
            });
        } else {
            alert(data.msg);
        }
    })
    .catch(error => console.error('Erro:', error));
});



//Relatorio de contatos

document.getElementById('formRelatorioContatos').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    const formData = new FormData(this);

    fetch('http://localhost/Utopia-final/private/controller/Contato.controller.php?action=gerarRelatorio', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Para verificar a resposta completa
        if (data.status) {
            const contatos = data.contatos; 
            const tabela = document.getElementById('tabelaContato');
            tabela.innerHTML = ''; // Limpa o conteúdo existente da tabela

            // Crie linhas para cada reserva
            contatos.forEach(contato => {
                const row = document.createElement('tr'); // Cria uma nova linha

                // Adicione células com os dados da reserva
                row.innerHTML = `
                    <td>${contato.nome}</td>
                    <td>${contato.celular}</td>
                   
                    <td>${contato.mensagem}</td>
                `;
                
                tabela.appendChild(row); // Adiciona a linha à tabela
            });
        } else {
            alert(data.msg);
        }
    })
    .catch(error => console.error('Erro:', error));
});

