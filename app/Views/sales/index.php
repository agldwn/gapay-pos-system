<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px;">
    <div>
        <h1 class="page-title">Sales History</h1>
        <p class="page-subtitle">Review recorded transactions.</p>
    </div>

    <a href="<?= site_url('sales/create') ?>" class="btn btn-success">
        + Record Sale
    </a>
</div>

<div class="card">
    <?php if (empty($sales)): ?>
        <div class="empty-state">
            No sales have been recorded yet.
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Staff</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= esc($sale['id']) ?></td>
                            <td><?= esc($sale['product_name']) ?></td>
                            <td><?= esc($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
                            <td><?= esc($sale['staff_name']) ?></td>
                            <td><?= esc($sale['quantity']) ?></td>
                            <td>₱<?= number_format($sale['total_price'], 2) ?></td>
                            <td><?= esc($sale['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>