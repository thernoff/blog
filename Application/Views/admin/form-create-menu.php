<?php 
    function print_tree($map, $id_parent, $shift = 0)
    {
        if(!empty($map))
        {
            foreach($map as $section)
            { ?>
                <option value="<?=$section['id']?>">
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
<form class="admin" action="" method="post">
    <div>
        <label for="title">Название меню: </label><input type="text" id="title" name="name" value="<?=$this->menu->name; ?>">
    </div>
    <div>
        <label for="alias">Алиас: </label><input type="text" name="alias" id="alias" value="<?=$this->category->alias; ?>" />
    </div>
    <div><input type="button" id="btnCreateItemMenu" value="Добавить пункт меню"/></div>
    <div class="base-item menu-item" style="display: none">
        <div>
            <label for="title">Название пункта меню: </label><input type="text" id="title_item" name="name_item[]" value="">
        </div>
        <div><label for="ids_parent">Категория</label><select name="ids_parent[]" id="ids_parent">
                                                    <option value="0">Без раздела</option>
                                                    <?= print_tree($this->map, $this->page->id_parent); ?>
                                            </select>
       <label for="ids_page">Выберите страницу</label><select name="ids_page[]" id="ids_page">
                                                    <option value="0">Все страницы</option>
                                                    <?php foreach ($this->pages as $page):?>
                                                    <option data-parent="<?=$page->getParents()?>" value="<?=$page->id?>"><?=$page->title;?></option>
                                                    <?php endforeach;?>
                                            </select><br>
        </div>
        <div class="delete-item"><button class="btn-delete-item">X</button></div>
    </div>
    <div class="menu-item border">
        <div><label for="title">Название пункта меню: </label><input type="text" id="title_item" name="name_item[]" value=""></div>
        <div><label for="ids_parent">Категория</label><select name="ids_parent[]" id="ids_parent">
                                                    <option value="0">Без раздела</option>
                                                    <?= print_tree($this->map, $this->page->id_parent); ?>
                                            </select>
       <label for="ids_page">Выберите страницу</label><select name="ids_page[]" id="ids_page">
                                                    <option value="0">Все страницы</option>
                                                    <?php foreach ($this->pages as $page):?>
                                                    <option data-parent="<?=$page->getParents()?>" value="<?=$page->id?>"><?=$page->title;?></option>
                                                    <?php endforeach;?>
                                            </select><br>
        </div>
    </div>
    <div><label for="is_active">Активно: </label><input type="checkbox" name="is_active" value="1" <?php if ($this->page->is_active){echo 'checked="checked"';} ?> /></div>
    <div>
        <input type="submit" name="submitCreate" value="Сохранить">
    </div>
</form>