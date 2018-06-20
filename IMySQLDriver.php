<?php

namespace App\Products;

interface IMySQLDriver
{
	/**
	 * @param string $id
	 * @return array
	 */
	public function findProduct($id);
}