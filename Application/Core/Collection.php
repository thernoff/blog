<?php

namespace Application\Core;

class Collection 
	implements \ArrayAccess, \Iterator
//Класс Collection реализует 
//	интерфейс ArrayAccess, который обеспечивает доступ к объектам как к массиву
//	Iterator - интерфейс для внешних итераторов или объектов, которые могут повторять себя изнутри.
{
	use TCollection;
}