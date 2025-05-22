fetch("http://82.29.56.140/apiqualify/loadanswer.php")
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(erro => console.error("Erro ao carregar os dados:", erro));