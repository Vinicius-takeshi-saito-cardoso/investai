<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = (string) ($_POST['senha'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail valido.';
    }

    if ($senha === '') {
        $errors[] = 'Informe sua senha.';
    }

    if (!$errors) {
        $pdo = getDatabase();
        $stmt = $pdo->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = (int) $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: dashboard.php');
            exit;
        }

        $errors[] = 'E-mail ou senha incorretos.';
    }
}

$pageTitle = 'Entrar - InvestAI';
require_once __DIR__ . '/includes/header.php';
?>
    <main class="auth-page">
        <section class="auth-card">
            <p class="eyebrow">CONTA</p>
            <h1>Entrar</h1>
            <?php if ($errors): ?>
                <div class="alert error"><?= e(implode(' ', $errors)) ?></div>
            <?php endif; ?>
            <form class="form-stack" method="post">
                <label>E-mail<input type="email" name="email" value="<?= e($email) ?>" required></label>
                <label>Senha<input type="password" name="senha" required></label>
                <button type="submit">Entrar</button>
            </form>
            <p class="muted">Ainda nao tem conta? <a href="cadastro.php">Cadastre-se</a></p>
        </section>
    </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
