<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="page-title">
    <?= $isEdit ? 'Edit Staff Member' : 'Add Staff Member' ?>
</h1>

<p class="page-subtitle">
    <?= $isEdit
        ? 'Update the staff member information.'
        : 'Create an authorized account for the POS system.' ?>
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
    <form
        action="<?= $isEdit
            ? site_url('users/update/' . $user['id'])
            : site_url('users/store') ?>"
        method="post"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    value="<?= old('username', $user['username'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    class="form-control"
                    value="<?= old('full_name', $user['full_name'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Password <?= $isEdit ? '(leave blank to keep current password)' : '' ?>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    <?= $isEdit ? '' : 'required' ?>
                >
            </div>

            <div class="form-group">
                <label for="avatar">Avatar (optional)</label>
                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    class="form-control"
                    accept="image/png,image/jpeg,image/webp"
                >
                <small>JPG, PNG, or WEBP. Maximum 2 MB.</small>
            </div>
        </div>

        <?php if ($isEdit && !empty($user['avatar'])): ?>
            <p>
                Current avatar:
                <br>
                <img
                    src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>"
                    alt="Current avatar"
                    class="avatar-image"
                >
            </p>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? 'Update Staff' : 'Save Staff' ?>
            </button>

            <a href="<?= site_url('users') ?>" class="btn">
                Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>