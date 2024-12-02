<?php

namespace App\Filament\Resources;

use App\Filament\Interfaces\ResourceInterface;
use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProviderResource\RelationManagers\ProductsRelationManager;

class ProviderResource extends Resource implements ResourceInterface
{
	protected static ?string $model = Provider::class;

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	public static function getForm(): array
	{
		return [
			TextInput::make('name')->columnSpan(2),
			TextInput::make('cif')->columnSpan(2),
			TextInput::make('address')->columnSpan(2),
			TextInput::make('zip_code')->numeric()->columnSpan(2),
			TextInput::make('location')->columnSpan(2)

		];
	}

	public static function getColumnsTable(): array
	{
		return [
			TextColumn::make('name')->sortable()->searchable(),
			TextColumn::make('cif')->sortable()->searchable(),
			TextColumn::make('address')->sortable()->toggleable(isToggledHiddenByDefault: true),
			TextColumn::make('zip_code')->sortable()->toggleable(isToggledHiddenByDefault: true),
			TextColumn::make('location')->sortable()->toggleable(),
		];
	}

	public static function getFiltersTable(): array
	{
		return [

		];
	}
	public static function form(Form $form): Form
	{
		return $form
			->schema(self::getForm());
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns(self::getColumnsTable())
			->filters(self::getFiltersTable())
			->actions([
				Tables\Actions\EditAction::make(),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make(),
				]),
			]);
	}

	public static function getRelations(): array
	{
		return [
			ProductsRelationManager::class
		];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListProviders::route('/'),
			'create' => Pages\CreateProvider::route('/create'),
			'edit' => Pages\EditProvider::route('/{record}/edit'),
		];
	}
}
