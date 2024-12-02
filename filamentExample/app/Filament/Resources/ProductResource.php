<?php

namespace App\Filament\Resources;

use App\Filament\Interfaces\ResourceInterface;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource implements ResourceInterface
{
	protected static ?string $model = Product::class;

	protected static ?string $navigationIcon = 'fas-spider';

	protected static ?string $navigationLabel = 'Productos';
	protected static ?string $navigationGroup = 'E-Commerce';

	public static function getForm(): array
	{
		return [
			TextInput::make('name')->columnSpan(2)->placeholder('Example:name')->required(),
			FileUpload::make('image_url')->columnSpan(2)->placeholder('Example:image_url')->label('Imagen')->required(),
			TextInput::make('price')->columnSpan(2)->placeholder('Example:number')->numeric()->required(),
			Select::make('currency_id')
				->relationship('currency', 'name')
				->columnSpanFull()
				->createOptionAction(function (): array {
					return [
						TextInput::make('name')->columnSpan(2)->required(),
						TextInput::make('symbol')->columnSpan(2)->required(),
						TextInput::make('code')->columnSpan(2)->required(),
					];
				})
				->required(),

			Select::make('provider_id')->relationship('provider', 'name')->columnSpanFull()->required(),
			Select::make('status_id')->relationship('status', 'name')->columnSpanFull()->required(),
			TextInput::make('stock')->columnSpan(2)->placeholder('Example:stock number')->required(),
			TextArea::make('description')->columnSpan(2)->placeholder('Example:description')->required(),
		];
	}
	public static function getColumnsTable(): array
	{
		return [
			ImageColumn::make('image_url')->circular()->toggleable()->label('Imagen'),
			TextColumn::make('name')->searchable()->sortable(),
			TextColumn::make('description')->toggleable(isToggledHiddenByDefault: true),
			TextColumn::make('price')->sortable()->toggleable(isToggledHiddenByDefault: true),
			TextColumn::make('currency.name')->toggleable(),
			TextColumn::make('provider.name')->sortable()->toggleable(),
			SelectColumn::make('status_id')->label('Status')->options(Status::all()->pluck('name', 'id')->toArray())->inline()->sortable()->toggleable(),
			TextColumn::make('stock')->sortable()->toggleable(isToggledHiddenByDefault: true),
		];
	}
	public static function getFiltersTable(): array
	{
		return [
			SelectFilter::make('currency_id')->relationship('currency', 'name')->label('Currency'),
			SelectFilter::make('provider_id')->relationship('provider', 'name')->label('Provider'),
			SelectFilter::make('status_id')->relationship('status', 'name')->label('Status'),
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
				Tables\Actions\DeleteAction::make()
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
			'index' => Pages\ListProducts::route('/'),
			'create' => Pages\CreateProduct::route('/create'),
			'edit' => Pages\EditProduct::route('/{record}/edit'),
		];
	}
}
