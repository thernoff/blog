<?php
foreach ($news as $item){
	echo '<h3><a href=Application/Controller/article.php?id='.$item->id.'>'.$item->title.'</a></h3>';
	echo "<p>".$item->text."</p>";
}