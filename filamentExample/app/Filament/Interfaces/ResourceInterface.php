<?php

namespace App\Filament\Interfaces;

interface ResourceInterface
{
	public static function getForm(): array;
	public static function getColumnsTable(): array;
	public static function getFiltersTable(): array;

}