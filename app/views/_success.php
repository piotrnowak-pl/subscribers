<?php 

$success = $_SESSION['success'] ?? null;

if (isset($success)): ?>
    <div class="alert alert-success">
        <?php if(is_array($success)): ?>
            <?php foreach($success as $e): ?>
            <?= $e ?><br>
            <?php endforeach; ?>
        <?php else: ?>
            <?= $success ?>
        <?php endif; ?>
    </div>
<?php endif; ?>