<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Cantina IFFar - Totem de Pedidos' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/totem.css') ?>">
</head>
<body>
    <header class="totem-header">
        <div class="header-container">
            <div class="logo-section">
                <h1 class="logo">🍔 Cantina IFFar</h1>
            </div>
            <div class="info-section">
                <?php if (!empty($carrinho)): ?>
                    <div class="carrinho-badge">
                        <a href="<?= base_url('/pedidos/carrinho') ?>" class="carrinho-link">
                            🛒 <?= count($carrinho) ?> item(ns)
                        </a>
                    </div>
                <?php endif; ?>
                <div class="total-display">
                    R$ <span id="total-header">
                        <?php
                            $total = 0;
                            foreach ($carrinho ?? [] as $item) {
                                $precoItem = $item['preco'] ?? $item['preco_unitario'] ?? 0;
                                $total += $precoItem * $item['quantidade'];
                            }
                            echo number_format($total, 2, ',', '.');
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <main class="totem-main">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('js/totem.js') ?>"></script>
</body>
</html>
