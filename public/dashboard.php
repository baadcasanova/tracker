<?php
require __DIR__ . '/../app/core/bootstrap.php';
require __DIR__ . '/../app/models/Project.php';

Auth::requireRole(['client', 'staff', 'admin']);
$user = Auth::user();

$projects = [];
if ($user['role'] === 'client' && !empty($user['client_id'])) {
    $projects = Project::forClient((int) $user['client_id']);
} else {
    $stmt = Database::connection()->query('SELECT * FROM projects');
    $projects = $stmt->fetchAll();
}

include __DIR__ . '/../app/views/partials/header.php';
?>
<h2 class="mb-4"><?= e(lang('client_dashboard')) ?></h2>
<div class="row g-4">
    <?php foreach ($projects as $project) : ?>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= e($project['name']) ?></h5>
                    <p class="mb-2"><strong><?= e(lang('status')) ?>:</strong> <?= e($project['status']) ?></p>
                    <div class="progress mb-3" role="progressbar" aria-label="Progress">
                        <div class="progress-bar" style="width: <?= (int) $project['progress_percent'] ?>%">
                            <?= (int) $project['progress_percent'] ?>%
                        </div>
                    </div>
                    <a class="btn btn-outline-primary" href="/project.php?id=<?= (int) $project['id'] ?>">
                        <?= e(lang('project_view')) ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include __DIR__ . '/../app/views/partials/footer.php'; ?>
