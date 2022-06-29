<?php

namespace App\Models;

use App\Models\Note;
use App\Models\User;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [''];

    /**
     * Get all of the users for the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the divisions for the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }

    /**
     * Get all of the positions for the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
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
     * Get all of the notesDistributions for the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function noteDistributions(): HasMany
    {
        return $this->hasMany(Note::class)->whereHas('noteDistributions');
    }
    
    /**
     * Get all of the note_distributions for the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function note_distributions(): HasManyThrough
    {
        return $this->hasManyThrough(NoteDistribution::class, Note::class);
    }
}
