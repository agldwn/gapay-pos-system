<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="page-title">Dashboard</h1>
<p class="page-subtitle">
    Welcome back, <?= esc(session()->get('full_name')) ?>.
</p>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Products</h3>
        <p><?= esc($productCount) ?></p>
    </div>

    <div class="stat-card">
        <h3>Customers</h3>
        <p><?= esc($customerCount) ?></p>
    </div>

    <div class="stat-card">
        <h3>Staff Members</h3>
        <p><?= esc($userCount) ?></p>
    </div>

    <div class="stat-card">
        <h3>Sales</h3>
        <p><?= esc($saleCount) ?></p>
    </div>
</div>

<div class="card">
    <h2>Quick Actions</h2>

    <a href="<?= site_url('products/create') ?>" class="btn btn-primary">
        Add Product
    </a>

    <a href="<?= site_url('customers/create') ?>" class="btn">
        Add Customer
    </a>

    <a href="<?= site_url('sales/create') ?>" class="btn btn-success">
        Record Sale
    </a>
</div>

<?= $this->endSection() ?>