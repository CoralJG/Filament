<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
	protected static ?string $model = Product::class;

	protected static ?string $navigationIcon = 'fas-spider';

	protected static ?string $navigationLabel = 'Productos';
	protected static ?string $navigationGroup = 'E-Commerce';

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				TextInput::make('name')->columnSpan(2)->placeholder('Example:name')->required(),
				FileUpload::make('image_url')->columnSpan(2)->placeholder('Example:image_url')->label('Imagen'),
				TextInput::make('price')->columnSpan(2)->placeholder('Example:number')->numeric()->suffix('€')->required(),
				TextInput::make('stock')->columnSpan(2)->placeholder('Example:stock number')->required(),
				TextArea::make('description')->columnSpan(2)->placeholder('Example:description'),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				ImageColumn::make('image_url')->circular()->toggleable()->label('Imagen'),
				TextColumn::make('name')->searchable()->sortable(),
				TextColumn::make('description')->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('price')->suffix('€')->sortable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('stock')->sortable()->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([
				//
			])
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
