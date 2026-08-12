<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = (string) ($_POST['senha'] ?? '');
    $confirmarSenha = (string) ($_POST['confirmar_senha'] ?? '');

    if (strlen($nome) < 2 || strlen($nome) > 100) {
        $errors[] = 'Informe um nome entre 2 e 100 caracteres.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $errors[] = 'Informe um e-mail valido.';
    }

    if (strlen($senha) < 6) {
        $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
    }

    if ($senha !== $confirmarSenha) {
        $errors[] = 'A confirmacao da senha nao confere.';
    }

    if (!$errors) {
        $pdo = getDatabase();
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $errors[] = 'Este e-mail ja esta cadastrado.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)');
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'senha' => password_hash($senha, PASSWORD_DEFAULT),
            ]);

            header('Location: login.php?cadastro=sucesso');
            exit;
        }
    }
}

$pageTitle = 'Cadastro - InvestAI';
require_once __DIR__ . '/includes/header.php';
?>
    <main class="auth-page">
        <section class="auth-card">
            <p class="eyebrow">NOVA CONTA</p>
            <h1>Cadastro</h1>
            <?php if ($errors): ?>
                <div class="alert error"><?= e(implode(' ', $errors)) ?></div>
            <?php endif; ?>
            <form class="form-stack" method="post">
                <label>Nome<input type="text" name="nome" value="<?= e($nome) ?>" maxlength="100" required></label>
                <label>E-mail<input type="email" name="email" value="<?= e($email) ?>" maxlength="150" required></label>
                <label>Senha<input type="password" name="senha" minlength="6" required></label>
                <label>Confirmar senha<input type="password" name="confirmar_senha" minlength="6" required></label>
                <button type="submit">Criar conta</button>
            </form>
            <p class="muted">Ja tem conta? <a href="login.php">Entrar</a></p>
        </section>
    </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
