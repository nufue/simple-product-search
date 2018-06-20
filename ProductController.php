<?php

namespace App\Products;

final class ProductController
{

	/** @var IProductStorage */
	private $productStorage;

	/** @var IRequestStatisticsStorage */
	private $requestStatistics;

	public function __construct(IProductStorage $productStorage, IRequestStatisticsStorage $requestStatistics)
	{
		$this->productStorage = $productStorage;
		$this->requestStatistics = $requestStatistics;
	}

	/**
	 * @param string $id
	 * @return string
	 */
	public function detail(string $id): string
	{
		$data = $this->productStorage->getById($id);
		$this->requestStatistics->markRequest($id);
		return json_encode($data);
	}

}