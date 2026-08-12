<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

requireAuth();

$pdo = getDatabase();
$usuarioId = currentUserId();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $ticker = strtoupper(trim($_POST['ticker'] ?? ''));

    if (!preg_match('/^[A-Z0-9]{3,20}$/', $ticker)) {
        $error = 'Informe um ticker valido.';
    } elseif ($acao === 'adicionar') {
        $stmt = $pdo->prepare('INSERT IGNORE INTO favoritos (usuario_id, ticker) VALUES (:usuario_id, :ticker)');
        $stmt->execute(['usuario_id' => $usuarioId, 'ticker' => $ticker]);
        $message = $stmt->rowCount() ? 'Ativo adicionado aos favoritos.' : 'Este ativo ja esta nos seus favoritos.';
    } elseif ($acao === 'remover') {
        $stmt = $pdo->prepare('DELETE FROM favoritos WHERE usuario_id = :usuario_id AND ticker = :ticker');
        $stmt->execute(['usuario_id' => $usuarioId, 'ticker' => $ticker]);
        $message = 'Favorito removido.';
    }
}

$stmt = $pdo->prepare(
    'SELECT f.ticker, a.nome, a.tipo, a.setor
     FROM favoritos f
     LEFT JOIN ativos a ON a.ticker = f.ticker
     WHERE f.usuario_id = :usuario_id
     ORDER BY f.criado_em DESC'
);
$stmt->execute(['usuario_id' => $usuarioId]);
$favoritos = $stmt->fetchAll();

$pageTitle = 'Dashboard - InvestAI';
require_once __DIR__ . '/includes/header.php';
?>
    <main class="page">
        <section class="page-heading">
            <p class="eyebrow">DASHBOARD</p>
            <h1>Ola, <?= e($_SESSION['usuario_nome']) ?></h1>
            <p class="subtitle">Pesquise ativos, salve favoritos e acompanhe sua lista de analise.</p>
        </section>

        <?php if ($message): ?><div class="alert success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

        <section class="panel">
            <form class="search-box" action="ativo.php" method="get">
                <input type="text" name="ticker" placeholder="Digite um ativo, ex.: PETR4" maxlength="20" required>
                <button type="submit">Analisar</button>
            </form>
        </section>

        <section class="panel">
            <div class="panel-title">
                <h2>Favoritos</h2>
                <a class="button secondary" href="logout.php">Logout</a>
            </div>
            <?php if (!$favoritos): ?>
                <p class="muted">Voce ainda nao adicionou favoritos.</p>
            <?php else: ?>
                <div class="asset-list">
                    <?php foreach ($favoritos as $favorito): ?>
                        <article class="asset-row">
                            <div>
                                <strong><?= e($favorito['ticker']) ?></strong>
                                <span><?= e($favorito['nome'] ?? 'Ativo sem cadastro detalhado') ?></span>
                            </div>
                            <div class="row-actions">
                                <a class="button secondary" href="ativo.php?ticker=<?= e($favorito['ticker']) ?>">Analisar</a>
                                <form method="post">
                                    <input type="hidden" name="acao" value="remover">
                                    <input type="hidden" name="ticker" value="<?= e($favorito['ticker']) ?>">
                                    <button class="danger" type="submit">Remover</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
