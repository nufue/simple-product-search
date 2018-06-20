<?php

namespace App\Products;

final class FileRequestStatisticsStorage implements IRequestStatisticsStorage
{
	/** @var string */
	private $dataFile = __DIR__ . '/temp/statistics.json';

	/** @var string */
	private $lockFile = __DIR__ . '/temp/statistics.lock';

	public function __construct()
	{
		if (!file_exists($this->dataFile)) {
			file_put_contents($this->dataFile, json_encode([]));
		}
	}

	public function markRequest(string $id): void
	{
		$fp = fopen($this->lockFile, 'wb');
		if (flock($fp, LOCK_EX)) {
			$json = file_get_contents($this->dataFile);
			$data = json_decode($json);
			if (!isset($data[$id])) {
				$data[$id] = 0;
			}
			$data[$id]++;
			file_put_contents($this->dataFile, json_encode($data));
			flock($fp, LOCK_UN);
			fclose($fp);
			unlink($this->lockFile);
		} else {
			fclose($fp);
		}
	}

}