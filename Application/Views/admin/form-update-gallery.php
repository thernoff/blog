<?php
$aliasGallery = $gallery->alias;
?>
<h2><?= $this->title; ?></h2>
<form class="admin" action="" method="post">
    <div><label for="title">Название фотоальбома: </label><input type="text" id="title" name="name" value="<?= $this->gallery->name; ?>"></div>
    <div><label for="alias">Алиас: </label><input type="text" name="alias" id="alias" value="<?= $this->gallery->alias; ?>" /></div>
    <div><label for="alias">Описание: </label><input type="text" name="description" id="description" value="<?= $this->gallery->description; ?>" /></div>
    <div>
        <label for="is_active">Активна: </label><input type="checkbox" name="is_active" value="1" <?php if ($this->gallery->is_active) {
    echo 'checked="checked"';
} ?> /><br>

    </div>
<?php foreach ($images as $image): ?>
        <div class="border clearfix">
            <div class = "image-preview">
                <img src="assets/upload/gallery/thumb/<?= $aliasGallery . "/" . $image->name; ?>"/>
            </div>
            <div>
                <div><label for="image_title[]">Укажите заголовок: </label><input type="text" name="image_title[]" value="<?= $image->title; ?>"/></div>
                <div><label for="image_alt[]">Укажите alt: </label><input type="text" name="image_alt[]" value="<?= $image->alt; ?>"/></div>
                <input type="hidden" name="image_id[]" value="<?= $image->id; ?>">
                <input type="hidden" name="image_name[]" value="<?= $image->name; ?>">
            </div>
        </div>
<?php endforeach; ?>

    <input type="hidden" name="id" value="<?php echo $this->gallery->id; ?>">
    <input type="submit" name="submitCreate" value="Сохранить">
</form>