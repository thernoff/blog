<?php
$aliasGallery = $gallery->alias;
?>
<h2><?= $this->title; ?></h2>
<form class="admin" action="" method="post">    
    <?php foreach ($images as $image): ?>
        <div class="border clearfix">
            <div class = "image-preview">
                <img src="assets/upload/gallery/thumb/<?= $aliasGallery . "/" . $image->name; ?>"/>
            </div>
            <div>
                <input type="checkbox" value="<?= $image->id; ?>" name="delete_photo[]">
                <p><?= "Заголовок: " . $image->title; ?></p>
                <p><?= "Имя файла: " . $image->name; ?></p>
                <input type="hidden" name="image_id[]" value="<?= $image->id; ?>">
            </div>
        </div>
    <?php endforeach; ?>

    <input type="hidden" name="id" value="<?php echo $this->gallery->id; ?>">
    <input type="submit" name="btnSubmit" value="Удалить выбранные">
</form>