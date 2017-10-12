<?php 
    function print_tree($map, $id_parent, $shift = 0)
    {
        if(!empty($map))
        {
            foreach($map as $section)
            { ?>
                <option value="<?=$section['id']?>"  <?php if ($section['id'] == $id_parent){echo "selected";}?>>
                    <?php for($i = 0; $i < $shift; $i++)echo '&nbsp;';?>
                    <?=$section['name']?>
                </option>
                <?php print_tree($section['children'], $id_parent, $shift + 2); 
            }
        }
    }
?>

<?php if(count($this->errors)>0): ?>
<div class="error">
    <?php foreach ($this->errors as $error): ?>
        <p><?=$error;?></p>
    <?php endforeach; ?>    
</div>
<?php endif; ?>
<h2><?=$this->title;?></h2>
<form class="admin" method="POST" enctype="multipart/form-data">    
    <div><label for="title">Заголовок страницы: </label><input type="text" id="title" name="title" value="<?= htmlspecialchars($this->page->title); ?>" /></div>
    <div><label for="alias">Алиас: </label><input type="text" name="alias" id="alias" value="<?=$this->page->alias; ?>" /></div>
    <div><label for="parent">Категория</label><select name="id_parent">
						<option value="0">Без раздела</option>
						<?= print_tree($this->map, $this->page->id_parent); ?>
					</select>
    </div>
    
    <div><label for="keywords">Ключевые слова: </label><input type="text" name="keywords" value="<?=$this->page->keywords; ?>" /></div>
    <div><label for="description">Описание: </label><input type="text" name="description" value="<?=$this->page->description; ?>" /></div>
    <div><label for="upload">Выберите изображение: </label><input type="file" id="uploadfile" name="uploadfile"/></div>
    <div><?php if($page->main_image): ?>
        <p>Текущее изображение:<br/> <img width = "200px" src="/assets/upload/page/thumb/<?=$page->main_image;?>"></p>
    <?php endif; ?></div>
    <div><label for="short_description">Вступительный текст:<br/> </label><textarea name="short_description" rows="5" cols="80"/><?=$this->page->short_description; ?></textarea></div>
    <textarea name="content" id="ckeditor1" rows="5" cols="80">
        <?=$this->page->content; ?>
    </textarea>
    <script>
        thisConfig = CKEDITOR.config;
        // thisConfig.autoParagraph = true;
        // thisConfig.fillEmptyBlocks= true;
        // thisConfig.dialog_noConfirmCancel = true;
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'ckeditor1', {
            filebrowserBrowseUrl : 'assets/elfinder/elfinder.html', // eg. 'includes/elFinder/elfinder.html'
            //filebrowserBrowseUrl : 'index.php?controller=service&method=showElfinder', // eg. 'includes/elFinder/elfinder.html'
            //uiColor : '#9AB8F3'
        } );
    </script>
    <label for="is_active">Активна</label><input type="checkbox" name="is_active" value="1" <?php if ($this->page->is_active){echo 'checked="checked"';} ?> /><br>
    <label for="is_active">Отображать на главной: </label><input type="checkbox" name="is_main" value="1" <?php if ($this->page->is_main){echo 'checked="checked"';} ?> /><br>
    <input type="hidden" name="id" value="<?php echo $page->id; ?>">
    <input type="submit" name="submitUpdate" value="Сохранить страницу">
</form>