<?php

namespace Application\Core;

trait TCollection
{
	protected $data = [];
	
	//Определяет, существует ли заданное смещение (ключ)
	public function offsetExists ( $offset )
	{
		return array_key_exists($offset, $this->data);
	}
	
	//Возвращает заданное смещение (ключ)
	public function offsetGet ( $offset )
	{
		return $this->data[$offset];
	}
	
	//Присваивает значение заданному смещению
	public function offsetSet ( $offset , $value )
	{
		if ('' == $offset){
			$this->data[] = $value;
		} else {
			$this->data[$offset] = $value;
		}
	}
	
	//Удаляет смещение
	public function offsetUnset ( $offset )
	{
		unset( $this->data[$offset]);
	}
	
	//Возвращает текущий элемент
	public function current()
	{
		return current( $this->data );
	}
	
	//Переходит к следующему элементу
	public function next()
	{
		next($this->data);
	}
	
	//Возвращает ключ текущего элемента
	public function key()
	{
		return key($this->data);
	}
	
	//Проверка корректности позиции
	public function valid()
	{
		return false !== current($this->data);
	}
	
	//Возвращает итератор на первый элемент
	public function rewind()
	{
		reset($this->data);
	}
}