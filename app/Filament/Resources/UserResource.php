<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\{
    Form,
    Resource,
    Table
};
use Filament\Tables;
use Illuminate\Database\Eloquent\{
    Builder,
    SoftDeletingScope,
};
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->autofocus()
                                    ->disableAutocomplete()
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->disableAutocomplete()
                                    ->helperText('Email must be unique')
                                    ->unique(table: User::class, ignoreRecord: true, callback: function (Unique $rule) {
                                        return $rule->whereNull('deleted_at');
                                    }),
                                Forms\Components\TextInput::make('password')
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->password()
                                    ->disableAutocomplete()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state)),
                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->disableAutocomplete()
                                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+{62} 0000000000000')),
                                Forms\Components\Textarea::make('address')
                                    ->required()
                                    ->columnSpan('full'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->weight('medium')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)
                    ->description(fn (User $record): string => $record->role),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->default('-'),
                Tables\Columns\BadgeColumn::make('email_verified_at')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state != null ? 'aktif' : 'belum aktif')
                    ->colors([
                        'success' => static fn ($state): bool => $state != null,
                        'danger' => static fn ($state): bool => $state == null,
                    ]),
                Tables\Columns\TextColumn::make('address')
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getLimit()) {
                            return null;
                        }
                        // Only render the tooltip if the column contents exceeds the length limit.
                        return $state;
                    }),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->placeholder('Status')
                    ->trueLabel('With status aktif')
                    ->falseLabel('Only status nonaktif')
                    ->nullable(),
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'super_admin' => 'Super admin',
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                    ]),
                Tables\Filters\TernaryFilter::make('trashed')
                    ->placeholder('Without trashed records')
                    ->trueLabel('With trashed records')
                    ->falseLabel('Only trashed records')
                    ->queries(
                        true: fn (Builder $query) => $query->withTrashed(),
                        false: fn (Builder $query) => $query->onlyTrashed(),
                        blank: fn (Builder $query) => $query->withoutTrashed(),
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->hidden(fn () => auth()->user()->role == 'admin'),
                    Tables\Actions\Action::make('activated')
                        ->label(fn (User $record) => $record->email_verified_at == null ? 'Activated' : 'Unactivated')
                        ->action(fn (User $record) => $record->activated())
                        ->requiresConfirmation()
                        ->color(fn (User $record) => $record->email_verified_at == null ? 'success' : 'danger')
                        ->icon('heroicon-o-key')
                        ->button(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden(fn () => auth()->user()->role == 'admin'),
                // Tables\Actions\ForceDeleteBulkAction::make()
                //     ->hidden(fn () => auth()->user()->role == 'admin'),
                Tables\Actions\RestoreBulkAction::make()
                    ->hidden(fn () => auth()->user()->role == 'admin'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->latest('updated_at');
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
