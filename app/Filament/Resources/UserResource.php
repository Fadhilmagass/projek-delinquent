<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
// Mengimpor Laravolt\Avatar\Facade untuk digunakan di kolom tabel
use Laravolt\Avatar\Facade as Avatar;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    // Memastikan email unik, tetapi mengabaikan record saat ini (untuk edit)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    // Hanya hash password jika field diisi. Ini mencegah password di-overwrite saat update jika field kosong.
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    // Hanya wajib diisi saat membuat user baru, bukan saat edit.
                    ->required(fn(string $context): bool => $context === 'create'),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    // Mengambil data dari relasi 'roles' dan menggunakan kolom 'name' sebagai label
                    ->relationship('roles', 'name')
                    ->preload() // Memuat opsi saat halaman dimuat untuk performa lebih baik
                    ->searchable(),
                Forms\Components\FileUpload::make('avatar_path')
                    ->label('Avatar')
                    ->image()
                    ->directory('avatars') // Simpan gambar di 'storage/app/public/avatars'
                    ->imageEditor()
                    ->circleCropper(),
                Forms\Components\TextInput::make('lokasi')
                    ->maxLength(255),
                Forms\Components\Textarea::make('bio')
                    ->maxLength(65535)
                    ->columnSpanFull(), // Membuat field ini memakan lebar penuh grid
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_path')
                    ->label('Avatar')
                    ->disk('public') // <-- Biarkan Filament yang menangani URL dengan ini
                    ->circular()
                    // Logika fallback ini hanya berjalan jika 'avatar_path' kosong
                    ->default(fn($record) => \Laravolt\Avatar\Facade::create($record->name)->toBase64()),
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                // Menampilkan role dengan gaya badge
                Tables\Columns\TextColumn::make('roles.name')->searchable()->badge(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    // Kolom ini bisa disembunyikan/ditampilkan oleh user
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable()
                    ->trueLabel('Verified Users')
                    ->falseLabel('Not Verified Users')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn(Builder $query) => $query->whereNull('email_verified_at'),
                    ),
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

    public static function getRelations(): array
    {
        return [
            // Jika kamu punya Relation Manager, daftarkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
