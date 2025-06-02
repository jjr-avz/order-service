let answers = [];
let units = [];
let count = {};
let unitNames = [];
let medias = [];



fetch("http://82.29.56.140/apiqualify/loadanswer.php")
    .then(response => response.json())
    .then(data => {
        answers = data.data;
        units = data.unit;

        console.log("Respostas: ", answers);
        console.log("Unidades: ", units);

        calculeMedia();
        addLineTable();
        handleBarChart();
        handlePizza();

    })
    .catch(erro => console.error("Erro ao carregar os dados:", erro));

function calculeAnswers(){

    for(const answer of answers){
        const id = answer.unit_id;
        const note = answer.answers;

        if(!count[id]){
            count[id] = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0};
        }

        count[id][note]++;
    }
}

function addLineTable(){

    const tbody = document.getElementById('bodyTable');
    let line = "";
    calculeAnswers();

        for (const unit of units){
            const id = unit.id;
            const name = unit.name_unit;
            const c = count[id] || {1: 0, 2: 0, 3: 0, 4: 0, 5: 0};
        
            line += `
                <tr>
                    <td>${name}</td>
                    <td>${c[5]}</td>
                    <td>${c[4]}</td>
                    <td>${c[3]}</td>
                    <td>${c[2]}</td>
                    <td>${c[1]}</td>

                </td>
            `
        }

    tbody.innerHTML = line;

    console.log(count);

}

function handleBarChart(){
    const ctx = document.getElementById('barchart');

    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: unitNames,
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
}

function handlePizza(){
    const ctx = document.getElementById('pizza').getContext('2d');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo'],
        datasets: [{
          label: 'Avaliações',
          data: [23, 14, 5, 5, 5],
          backgroundColor: [
            '#0a73ff',
            '#1aff6d',
            '#dbff3c',
            '#ff9358',
            '#ff3a1c'
          ],
          borderColor: [
            '#0a73ff',
            '#1aff6d',
            '#dbff3c',
            '#ff9358',
            '#ff3a1c'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false,
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'ESF SANTO ANTONIO'
          }
        }
      }
    });    
}

function calculeMedia(){    
    unitNames = units.map(u => u.name_unit);

    medias = units.map(unit => {
        const c = count[unit.id] || {1: 0, 2: 0, 3: 0, 4: 0, 5: 0};
        let total = 0;
        let soma = 0;

        console.log("teste: ", count[unit.id])

        for(let i = 1; i <= 5; i++){
            const q = c[i] || 0;
            soma += i * q;
            total += q;
        }

        return total > 0 ? parseFloat((soma / total).toFixed(2)) : 0;
    });

    console.log("Media: ", medias);
    console.log("Nomes Unidades: ", unitNames);
}