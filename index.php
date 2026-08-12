<?php

$pageTitle = 'InvestAI';
require_once __DIR__ . '/includes/header.php';
?>
    <main class="hero">
        <section class="hero-content">
            <p class="eyebrow">PLATAFORMA DE ANALISE</p>
            <h1>Entenda seus investimentos com mais clareza.</h1>
            <p class="subtitle">Consulte ativos, acompanhe favoritos e prepare sua rotina para futuras analises com dados de mercado e IA.</p>
            <form class="search-box" action="ativo.php" method="get">
                <input type="text" name="ticker" placeholder="Digite um ativo, ex.: PETR4" maxlength="20" required>
                <button type="submit">Analisar</button>
            </form>
        </section>

        <section class="feature-grid">
            <article class="card"><strong>01</strong><h2>Indicadores</h2><p>Estrutura pronta para receber indicadores financeiros na proxima fase.</p></article>
            <article class="card"><strong>02</strong><h2>Favoritos</h2><p>Crie sua conta e acompanhe os ativos que voce quer analisar de perto.</p></article>
            <article class="card"><strong>03</strong><h2>IA</h2><p>A integracao inteligente sera adicionada depois, sem dados ficticios agora.</p></article>
        </section>
    </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
