<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px;">
    <div>
        <h1 class="page-title">Staff Members</h1>
        <p class="page-subtitle">Manage authorized POS users.</p>
    </div>

    <a href="<?= site_url('users/create') ?>" class="btn btn-primary">
        + Add Staff
    </a>
</div>

<div class="card">
    <?php if (empty($users)): ?>
        <div class="empty-state">
            No staff members have been added yet.
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php if ($user['avatar']): ?>
                                    <img
                                        src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>"
                                        alt="<?= esc($user['full_name']) ?>"
                                        class="avatar-image"
                                    >
                                <?php else: ?>
                                    <span class="badge">No avatar</span>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($user['username']) ?></td>
                            <td><?= esc($user['full_name']) ?></td>

                            <td>
                                <a
                                    href="<?= site_url('users/edit/' . $user['id']) ?>"
                                    class="btn btn-small"
                                >
                                    Edit
                                </a>

                                <a
                                    href="<?= site_url('users/delete/' . $user['id']) ?>"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Delete this staff member?');"
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