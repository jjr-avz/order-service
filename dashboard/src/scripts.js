let answers = [];
let units = [];

fetch("http://82.29.56.140/apiqualify/loadanswer.php")
    .then(response => response.json())
    .then(data => {
        answers = data.data;
        units = data.unit;

        console.log("Respostas: ", answers);
        console.log("Unidades: ", units);

        addLineTable();

    })
    .catch(erro => console.error("Erro ao carregar os dados:", erro));

function calculeAnswers(){
    const count = {};

    for(const answer of answers){
        const id = answer.unit_id;
        const note = answer.answers;

        if(!count[id]){
            count[id] = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0};
        }

        count[id][note]++;
    }

    return count;
}

function addLineTable(){

    const tbody = document.getElementById('bodyTable');
    let line = "";
    const count = calculeAnswers();

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

