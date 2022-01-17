<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteDistribution extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the note that owns the NoteDistribution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * Get the sender that owns the NoteDistribution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userSender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * Get the userSender that owns the NoteDistribution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userReceiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    /**
     * Get the positionSender that owns the NoteDistribution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function positionSender(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'sender_position_id');
    }

    /**
     * Get the positionReceiver that owns the NoteDistribution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function positionReceiver(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'receiver_position_id');
    }
}
