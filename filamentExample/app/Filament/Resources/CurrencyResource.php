<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrencyResource extends Resource
{
	protected static ?string $model = Currency::class;

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				TextInput::make('name')->columnSpan(2),
				TextInput::make('symbol')->columnSpan(2),
				TextInput::make('code')->columnSpan(2)
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('name')->sortable()->searchable(),
				TextColumn::make('symbol')->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('code')->toggleable(isToggledHiddenByDefault: true)
			])
			->filters([
				//
			])
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
			//
		];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListCurrencies::route('/'),
			'create' => Pages\CreateCurrency::route('/create'),
			'edit' => Pages\EditCurrency::route('/{record}/edit'),
		];
	}
}
