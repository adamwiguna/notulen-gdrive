<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Division;
use App\Models\Position;
use App\Models\Organization;
use App\Models\NoteDistribution;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ['id', 'name','email', 'password', 'organization_id', 'position_id', 'slug'];
    
    protected $guarded = [''];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the organization that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the division that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the position that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get all of the notes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get all of the asSenders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asSender(): HasMany
    {
        return $this->hasMany(NoteDistribution::class, 'sender_user_id', 'id');
    }

    /**
     * Get all of the asReceiver for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asReceiver(): HasMany
    {
        return $this->hasMany(NoteDistribution::class, 'receiver_user_id', 'id');
    }

}
