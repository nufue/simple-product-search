<?php

namespace App\Products;

interface ICache
{
	public function hasProduct(string $id): bool;

	public function load(string $id): array;

	public function save(string $id, array $product): void;

}