const menuItem = document.querySelectorAll('.item-menu');

function selectItem(){
    menuItem.forEach((item) =>
        item.classList.remove('ativo')
    )
    this.classList.add('ativo')
}

menuItem.forEach((item) => 
    item.addEventListener('click', selectItem)
) 

/* const menuItems = document.querySelectorAll('.item-menu');

function selectItem(){
    const iframe = document.querySelector("iframe[name='container-dashboard']");

    if(!iframe) return;

    const urlAtual = new URL(iframe.contentWindow.location.href).pathname;

    menuItems.forEach(item => {
        const link = item.querySelector("a");

        if(link && link.getAttribute("href").includes(urlAtual)){
            item.classList.add("ativo");
        }else{
            item.classList.remove("ativo");
        }
    })
}

const menuItems = document.querySelectorAll('.item-menu');

function marcarAtivo() {
    const iframe = document.querySelector("iframe[name='container-dashboard']");
    
    console.log("ola");

    if (!iframe) return;

    // Pega a URL atual carregada no iframe
    const urlAtual = new URL(iframe.contentWindow.location.href).pathname;

    menuItems.forEach(item => {
        const link = item.querySelector("a");
        console.log(link);
        console.log(urlAtual);
        if (link && link.getAttribute("href").includes(urlAtual)) {
            item.classList.add("ativo");
        } else {
            item.classList.remove("ativo");
        }
    });
}

// Chama a função sempre que o iframe carregar uma nova página
document.querySelector("iframe[name='container-dashboard']").addEventListener("load", marcarAtivo);

// Executa a função ao carregar a página para marcar o item correto
marcarAtivo();*/