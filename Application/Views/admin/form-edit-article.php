<h2><?= $this->title; ?></h2>
<form class="admin" action="" method="post">
    <label for="title">Название статьи: </label><input type="text" name="title" value="<?php echo htmlspecialchars($article->title); ?>"><br>
    <textarea name="content" id="editor1" rows="5" cols="80">
        <?php echo $article->content; ?>
    </textarea>
    <script>
        thisConfig = CKEDITOR.config;
        // thisConfig.autoParagraph = true;
        // thisConfig.fillEmptyBlocks= true;
        // thisConfig.dialog_noConfirmCancel = true;
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: '/web/assets/elfinder/elfinder.html', // eg. 'includes/elFinder/elfinder.html'
            toolbar: 'Basic',
            //uiColor : '#9AB8F3'
        });
    </script>
    <br>
    <h3>Укажите теги</h3>
    <p>
        <?php foreach ($allTags as $tag): ?>
            <input type="checkbox" name = tags[] value="<?= $tag->id ?>" <?php if (in_array($tag, $checkedTags)) {
            echo "checked";
        } ?> ><?= $tag->name ?>
<?php endforeach; ?>
    </p>
    <br>
    <input type="submit" name="submitUpdate" value="Сохранить">
    <input type="hidden" name="id" value="<?php echo $article->id; ?>">
</form>