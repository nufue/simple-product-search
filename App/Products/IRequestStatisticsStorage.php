<?php

namespace App\Products;

interface IRequestStatisticsStorage {

	public function markRequest(string $id): void;

}