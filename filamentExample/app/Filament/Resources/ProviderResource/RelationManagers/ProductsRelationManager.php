<?php

namespace App\Filament\Resources\ProviderResource\RelationManagers;

use App\Filament\Resources\ProductResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
	protected static string $relationship = 'products';

	public function form(Form $form): Form
	{
		return $form
			->schema(ProductResource::getForm());
	}

	public function table(Table $table): Table
	{
		return $table
			->recordTitleAttribute('name')
			->columns(ProductResource::getColumnsTable())
			->filters(ProductResource::getFiltersTable())
			->headerActions([
				Tables\Actions\CreateAction::make(),
			])
			->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make(),
				]),
			]);
	}
}
