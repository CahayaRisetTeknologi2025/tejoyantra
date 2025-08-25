<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    protected static ?string $model = User::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static ?string $recordTitleAttribute = 'User Management';
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return 'Master Data';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->hiddenOn('edit')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'super_admin' => 'Super admin', 'external' => 'External'])
                    ->default('admin')
                    ->required(),
                Toggle::make('is_active')
                    ->label('Active?')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('role')->formatStateUsing(fn(string $state) => Str::of($state)->replace('_', ' ')->title()),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('userCreated.name')
                    ->label('Created By'),
                TextEntry::make('userUpdated.name')
                    ->label('Updated By'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('User')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('role')
                ->formatStateUsing(fn(string $state) => Str::of($state)->replace('_', ' ')->title()),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('Active?')
                    ->query(fn (Builder $query) => $query->where('is_active', '=', true)),
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'super_admin' => 'Super admin',
                        'external' => 'External',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->mutateDataUsing(function (array $data): array {
                    $data['updated_by'] = auth()->id();
                    $data['updated_at'] = now();

                    return $data;
                }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
