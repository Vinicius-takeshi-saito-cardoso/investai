<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

$pdo = getDatabase();
$ticker = strtoupper(trim($_GET['ticker'] ?? $_POST['ticker'] ?? ''));
$tickerValido = $ticker !== '' && preg_match('/^[A-Z0-9]{3,20}$/', $ticker);
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isAuthenticated()) {
    $acao = $_POST['acao'] ?? '';

    if (!$tickerValido) {
        $error = 'Ticker invalido.';
    } elseif ($acao === 'adicionar') {
        $stmt = $pdo->prepare('INSERT IGNORE INTO favoritos (usuario_id, ticker) VALUES (:usuario_id, :ticker)');
        $stmt->execute(['usuario_id' => currentUserId(), 'ticker' => $ticker]);
        $message = $stmt->rowCount() ? 'Ativo adicionado aos favoritos.' : 'Este ativo ja esta nos seus favoritos.';
    } elseif ($acao === 'remover') {
        $stmt = $pdo->prepare('DELETE FROM favoritos WHERE usuario_id = :usuario_id AND ticker = :ticker');
        $stmt->execute(['usuario_id' => currentUserId(), 'ticker' => $ticker]);
        $message = 'Favorito removido.';
    }
}

$ativo = null;
$favoritado = false;

if ($tickerValido) {
    $stmt = $pdo->prepare('SELECT ticker, nome, tipo, setor FROM ativos WHERE ticker = :ticker LIMIT 1');
    $stmt->execute(['ticker' => $ticker]);
    $ativo = $stmt->fetch() ?: ['ticker' => $ticker, 'nome' => null, 'tipo' => null, 'setor' => null];

    if (isAuthenticated()) {
        $stmt = $pdo->prepare('SELECT id FROM favoritos WHERE usuario_id = :usuario_id AND ticker = :ticker LIMIT 1');
        $stmt->execute(['usuario_id' => currentUserId(), 'ticker' => $ticker]);
        $favoritado = (bool) $stmt->fetch();
    }
} elseif ($ticker !== '') {
    $error = 'Informe um ticker valido.';
}

$pageTitle = 'Analisar ativo - InvestAI';
require_once __DIR__ . '/includes/header.php';
?>
    <main class="page">
        <section class="page-heading">
            <p class="eyebrow">ANALISE DE ATIVO</p>
            <h1><?= $tickerValido ? e($ticker) : 'Escolha um ativo' ?></h1>
            <p class="subtitle">A estrutura esta pronta para a futura API de mercado. Nesta fase, exibimos apenas os dados cadastrados localmente.</p>
        </section>

        <?php if ($message): ?><div class="alert success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

        <section class="panel">
            <form class="search-box" method="get">
                <input type="text" name="ticker" value="<?= e($ticker) ?>" placeholder="Ex.: PETR4" maxlength="20" required>
                <button type="submit">Buscar</button>
            </form>
        </section>

        <?php if ($tickerValido && $ativo): ?>
            <section class="feature-grid compact">
                <article class="card"><strong><?= e($ativo['ticker']) ?></strong><h2>Ticker</h2><p>Codigo negociado do ativo.</p></article>
                <article class="card"><strong><?= e($ativo['tipo'] ?? '--') ?></strong><h2>Tipo</h2><p><?= e($ativo['nome'] ?? 'Nome ainda nao cadastrado.') ?></p></article>
                <article class="card"><strong><?= e($ativo['setor'] ?? '--') ?></strong><h2>Setor</h2><p>Classificacao cadastrada no banco local.</p></article>
            </section>

            <section class="panel action-panel">
                <?php if (isAuthenticated()): ?>
                    <form method="post">
                        <input type="hidden" name="ticker" value="<?= e($ticker) ?>">
                        <input type="hidden" name="acao" value="<?= $favoritado ? 'remover' : 'adicionar' ?>">
                        <button class="<?= $favoritado ? 'danger' : '' ?>" type="submit"><?= $favoritado ? 'Remover dos favoritos' : 'Adicionar aos favoritos' ?></button>
                    </form>
                <?php else: ?>
                    <p class="muted">Entre na sua conta para favoritar este ativo.</p>
                    <a class="button" href="login.php">Entrar</a>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
