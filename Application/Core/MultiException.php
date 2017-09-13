<?php

namespace Application\Core;

class MultiException
	extends \Exception
	implements \ArrayAccess, \Iterator
{
	use TCollection;
}