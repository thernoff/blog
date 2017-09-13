<?php

namespace Application\Models;

interface HasEmail
{
	/**
	 * Метод, возвращающий email
	 * @return string Адрес электронной почты
	 */
	public function getEmail();
}