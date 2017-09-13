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
<h2><?=$this->title;?></h2>
<form class="admin" action="" method="post">
    <div><label for="title">Имя категории: </label><input type="text" id="title" name="name" value="<?=$this->category->name; ?>"></div>
    <div><label for="alias">Алиас: </label><input type="text" name="alias" id="alias" value="<?=$this->category->alias; ?>" /></div>
    <div><label for="parent">Родительская категория</label><select name="id_parent">
						<option value="0">Без раздела</option>
						<?= print_tree($this->map, $this->page->id_parent); ?>
					</select>
    </div>
    <input type="submit" name="submitCreate" value="Сохранить">
</form>