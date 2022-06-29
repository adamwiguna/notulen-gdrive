<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Division;
use App\Models\Organization;
use App\Models\NoteDistribution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [''];
    // protected $fillable = ['name', 'alias', 'organization_id'];

    

    /**
     * Get the organization that owns the Position
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the division that owns the Position
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get all of the users for the Position
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
        return $this->hasMany(NoteDistribution::class, 'sender_position_id', 'id');
    }

    /**
     * Get all of the asReceiver for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asReceiver(): HasMany
    {
        return $this->hasMany(NoteDistribution::class, 'receiver_position_id', 'id');
    }
}
