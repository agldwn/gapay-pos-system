<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px;">
    <div>
        <h1 class="page-title">Products</h1>
        <p class="page-subtitle">Manage your products and inventory.</p>
    </div>

    <a href="<?= site_url('products/create') ?>" class="btn btn-primary">
        + Add Product
    </a>
</div>

<div class="card">
    <?php if (empty($products)): ?>
        <div class="empty-state">
            No products have been added yet.
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if ($product['image']): ?>
                                    <img
                                        src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                        alt="<?= esc($product['name']) ?>"
                                        class="product-image"
                                    >
                                <?php else: ?>
                                    <span class="badge">No image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($product['name']) ?></td>
                            <td>₱<?= number_format($product['price'], 2) ?></td>
                            <td><?= esc($product['stock_quantity']) ?></td>

                            <td>
                                <a
                                    href="<?= site_url('products/edit/' . $product['id']) ?>"
                                    class="btn btn-small"
                                >
                                    Edit
                                </a>

                                <a
                                    href="<?= site_url('products/delete/' . $product['id']) ?>"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Delete this product?');"
                                >
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>