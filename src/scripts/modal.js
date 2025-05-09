function openModal(imagem){

    let modal = parent.document.querySelector("#modalGlobal");

    if(modal){
        let imgTag = parent.document.querySelector("#modalImagem");
        imgTag.src = imagem;

        modal.setAttribute("aria-hidden", "false");

        setTimeout(() => {
            document.body.setAttribute("inert", "");
            new parent.bootstrap.Modal(modal).show();
            document.body.removeAttribute("inert");
        }, 10);
    }else{
        console.error("Modal não encontrado no documento principal")
    }
}