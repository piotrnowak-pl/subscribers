
<?php require_once '_header.php'; ?>
<div class="container">
    <h1>Lista osób</h1>
    <?php require_once '_success.php';?>
    <?php require_once '_error.php';?>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Akcje</th>
            <th>Subskrypcja</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($people as $person): ?>
            <tr>
                <td><?= $person['id'] ?></td>
                <td><?= $person['imie'] ?></td>
                <td><?= $person['nazwisko'] ?></td>
                <td><?= $person['email'] ?></td>
                <td><?= $person['telefon'] ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $person['id'] ?>" class="btn btn-warning  btn-xs">Edytuj</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $person['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-danger btn-delete btn-xs">Usuń</button>
                    </form>
                </td>
                <td>
                    <div class="subscription" data-person_id="<?= $person['id'] ?>">
                        <label>
                            <input type="radio" name="type-<?= $person['id'] ?>" id="<?= $person['id'] ?>" value="" <?= !isset($subscriptions[$person['id']]) ? 'checked' : '' ?>> wyłączona
                        </label>
                        <?php foreach ($notificationTypes as $key => $type): ?>
                        <label>
                            <input type="radio" name="type-<?= $person['id'] ?>" value="<?= $key ?>" <?= isset($subscriptions[$person['id']]) && $subscriptions[$person['id']] === $key ? 'checked' : '' ?>> <?= $type ?>
                        </label>
                        <?php endforeach; ?>
                        <button type="button" name="subscribe" class="btn btn-primary btn-xs btn-save disabled" onclick="saveSubscription(this)">Zapisz</button>
                    </div>
              </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="mt-5"></div>
    <h2>Dodaj nową osobę</h2>
    <div class="form-group">
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <input type="text" name="imie" class="<?=isset($error['imie'])?'has-error':''?>" placeholder="Imię" required value="<?= $post['imie'] ?? '' ?>">
            <input type="text" name="nazwisko" class="<?=isset($error['nazwisko'])?'has-error':''?>" placeholder="Nazwisko" required value="<?= $post['nazwisko'] ?? '' ?>">
            <input type="email" name="email" class="<?=isset($error['email'])?'has-error':''?>" placeholder="Email" required value="<?= $post['email'] ?? '' ?>">
            <input type="text" name="telefon" class="<?=isset($error['telefon'])?'has-error':''?>" placeholder="Telefon" required value="<?= $post['telefon'] ?? '' ?>">
            <button type="submit" class="btn btn-success">Dodaj</button>
        </form>
    </div>

    <div class="mt-5"></div>
    <h2>Wyślij powiadomienie</h2>
    <form method="POST">
        <textarea name="message" class="form-control" placeholder="Wpisz wiadomość..."></textarea>
        <button type="submit" name="send_notification" class="btn btn-primary mt-2">Wyślij</button>
    </form>
</div>
<?php require_once '_footer.php'; ?>