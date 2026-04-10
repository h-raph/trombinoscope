<?php if (isset($_SESSION['flash'])): ?>
    <div class="flash-zone">
        <div class="flash flash-success">
            <?= $_SESSION['flash'] ?>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="flash-zone">
        <div class="flash flash-error">
            <?= $_SESSION['flash_error'] ?>
        </div>
    </div>
<?php endif; ?>

<?php unset($_SESSION['flash_error']) ?>
<?php unset($_SESSION['flash']) ?>