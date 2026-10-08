<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="page-title">
    <?= $isEdit ? 'Edit Product' : 'Add Product' ?>
</h1>

<p class="page-subtitle">
    <?= $isEdit ? 'Update the product information.' : 'Add a new product to your inventory.' ?>
</p>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert error">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <div><?= esc($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card">
    <form
        action="<?= $isEdit
            ? site_url('products/update/' . $product['id'])
            : site_url('products/store') ?>"
        method="post"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="<?= old('name', $product['name'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    class="form-control"
                    step="0.01"
                    min="0"
                    value="<?= old('price', $product['price'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input
                    type="number"
                    id="stock_quantity"
                    name="stock_quantity"
                    class="form-control"
                    min="0"
                    value="<?= old('stock_quantity', $product['stock_quantity'] ?? 0) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="image">
                    Product Image
                    <?= $isEdit ? '(optional)' : '' ?>
                </label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-control"
                    accept="image/png,image/jpeg,image/webp"
                    <?= $isEdit ? '' : 'required' ?>
                >
                <small>JPG, PNG, or WEBP. Maximum 2 MB.</small>
            </div>
        </div>

        <?php if ($isEdit && !empty($product['image'])): ?>
            <p>
                Current image:
                <br>
                <img
                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                    alt="Current product image"
                    class="product-image"
                >
            </p>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? 'Update Product' : 'Save Product' ?>
            </button>

            <a href="<?= site_url('products') ?>" class="btn">
                Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>