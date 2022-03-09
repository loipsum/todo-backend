<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Todo
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Database\Factories\TodoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Todo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Todo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Todo whereUserId($value)
 * @mixin \Eloquent
 */
class Todo extends \Eloquent
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
