<?php
$pageTitle = 'InvestAI';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <a class="brand" href="index.php">Invest<span>AI</span></a>
        <nav>
            <a href="index.php">Início</a>
            <a href="ativo.php">Analisar ativo</a>
            <a href="login.php">Entrar</a>
        </nav>
    </header>

    <main class="hero">
        <section class="hero-content">
            <p class="eyebrow">PLATAFORMA DE ANÁLISE</p>
            <h1>Entenda seus investimentos com mais clareza.</h1>
            <p class="subtitle">Consulte ativos, acompanhe indicadores e, em uma próxima etapa, use IA para transformar dados financeiros em análises mais fáceis de entender.</p>
            <form class="search-box" action="ativo.php" method="get">
                <input type="text" name="ticker" placeholder="Digite um ativo, ex.: PETR4" maxlength="20" required>
                <button type="submit">Analisar</button>
            </form>
        </section>

        <section class="feature-grid">
            <article class="card"><strong>📈</strong><h2>Indicadores</h2><p>Visualize os principais indicadores financeiros do ativo.</p></article>
            <article class="card"><strong>💰</strong><h2>Dividendos</h2><p>Acompanhe informações relacionadas à distribuição de proventos.</p></article>
            <article class="card"><strong>🤖</strong><h2>IA</h2><p>Em breve, análises automatizadas e explicações dos dados.</p></article>
        </section>
    </main>

    <footer>InvestAI · Projeto de estudo e portfólio</footer>
</body>
</html>
