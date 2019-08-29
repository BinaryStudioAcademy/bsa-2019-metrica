<?php

namespace App\Aggregates\Contracts;

interface Aggregate
{
	public function toArray(): array;

	public function getId(): int;
}
