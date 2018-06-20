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

	public function hasProduct(string $id): bool
	{
		return file_exists($this->cacheFullName($id));
	}

	public function load(string $id): array
	{
		return json_decode(file_get_contents($this->cacheFullName($id)), true);
	}

	public function save(string $id, array $product): void
	{
		file_put_contents($this->cacheFullName($id), json_encode($product));
	}

	private function cacheFullName(string $id): string
	{
		return $this->cacheDir . $this->sanitizeId($id);
	}

	private function sanitizeId(string $id): string
	{
		return sha1($id);
	}

}