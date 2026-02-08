<?php
require __DIR__ . '/../app/core/bootstrap.php';
require __DIR__ . '/../app/models/Project.php';

$token = trim($_GET['token'] ?? '');
$project = Project::findByToken($token);
if (!$project) {
    redirect('/login.php');
}

$phases = Project::phases((int) $project['id']);

include __DIR__ . '/../app/views/partials/header.php';
?>
<h2 class="mb-2"><?= e($project['name']) ?></h2>
<p class="text-muted"><?= e(lang('project_view')) ?></p>
<div class="progress mb-4">
    <div class="progress-bar" style="width: <?= (int) $project['progress_percent'] ?>%">
        <?= (int) $project['progress_percent'] ?>%
    </div>
</div>

<?php foreach ($phases as $phase) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= e($phase['title']) ?></h5>
            <ul class="list-group list-group-flush">
                <?php $tasks = Project::tasks((int) $phase['id']); ?>
                <?php foreach ($tasks as $task) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold"><?= e($task['title']) ?></div>
                            <small class="text-muted">Due: <?= e($task['due_date']) ?></small>
                        </div>
                        <span class="badge bg-info text-dark"><?= e($task['status']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/../app/views/partials/footer.php'; ?>
