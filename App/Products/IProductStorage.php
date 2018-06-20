<?php

namespace App\Products;

interface IProductStorage {

	public function getById(string $id): array;

}