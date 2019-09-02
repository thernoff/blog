<h2><?= $this->title; ?></h2>
<form class="admin" action="" method="post">
    <div><label for="title">Название фотоальбома: </label><input type="text" id="title" name="name" value="<?= $this->gallery->name; ?>"></div>
    <div><label for="alias">Алиас: </label><input type="text" name="alias" id="alias" value="<?= $this->gallery->alias; ?>" /></div>
    <div><label for="alias">Описание: </label><input type="text" name="description" id="description" value="<?= $this->gallery->description; ?>" /></div>
    <div>
        <label for="is_active">Активна: </label><input type="checkbox" name="is_active" value="1" checked/><br>
    </div>
    <input type="submit" name="submitCreate" value="Сохранить">
</form>