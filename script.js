fetch('dados.json')
    .then(resposnse => resposnse.json())
    .then(dados => {
        const pessoa = dados[dados.length - 1];
        const imc = pessoa.imc;

        let mensagem = '';

        if (imc > 40) {
            mensagem = 'Obesidade grau III';
        } else if (imc > 35) {
            mensagem = 'Obesidade grau II';
        } else if (imc > 30) {
            mensagem = 'Obesidade grau I';
        } else if (imc > 25) {
            mensagem = 'Sobrepeso';
        } else if (imc >= 18.5) {
            mensagem = 'Normal';
        } else {
            mensagem = 'Abaixo do normal';
        }

        const resultado = document.getElementById('resultado');
        resultado.innerHTML = `<p>Seu IMC: ${imc} — ${mensagem}</p>`;

    })
    .catch(error => console.error('Erro ao carregar JSON: ', error));