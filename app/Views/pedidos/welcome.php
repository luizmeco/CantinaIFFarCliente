<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="welcome-container">
    <div class="welcome-card">
        <div class="welcome-icon">🍔🍟🥤</div>
        <h1 class="welcome-title">Bem-vindo à Cantina IFFar</h1>
        <p class="welcome-subtitle">Rápido, fácil e delicioso! Monte seu pedido em poucos passos.</p>
        
        <div class="action-section">
            <a href="<?= base_url('pedidos/iniciar') ?>" class="btn-start-order">
                <span>INICIAR PEDIDO</span>
                <div class="btn-shine"></div>
            </a>
        </div>
    </div>

    <!-- Rodapé da Tela de Boas-vindas -->
    <div class="welcome-footer">
        <span class="totem-id-display">📍 Identificação do Terminal: <strong><?= esc($totem_id) ?></strong></span>
        <button class="btn-admin-config" onclick="abrirConfigModal()" title="Configurações do Totem">⚙️</button>
    </div>
</div>

<!-- Modal Administrativo de Configuração do Totem -->
<div id="config-modal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Configurações do Totem</h3>
            <button class="btn-close-modal" onclick="fecharConfigModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= base_url('pedidos/configurar-totem') ?>" method="POST" onsubmit="return validarSenhaAdmin()">
                <div class="form-group">
                    <label for="totem_id">Identificação do Totem</label>
                    <input type="text" id="totem_id" name="totem_id" value="<?= esc($totem_id) ?>" placeholder="Ex: Totem Entrada" required>
                </div>
                <div class="form-group">
                    <label for="admin_password">Senha do Administrador</label>
                    <input type="password" id="admin_password" placeholder="Digite a senha (padrão 1234)" required>
                </div>
                <div id="error-msg" class="error-message" style="display: none;">Senha administrativa inválida!</div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="fecharConfigModal()">Cancelar</button>
                    <button type="submit" class="btn-submit">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirConfigModal() {
    document.getElementById('config-modal').classList.add('active');
    document.getElementById('totem_id').focus();
}

function fecharConfigModal() {
    document.getElementById('config-modal').classList.remove('active');
    document.getElementById('admin_password').value = '';
    document.getElementById('error-msg').style.display = 'none';
}

function validarSenhaAdmin() {
    const passwordInput = document.getElementById('admin_password').value;
    const errorMsg = document.getElementById('error-msg');
    
    // Senha padrão configurada: 1234
    if (passwordInput === '1234') {
        errorMsg.style.display = 'none';
        return true;
    } else {
        errorMsg.style.display = 'block';
        return false;
    }
}
</script>

<?= $this->endSection() ?>
