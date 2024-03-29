<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;

use App\Models\Category;
use Filament\Forms\Form;

use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationGroup = 'Posts';

    protected static ?string $modelLabel = 'Category';

    protected static ?int $navigationSort = 2;
    

    public static function form(Form $form): Form
    { $words = [
        'mysterious', 'radical', 'asthmatic', 'automatic', 'rich',
        'poor', 'evil', 'zany', 'quirky', 'kooky',
        'wacky', 'bizarre', 'extravagant', 'incentric', 'offbeat',
        'whimsical', 'silly', 'absurd', 'suspicious'
    ];
        $random = $words[array_rand($words)];
        


        return $form
            ->schema([
                TextInput::make('name')->rules(['required'])->live(onBlur:true)->afterStateUpdated(function (string $operation  , string $state ,Set $set) use ($random) {
                
                    if($operation === 'edit'){
                        return;
                    }

               $set('slug' , $random . '_' . $state );
               
                }),
                TextInput::make('slug')->readOnly(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
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
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
