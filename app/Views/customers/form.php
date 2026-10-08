<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="page-title">
    <?= $isEdit ? 'Edit Customer' : 'Add Customer' ?>
</h1>

<p class="page-subtitle">
    <?= $isEdit ? 'Update customer information.' : 'Add a new customer account.' ?>
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
            ? site_url('customers/update/' . $customer['id'])
            : site_url('customers/store') ?>"
        method="post"
    >
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    class="form-control"
                    value="<?= old('full_name', $customer['full_name'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="<?= old('email', $customer['email'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="<?= old('phone', $customer['phone'] ?? '') ?>"
                >
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? 'Update Customer' : 'Save Customer' ?>
            </button>

            <a href="<?= site_url('customers') ?>" class="btn">
                Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>