<?php

namespace App\Products;

final class CachedProductStorage implements IProductStorage
{

	/** @var IProductStorage */
	private $productStorage;

	/** @var ICache */
	private $cache;

	public function __construct(IProductStorage $productStorage, ICache $cache)
	{
		$this->productStorage = $productStorage;
		$this->cache = $cache;
	}

	/**
	 * Look into cache to get product by ID. When not found, load from parent storage and save to cache.
	 */
	public function getById(string $id): array
	{
		if ($this->cache->hasProduct($id)) {
			return $this->cache->load($id);
		}

		$product = $this->productStorage->getById($id);
		$this->cache->save($id, $product);
		return $product;
	}
}