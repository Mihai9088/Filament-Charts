<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\Markdown;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Actions\DeleteAction as DeleteAction;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationGroup = 'Posts';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Tabs::make('Create new post')->tabs([


                    Tab::make('General') ->icon('heroicon-o-folder')->schema([
                        TextInput::make('title')->rules(['required']),
                        TextInput::make('slug')->rules(['required']),
                   
                    Select::make('category_id')->relationship('category', 'name')->required(),
                        
                    ]),

                        Tab::make('Content')->schema([
                            MarkdownEditor::make('content')->rules(['required'])->columnSpan(2)->minHeight('300px'),
                        ]),
                         
                        Tab::make('Other')->schema([
                            FileUpload::make('thumbnail')->disk('public')->directory('Che')->columnSpanFull()->imagePreviewHeight('150'),

                            ColorPicker::make('color')->rules(['required']),
                           
                            TagsInput::make('tags')->rules(['required']),
                            Checkbox::make('published')->label('Publish'),
                        ]),
                    
                ])->columnSpan(3),

                

            

Group::make([
Section::make('Authors')->collapsible()->description('lorem ipsum dolor sit amet consectetur adipisicing elit ')->schema([

    CheckboxList::make('authors')->relationship('authors', 'name'),  
    
]),
])->columnSpan(3),




     ])->columns(3);



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->searchable()->sortable(),
                TextColumn::make('category.name')->searchable()->sortable(),
                ColorColumn::make('color'),
                ImageColumn::make('thumbnail'),
                TextColumn::make('tags'),
                CheckboxColumn::make('published'),
                TextColumn::make('created_at')->label('PUBLISHED')
                    ->date('Y-m-d')->sortable()->searchable()->toggleable(),
                TextColumn::make('updated_at')
                    ->date('Y-m-d')->sortable()->searchable()->toggleable(),
            ])
            ->filters([
            Filter::make('Published Posts')->query( fn ( $query) => $query->where('published', true)),
            SelectFilter::make('category_id')->options(Category::all()->pluck('name', 'id'))->multiple()->label('Category'),                         
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            DeleteAction::make(),
            CreateAction::make(),
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
            AuthorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}