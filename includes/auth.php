<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAuthenticated(): bool
{
    return isset($_SESSION['usuario_id'], $_SESSION['usuario_nome']);
}

function requireAuth(): void
{
    if (!isAuthenticated()) {
        header('Location: login.php');
        exit;
    }
}

function currentUserId(): ?int
{
    return isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
