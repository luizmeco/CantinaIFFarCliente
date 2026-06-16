
/**
 * Função para filtrar produtos por categoria
 * @param {string} categoria - A categoria a filtrar (todos, lanches, bebidas, etc)
 */
function filtrarProdutos(categoria) {
    // Atualizar botão ativo
    const botoes = document.querySelectorAll('.filtro-btn');
    botoes.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Filtrar produtos
    const produtos = document.querySelectorAll('.produto-card');
    
    produtos.forEach(produto => {
        if (categoria === 'todos') {
            produto.classList.remove('hidden');
        } else {
            const produtoCategoria = produto.getAttribute('data-categoria');
            if (produtoCategoria === categoria) {
                produto.classList.remove('hidden');
            } else {
                produto.classList.add('hidden');
            }
        }
    });
}

/**
 * Função para atualizar o total exibido no header
 */
function atualizarTotalHeader() {
    // Esta função pode ser expandida se necessário adicionar requisições AJAX no futuro
    // Por agora, o total é atualizado via reload da página (comportamento atual)
}

/**
 * Função para impressão do ticket (opcional - preparada para uso futuro)
 */
function imprimirTicket() {
    window.print();
}

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    // Qualquer lógica adicional de inicialização pode ir aqui
    console.log('Totem Cantina IFFar\'s carregado com sucesso!');
});

// Atalhos de teclado (opcional - para facilitar uso em kiosk)
document.addEventListener('keydown', function(event) {
    // ESC volta para a página inicial
    if (event.key === 'Escape') {
        window.location.href = '/pedidos';
    }
    
    // ENTER confirma o pedido (se estiver na página do carrinho)
    if (event.key === 'Enter' && document.querySelector('.btn-confirmar')) {
        const btn = document.querySelector('.btn-confirmar');
        if (btn) {
            btn.click();
        }
    }
});
