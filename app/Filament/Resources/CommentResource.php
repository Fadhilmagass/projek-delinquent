<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Forum';

    /**
     * Membatasi akses ke resource ini hanya untuk user dengan role 'admin'.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form sengaja dibuat read-only karena komentar seharusnya tidak dibuat/diedit dari admin panel
                Forms\Components\Select::make('user_id')
                    ->relationship('author', 'name')
                    ->disabled(),
                Forms\Components\Textarea::make('body')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('body')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('commentable_type')
                    ->label('Tipe Konten'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Aksi Edit dinonaktifkan, hanya bisa Hapus
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            // Halaman create dan edit tidak diperlukan untuk moderasi
            // 'create' => Pages\CreateComment::route('/create'),
            // 'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
