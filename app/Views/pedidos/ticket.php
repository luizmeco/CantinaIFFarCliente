<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="ticket-container">
    <div class="ticket-paper">
        <!-- Cabeçalho do Ticket -->
        <div class="ticket-header">
            <h2>Cantina IFFar</h2>
            <p class="ticket-subtitle">Totem de Pedidos</p>
        </div>

        <!-- Linha de Divisão -->
        <div class="ticket-divider"></div>

        <!-- Número do Pedido -->
        <div class="ticket-numero">
            <p class="numero-label">PEDIDO Nº</p>
            <p class="numero-valor"><?= str_pad($pedido['numero'], 3, '0', STR_PAD_LEFT) ?></p>
        </div>

        <!-- Linha de Divisão -->
        <div class="ticket-divider"></div>

        <!-- Itens do Pedido -->
        <div class="ticket-itens">
            <table class="itens-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qtd</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido['itens'] as $item): ?>
                        <tr>
                            <td class="item-nome"><?= $item['nome'] ?></td>
                            <td class="item-qty"><?= $item['quantidade'] ?></td>
                            <?php $precoItem = $item['preco'] ?? $item['preco_unitario'] ?? 0; ?>
                            <td class="item-total">R$ <?= number_format($precoItem * $item['quantidade'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Linha de Divisão -->
        <div class="ticket-divider"></div>

        <!-- Totais -->
        <div class="ticket-totais">
            <div class="total-linha">
                <span>Subtotal:</span>
                <span>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></span>
            </div>
            <div class="total-linha">
                <span>Desconto:</span>
                <span>R$ 0,00</span>
            </div>
            <div class="total-linha destaque">
                <span>TOTAL:</span>
                <span>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></span>
            </div>
        </div>

        <!-- Linha de Divisão -->
        <div class="ticket-divider"></div>

        <!-- Informações Adicionais -->
        <div class="ticket-info">
            <p class="info-linha">Origem: <strong><?= esc($totem_id ?? 'Totem Geral') ?></strong></p>
            <p class="info-linha">Data: <?= $pedido['data'] ?></p>
            <p class="info-linha">Agradecemos sua compra!</p>
            <p class="info-linha">Bom apetite! 🍔</p>
        </div>
    </div>

    <!-- Botão para Novo Pedido -->
    <div class="ticket-acoes">
        <a href="<?= base_url('pedidos') ?>" class="btn-novo-pedido">
            Fazer Novo Pedido
        </a>
    </div>
</div>

<?= $this->endSection() ?>
