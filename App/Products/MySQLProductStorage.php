<?php

namespace App\Products;

final class MySQLProductStorage implements IProductStorage {

	/** @var IMySQLDriver */
	private $mysql;

	public function __construct(IMySQLDriver $driver)
	{
		$this->mysql = $driver;
	}

	public function getById(string $id): array
	{
		return $this->mysql->findProduct($id);
	}


}