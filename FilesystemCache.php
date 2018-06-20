<?php

namespace App\Products;

final class FilesystemCache implements ICache
{
	/** @var string */
	private $cacheDir = __DIR__ . '/cache/';

	public function __construct()
	{
		if (!file_exists($this->cacheDir) && !mkdir($concurrentDirectory = $this->cacheDir) && !is_dir($concurrentDirectory)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		}
	}

	/**
	 * Do we have the product already in cache?
	 */
	public function hasProduct(string $id): bool
	{
		return file_exists($this->cacheFullName($id));
	}

	/**
	 * Load cached product data from a file.
	 */
	public function load(string $id): array
	{
		if ($this->hasProduct($id)) {
			return json_decode(file_get_contents($this->cacheFullName($id)), true);
		}

		throw new \RuntimeException('Cache entry for product '.$id.' was not found.');
	}

	/**
	 * Saved cached product data to file.
	 */
	public function save(string $id, array $product): void
	{
		file_put_contents($this->cacheFullName($id), json_encode($product));
	}

	/**
	 * Construct full pathname for product cache file.
	 */
	private function cacheFullName(string $id): string
	{
		return $this->cacheDir . $this->sanitizeId($id);
	}

	/**
	 * Sanitize product ID to be safe for filesystem storage.
	 */
	private function sanitizeId(string $id): string
	{
		return sha1($id);
	}

}