function confirmarExclusao(form) {
    if (confirm("Tem certeza que deseja excluir este registro?")) {
        return true;  // Prossegue com a exclusão
    }
    return false;  // Cancela o envio do formulário
}