<?php
require __DIR__ . '/../app/core/bootstrap.php';
require __DIR__ . '/../app/models/User.php';

$error = null;
$twofaMode = isset($_SESSION['twofa_pending']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token.';
    } elseif ($twofaMode) {
        $code = trim($_POST['twofa_code'] ?? '');
        if ($code === ($_SESSION['twofa_code'] ?? '')) {
            Auth::login($_SESSION['twofa_pending']);
            unset($_SESSION['twofa_pending'], $_SESSION['twofa_code']);
            redirect('/');
        } else {
            $error = 'Invalid 2FA code.';
        }
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['role'] === 'admin' && (int) $user['twofa_enabled'] === 1) {
                $_SESSION['twofa_pending'] = $user;
                $_SESSION['twofa_code'] = (string) random_int(100000, 999999);
                $twofaMode = true;
            } else {
                Auth::login($user);
                redirect('/');
            }
        } else {
            $error = 'Invalid credentials.';
        }
    }
}

include __DIR__ . '/../app/views/partials/header.php';
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4"><?= e(lang('login')) ?></h3>
                <?php if ($error) : ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>

                <?php if ($twofaMode) : ?>
                    <div class="alert alert-info">
                        Demo 2FA code: <strong><?= e($_SESSION['twofa_code'] ?? '') ?></strong>
                    </div>
                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>">
                        <div class="mb-3">
                            <label class="form-label"><?= e(lang('two_factor')) ?></label>
                            <input type="text" name="twofa_code" class="form-control" required>
                        </div>
                        <button class="btn btn-primary w-100" type="submit"><?= e(lang('submit')) ?></button>
                    </form>
                <?php else : ?>
                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>">
                        <div class="mb-3">
                            <label class="form-label"><?= e(lang('email')) ?></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= e(lang('password')) ?></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-primary w-100" type="submit"><?= e(lang('login')) ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../app/views/partials/footer.php'; ?>
