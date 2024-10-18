<?php

namespace App\Filament\Userpanel\Resources;

use App\Filament\Userpanel\Resources\ArticleResource\Pages;
use App\Filament\Userpanel\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        $panel = Filament::getCurrentPanel();
        $panel_id = $panel->getId();
        if ($panel_id == 'userpanel'){
            $articles = Article::where('user_id', Auth::id())->get();
        }
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make("Information's")
                    ->collapsed()
                    ->schema([
                        TextInput::make("title")
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->reactive()
                            ->debounce(800)
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                $name = $get('title');
                                $slug = strtolower(trim(preg_replace('/\s+/', '-', $name)));
                                $set('slug', $slug);
                            }),

                        TextInput::make("slug")
                            ->unique(ignoreRecord: true)
                            ->required(),


                        Forms\Components\Hidden::make("user_id")
                            ->default(Auth::id())
                            ->required(),

                        Select::make("article_category_id")
                            ->label("Category")
                            ->columnSpanFull()
                            ->searchable()
                            ->options(ArticleCategory::all()->pluck('name', 'id'))
                            ->required(),

                        TagsInput::make('tags')
                            ->columnSpanFull()
                            ->required(),


                        \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('description')
                            ->columnSpanFull()
                            ->required()


                    ])->columns(2),


                Section::make("Image")
                    ->collapsed()
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image')
                            ->directory('articles')
                            ->image()
                            ->columnSpanFull()
                            ->required()
                            ->imageEditor(),
                    ])->columns(1),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->width(50)
                    ->height(50),

                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('user.username'),
                \Filament\Tables\Columns\TextColumn::make('category.name'),

                Tables\Columns\IconColumn::make('status')
                    ->wrapHeader()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
