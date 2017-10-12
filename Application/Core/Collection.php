<?php

namespace Application\Core;

//Класс Collection реализует 
//	интерфейс ArrayAccess, который обеспечивает доступ к объектам как к массиву
//	Iterator - интерфейс для внешних итераторов или объектов, которые могут повторять себя изнутри.

class Collection 
	implements \ArrayAccess, \Iterator

{
	use TCollection;
}