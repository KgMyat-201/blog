<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name'),
                    Select::make('category_id')
                            ->relationship('category', 'name'),
                    TextInput::make('price')
                            ->numeric(),
                    RichEditor::make('content')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ]),
                    Toggle::make('is_published')
                            ->onIcon('heroicon-s-lightning-bolt')
                            ->offIcon('heroicon-s-user')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                            ->label('Title')
                            ->sortable()
                            ->searchable(),
                TextColumn::make('category.name')
                            ->sortable()
                            ->searchable(),
                TextColumn::make('price'),
                TextColumn::make('content')
                            ->toggleable(isToggledHiddenByDefault: true),
                BooleanColumn::make('is_published')
                            ->label('Publish')
                            ->sortable(),

            ])
            ->defaultSort('name', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
