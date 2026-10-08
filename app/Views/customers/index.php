<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px;">
    <div>
        <h1 class="page-title">Customers</h1>
        <p class="page-subtitle">Manage your customer accounts.</p>
    </div>

    <a href="<?= site_url('customers/create') ?>" class="btn btn-primary">
        + Add Customer
    </a>
</div>

<div class="card">
    <?php if (empty($customers)): ?>
        <div class="empty-state">
            No customers have been added yet.
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= esc($customer['id']) ?></td>
                            <td><?= esc($customer['full_name']) ?></td>
                            <td><?= esc($customer['email']) ?></td>
                            <td><?= esc($customer['phone'] ?? '—') ?></td>

                            <td>
                                <a
                                    href="<?= site_url('customers/edit/' . $customer['id']) ?>"
                                    class="btn btn-small"
                                >
                                    Edit
                                </a>

                                <a
                                    href="<?= site_url('customers/delete/' . $customer['id']) ?>"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Delete this customer?');"
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