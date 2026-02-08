<?php
require __DIR__ . '/../app/core/bootstrap.php';

Auth::requireRole(['admin']);

$db = Database::connection();
$users = $db->query('SELECT id, name, email, role FROM users')->fetchAll();
$clients = $db->query('SELECT id, company_name, contact_name, email FROM clients')->fetchAll();
$projects = $db->query('SELECT id, name, status, progress_percent FROM projects')->fetchAll();
$logs = $db->query('SELECT action, created_at FROM logs ORDER BY created_at DESC LIMIT 5')->fetchAll();

include __DIR__ . '/../app/views/partials/header.php';
?>
<h2 class="mb-4"><?= e(lang('admin_panel')) ?></h2>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <h6>Total Users</h6>
                <h3><?= count($users) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <h6>Total Clients</h6>
                <h3><?= count($clients) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
                <h6>Total Projects</h6>
                <h3><?= count($projects) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-dark shadow-sm">
            <div class="card-body">
                <h6>Financial Reports</h6>
                <p class="mb-0">PDF / Excel ready</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= (int) $user['id'] ?></td>
                                <td><?= e($user['name']) ?></td>
                                <td><?= e($user['email']) ?></td>
                                <td><?= e($user['role']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Clients</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client) : ?>
                            <tr>
                                <td><?= (int) $client['id'] ?></td>
                                <td><?= e($client['company_name']) ?></td>
                                <td><?= e($client['contact_name']) ?></td>
                                <td><?= e($client['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5 class="card-title">Recent Activity</h5>
        <ul class="list-group list-group-flush">
            <?php foreach ($logs as $log) : ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= e($log['action']) ?></span>
                    <small class="text-muted"><?= e($log['created_at']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php include __DIR__ . '/../app/views/partials/footer.php'; ?>
