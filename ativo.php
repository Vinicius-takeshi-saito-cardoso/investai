<?php
$ticker = strtoupper(trim($_GET['ticker'] ?? ''));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisar ativo · InvestAI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <a class="brand" href="index.php">Invest<span>AI</span></a>
        <nav><a href="index.php">Início</a><a href="ativo.php">Analisar ativo</a><a href="login.php">Entrar</a></nav>
    </header>

    <main class="hero">
        <p class="eyebrow">ANÁLISE DE ATIVO</p>
        <h1><?= $ticker ? htmlspecialchars($ticker) : 'Escolha um ativo' ?></h1>
        <?php if (!$ticker): ?>
            <p class="subtitle">Digite o código de uma ação ou FII para começar. A integração com dados de mercado será adicionada na próxima etapa.</p>
            <form class="search-box" method="get">
                <input type="text" name="ticker" placeholder="Ex.: PETR4" maxlength="20" required>
                <button type="submit">Buscar</button>
            </form>
        <?php else: ?>
            <p class="subtitle">A página do ativo está pronta. Agora vamos conectar uma API de mercado para preencher cotação, histórico, indicadores e dividendos.</p>
            <section class="feature-grid">
                <article class="card"><strong>R$ --</strong><h2>Cotação</h2><p>Aguardando integração com dados de mercado.</p></article>
                <article class="card"><strong>--</strong><h2>Variação</h2><p>Os dados serão carregados pela API.</p></article>
                <article class="card"><strong>--</strong><h2>Dividend Yield</h2><p>Indicador fundamentalista em breve.</p></article>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
