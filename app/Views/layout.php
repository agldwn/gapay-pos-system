<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pastel POS') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<header class="topbar">
    <div class="brand">
        <span class="brand-icon">🛍️</span>
        <span>GAPAY POS</span>
    </div>

    <nav class="main-nav">
        <?php if (session()->get('isLoggedIn')): ?>
            <a href="<?= site_url('dashboard') ?>">Dashboard</a>
            <a href="<?= site_url('products') ?>">Products</a>
            <a href="<?= site_url('customers') ?>">Customers</a>
            <a href="<?= site_url('users') ?>">Staff</a>
            <a href="<?= site_url('sales/create') ?>">Record Sale</a>
            <a href="<?= site_url('sales') ?>">Sales History</a>
            <a class="nav-logout" href="<?= site_url('logout') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= site_url('login') ?>">Login</a>
        <?php endif; ?>
    </nav>
</header>

<main class="page-container">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>

</main>

<footer class="footer">
    GAPAY 🛍️ TC36
</footer>

</body>
</html>