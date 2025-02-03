<?php 

$error = $_SESSION['error'] ?? null;
$post = $_SESSION['post'] ?? [];

if (isset($error)): ?>
    <div class="alert alert-danger">
        <?php if(is_array($error)): ?>
            <?php foreach($error as $e): ?>
            <?= $e ?><br>
            <?php endforeach; ?>
        <?php else: ?>
            <?= $error ?>
        <?php endif; ?>
    </div>
<?php endif; ?>