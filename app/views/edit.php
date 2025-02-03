
<?php require_once '_header.php'; ?>
<div class="container">
    <?php if (isset($person)): ?>
    <h1>Edytuj osobę</h1>
    <?php require_once '_error.php';?>
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= $person['id'] ?>">
        <div class="form-group mt-2">
            <label for="imie" class="form-label">Imię</label>
            <input type="text" name="imie" value="<?= $person['imie'] ?>" placeholder="Imię" required class="form-control <?=isset($error['imie'])?'is-invalid':''?>">
        </div>
        <div class="form-group mt-2">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" name="nazwisko" value="<?= $person['nazwisko'] ?>" placeholder="Nazwisko" required class="form-control <?=isset($error['nazwisko'])?'is-invalid':''?>">
        </div>
        <div class="form-group mt-2">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?= $person['email'] ?>" placeholder="Email" required class="form-control <?=isset($error['email'])?'is-invalid':''?>">
        </div>
        <div class="form-group mt-2">
            <label for="telefon">Telefon</label>
            <input type="text" name="telefon" value="<?= $person['telefon'] ?>" placeholder="Telefon" required class="form-control <?=isset($error['telefon'])?'is-invalid':''?>">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Zapisz zmiany</button>
    </form>
    <?php endif; ?>
</div>
<?php require_once '_footer.php'; ?>