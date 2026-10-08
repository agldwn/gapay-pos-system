<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="login-wrapper">
    <div class="card login-card">
        <h1 class="page-title">Staff Login</h1>
        <p class="page-subtitle">Sign in to manage the Pastel POS system.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    value="<?= old('username') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>