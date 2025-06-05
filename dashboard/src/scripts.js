let units = [];

fetch("https://jjavz.site/apiqualify/loadvotes.php")
  .then(response => response.json())
  .then(data => {
    units = data;

    handleTable();
    handleBarChart();
    handlePizza();
  })


function handleTable(){
    const table = document.querySelector("table");
    const body = document.createElement("tbody");

    for(const unit of units){
        let tr = document.createElement("tr");
        let uName = document.createElement("td"); 
        let uExc = document.createElement("td"); 
        let uGd = document.createElement("td"); 
        let uReg = document.createElement("td"); 
        let uBad = document.createElement("td"); 
        let uVb = document.createElement("td");

        uName.innerHTML = unit.name;
        uExc.innerHTML = unit.answer[4];
        uGd.innerHTML = unit.answer[3];
        uReg.innerHTML = unit.answer[2];
        uBad.innerHTML = unit.answer[1];
        uVb.innerHTML = unit.answer[0];

        tr.appendChild(uName);
        tr.appendChild(uExc);
        tr.appendChild(uGd);
        tr.appendChild(uReg);
        tr.appendChild(uBad);
        tr.appendChild(uVb);

        body.appendChild(tr);
    }

    table.appendChild(body);
}

function handleBarChart(){

    const nameUnit = units.map(u => u.name);
    const mediaUnit = units.map(u => u.media);

    const barBackground = units.map(u => {
        const media = u.media;
        if(media >= 4) return 'rgba(54, 162, 235, 0.9)';
        if(media >= 3) return 'rgba(75, 210, 98, 0.9)';
        if(media >= 2) return 'rgba(255, 205, 86, 0.9)';
        if(media >= 1) return 'rgba(255, 159, 64, 0.9)';
        return 'rgba(255, 99, 99, 0.8)';
    })

    const ctx = document.getElementById('barchart');

    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: nameUnit,
        datasets: [{
            label: 'Média de votos por unidade',
            data: mediaUnit,
            backgroundColor: barBackground,
            borderColor: barBackground,
            borderWidth: 1
        }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks:{
                        color: '#fff'
                    }
                },
                x: {
                    ticks:{
                        color: '#fff'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Média de Votos por unidade',
                    color: '#fff'
                }
            }
        }
    });
}

function handlePizza(){
    const ctx = document.getElementById('area-pizza');

    for(const unit of units){
        if(unit.media != null){
            const canvas = document.createElement('canvas');
        
            new Chart(canvas, {
              type: 'pie',
              data: {
                labels: ['Péssimo', 'Ruim', 'Regular', 'Bom', 'Excelente'],
                datasets: [{
                  label: 'Avaliações',
                  data: unit.answer,
                  backgroundColor: [
                    '#ff3a1c',
                    '#ff9358',
                    '#dbff3c',
                    '#1aff6d',
                    '#0a73ff'
                  ],
                  borderColor: [
                    '#d5d5d5'            
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
                    text: unit.name,
                    color: '#000'
                  }
                }
              }
            });    
            ctx.appendChild(canvas);
        }
    }
}