<?php

require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'InvestAI';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <a class="brand" href="index.php">Invest<span>AI</span></a>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">Menu</button>
        <nav class="nav-links">
            <a href="index.php">Inicio</a>
            <a href="ativo.php">Analisar ativo</a>
            <?php if (isAuthenticated()): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a class="nav-cta" href="cadastro.php">Criar conta</a>
            <?php endif; ?>
        </nav>
    </header>
