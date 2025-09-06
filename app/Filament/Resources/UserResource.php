<?php

namespace App\Filament\Resources;

use App\Enums\UserStatus;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Department;
use App\Models\User;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup as ActionsActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = "users";
    protected static ?string $navigationIcon = "heroicon-o-users";

    protected static ?string $navigationGroup = "resources";

    // public static function getNavigationBadge(): ?string
    // {
    //     return '2';
    // }
    // public static function getNavigationBadgeColor(): string|array|null
    // {
    //     return "danger";
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(User::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("avatar")
                    ->circular()
                    ->default(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=000&color=fff'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(function (string $state): string {
                        return UserStatus::from($state)->label();
                    })
                    ->color(function (string $state): string {
                        return UserStatus::from($state)->badgeColor();
                    }),
                Tables\Columns\TextColumn::make('department.name')
                    ->label("Department")
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionsActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Action::make("delete")
                        ->hidden(function (user $record) {
                            return $record->id == 1;
                        })
                        ->icon("heroicon-o-trash")
                        ->color("danger")
                        ->requiresConfirmation()
                        ->action(function (User $record) {
                            $record->delete();
                        })
                        ->after(function () {
                            Notification::make()->danger()
                                ->title("this user was deleted")
                                ->duration(5000)
                                ->send();
                        }),
                ])
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
