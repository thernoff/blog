<?php 
echo "<table>";
foreach ($allNews as $news){
	echo "<tr>";
	echo "<td>" . $news->id . "</td>";
	echo "<td>" . $news->title . "</td>";
	echo "<td>" . $news->text . "</td>";
	echo "<td><a href='?controller=update&id=" . $news->id . "'>Обновить</a></td>";
	echo "<td><a href='?controller=delete&id=" . $news->id . "'>Удалить</a></td>";
	echo "</tr>";
}
echo "</table>";