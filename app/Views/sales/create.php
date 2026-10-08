<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="page-title">Record Sale</h1>
<p class="page-subtitle">
    Record a customer purchase and automatically update inventory.
</p>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert error">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <div><?= esc($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="card">
    <?php if (empty($products)): ?>
        <div class="empty-state">
            There are no products with available stock.
        </div>
    <?php else: ?>
        <form action="<?= site_url('sales/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select
                        id="product_id"
                        name="product_id"
                        class="form-control"
                        required
                    >
                        <option value="">Select a product</option>

                        <?php foreach ($products as $product): ?>
                            <option
                                value="<?= $product['id'] ?>"
                                <?= old('product_id') == $product['id'] ? 'selected' : '' ?>
                            >
                                <?= esc($product['name']) ?>
                                — ₱<?= number_format($product['price'], 2) ?>
                                — Stock: <?= $product['stock_quantity'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_id">Customer (optional)</label>
                    <select
                        id="customer_id"
                        name="customer_id"
                        class="form-control"
                    >
                        <option value="">Walk-in Customer</option>

                        <?php foreach ($customers as $customer): ?>
                            <option
                                value="<?= $customer['id'] ?>"
                                <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>
                            >
                                <?= esc($customer['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="form-control"
                        min="1"
                        value="<?= old('quantity', 1) ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    Record Sale
                </button>

                <a href="<?= site_url('sales') ?>" class="btn">
                    Cancel
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>