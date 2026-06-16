<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="produtos-container">
    <!-- Filtros de Categorias -->
    <div class="filtros-section">
        <button class="filtro-btn active" onclick="filtrarProdutos('todos')">
            Todos
        </button>
        <button class="filtro-btn" onclick="filtrarProdutos('Lanche')">
            Lanches
        </button>
        <button class="filtro-btn" onclick="filtrarProdutos('Bebida')">
            Bebidas
        </button>
        <button class="filtro-btn" onclick="filtrarProdutos('Acompanhamento')">
            Acompanhamentos
        </button>
        <button class="filtro-btn" onclick="filtrarProdutos('Sobremesa')">
            Sobremesas
        </button>
    </div>

    <!-- Grid de Produtos -->
    <div class="produtos-grid">
        <?php foreach ($produtos as $produto): ?>
            <div class="produto-card" data-categoria="<?= $produto['categoria'] ?>">
                <div class="produto-imagem">
                    <?php if (!empty($produto['foto'])): ?>
                        <?php $apiUrl = rtrim(env('API_BASE_URL'), '/'); ?>
                        <img src="<?= $apiUrl ?>/uploads/produtos/<?= $produto['foto'] ?>" alt="<?= $produto['nome'] ?>" style="max-width: 100%; height: 120px; object-fit: contain; border-radius: 8px;">
                    <?php else: ?>
                        🍔
                    <?php endif; ?>
                </div>
                <h3 class="produto-nome"><?= $produto['nome'] ?></h3>
                <p class="produto-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <a href="<?= base_url('pedidos/adicionar/') ?><?= $produto['id'] ?>" class="btn-add">
                    Adicionar
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Proceder para Checkout -->
    <?php if (!empty($carrinho)): ?>
        <div class="checkout-fixed">
            <a href="<?= base_url('pedidos/carrinho') ?>" class="btn-checkout">
                Ir para Carrinho
            </a>
        </div>
    <?php else: ?>
        <div class="checkout-fixed" style="visibility: hidden;">
            <a href="<?= base_url('pedidos/carrinho') ?>" class="btn-checkout">
                Ir para Carrinho
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
