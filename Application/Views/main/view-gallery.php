<?php
    echo '<h2>' . $gallery->name . '</h2>';
    $aliasGallery = $gallery->alias;
?>
<ul class="gallery">
    <?php foreach($images as $image):?>
        <li>
            <a href="assets/upload/gallery/large/<?=$aliasGallery . "/" . $image->name;?>">
                <img src="assets/upload/gallery/thumb/<?=$aliasGallery . "/" . $image->name;?>" alt=""/>
            </a>
        </a>
        </li>
    <?php endforeach;?>
</ul>