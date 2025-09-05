<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\HasName;
use App\Enums\UserStatus;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasName
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    protected static function booted(): void
    {
        static::deleting(function ($user) {
            if ($user->id === 1) {
                throw new \Exception('you cannot delete this admin');
            }
        });
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        "name"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'department_id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone_number' => 'string',
        'type' => 'string',
        'public_key' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function getFilamentName(): string
    {
        return $this->first_name;
    }

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    // }
    //     return true;

    public static function getForm()
    {
        return [
            Section::make("User info")
                ->columns(2)
                ->schema([
                    FileUpload::make('avatar')
                        ->label('image profile')
                        ->disk('public')
                        ->directory('avatars')
                        ->image()
                        ->avatar()
                        ->maxSize(1024 * 20)
                        // ->required
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->autocomplete('new-password')
                        ->revealable()
                        ->confirmed()
                        ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(Page $livewire) => $livewire instanceof CreateRecord)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->autocomplete('new-password')
                        ->revealable()
                        ->same('password')
                        ->required(fn(Page $livewire) => $livewire instanceof CreateRecord)
                        ->dehydrated(FALSE),
                    Forms\Components\TextInput::make('mobile')
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->options(UserStatus::asSelectArray())
                        ->enum(UserStatus::class)
                        ->default(UserStatus::EMPLOYEE)
                        ->required(),
                ]),

            Forms\Components\Select::make('department_id')
                ->required()
                ->label("department")
                ->searchable()
                ->preload()
                ->editOptionForm(Department::getForm())
                ->createOptionForm(Department::getForm())
                ->relationship("department", "name"),
        ];
    }
}
