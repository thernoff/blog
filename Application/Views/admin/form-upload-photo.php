<h2><?= $this->title; ?></h2>
<form class="admin" enctype="multipart/form-data" method="post">
    <div>
        <input type="button" id="btnAdd" value="Добавить фотографию"/>
    </div>
    <div class = "base" style="display: none">
        <label for="upload">Выберите изображение для загрузки</label>
        <input type="file" id="uploadfile" name="uploadfile[]"/>
        <input type="button" class="btn-remove" value="X"/>
    </div>
    <div class="upload border">
        <label for="upload">Выберите изображение для загрузки</label>
        <input type="file" id="uploadfile" name="uploadfile[]"/>
    </div>
    <input type="hidden" name="id_gallery" value="<?php echo $this->gallery->id; ?>">
    <div>
        <input type="submit" name ="btnSubmit" value="Отправить">
    </div>
</form>