<?php

namespace App\Products;

final class ElasticSearchProductStorage implements IProductStorage
{

	/** @var IElasticSearchDriver */
	private $elasticSearch;

	public function __construct(IElasticSearchDriver $driver)
	{
		$this->elasticSearch = $driver;
	}

	public function getById(string $id): array
	{
		return $this->elasticSearch->findById($id);
	}

}