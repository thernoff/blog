<?php
function print_tree($map, $id_parent, $id, $shift = 0)
{
    if(!empty($map))
    {
        foreach($map as $section)
        { ?><?php if ($section['id'] == $id){ continue;}?>
            <option value="<?=$section['id']?>"  <?php if ($section['id'] == $id_parent){echo "selected";}?>>
                <?php for($i = 0; $i < $shift; $i++){echo '&nbsp;';}?>
                <?=$section['name']?>
            </option>
            <?php print_tree($section['children'],$id_parent, $id, $shift + 2); 
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
						<?= print_tree($this->map, $this->category->id_parent, $this->category->id); ?>
					</select>
    </div>
    <input type="hidden" name="id" value="<?php echo $this->category->id; ?>">
    <input type="submit" name="submitCreate" value="Сохранить">
</form>