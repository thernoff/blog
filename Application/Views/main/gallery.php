<h2><?=$this->title;?></h2>
<ul class="preview-gallery">
    <?php foreach ($galleries as $gallery): ?>
    <?php $firstImage = $gallery->getFirstImage();?>
    <li>
        <a href="<?php echo "index.php?controller=main&action=viewGallery&id=" . $gallery->id;?>">
            <img src="assets/upload/gallery/thumb/<?=$gallery->alias . "/" . $firstImage['name']?>" alt=""/>
        </a>
        <p><?=$gallery->name;?></p>
    </li>
        
    <?php endforeach;?>
</ul>