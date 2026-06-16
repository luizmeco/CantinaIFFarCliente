<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="carrinho-container">
    <div class="carrinho-header">
        <h2>🛒 Seu Carrinho</h2>
    </div>

    <?php if (!empty($carrinho)): ?>
        <div class="carrinho-itens">
            <?php foreach ($carrinho as $item): ?>
                <div class="carrinho-item">
                    <div class="item-info">
                        <div class="item-imagem">
                            <?= $item['foto'] ?? $item['imagem'] ?? '🍔' ?>
                        </div>
                        <div class="item-detalhes">
                            <h4 class="item-nome"><?= $item['nome'] ?></h4>
                            <?php $precoItem = $item['preco'] ?? $item['preco_unitario'] ?? 0; ?>
                            <p class="item-preco">R$ <?= number_format($precoItem, 2, ',', '.') ?></p>
                        </div>
                    </div>

                    <div class="item-quantidade">
                        <?php $idProduto = $item['id_produto'] ?? $item['id']; ?>
                        <a href="<?= base_url('/pedidos/atualizar/') ?><?= $idProduto ?>/<?= $item['quantidade'] - 1 ?>" class="btn-qty">
                            −
                        </a>
                        <input type="text" class="qty-input" value="<?= $item['quantidade'] ?>" readonly>
                        <a href="<?= base_url('/pedidos/atualizar/') ?><?= $idProduto ?>/<?= $item['quantidade'] + 1 ?>" class="btn-qty">
                            +
                        </a>
                    </div>

                    <div class="item-total">
                        R$ <?= number_format($precoItem * $item['quantidade'], 2, ',', '.') ?>
                    </div>

                    <a href="<?= base_url('/pedidos/remover/') ?><?= $idProduto ?>" class="btn-remover">
                        ✕
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="carrinho-resumo">
            <div class="resumo-linha">
                <span>Subtotal:</span>
                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
            </div>
            <div class="resumo-linha taxas">
                <span>Taxas:</span>
                <span>R$ 0,00</span>
            </div>
            <div class="resumo-linha total">
                <span>TOTAL:</span>
                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="carrinho-acoes">
            <a href="<?= base_url('pedidos') ?>" class="btn-voltar">
                Voltar
            </a>
            <a href="<?= base_url('pedidos/confirmar') ?>" class="btn-confirmar">
                Confirmar Pedido
            </a>
        </div>
    <?php else: ?>
        <div class="carrinho-vazio">
            <div class="vazio-icone">🛒</div>
            <p>Seu carrinho está vazio</p>
            <a href="<?= base_url('pedidos') ?>" class="btn-voltar">
                Continuar Comprando
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
