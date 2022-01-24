<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Todo extends Model
{
    const STATUS_INCOMPLETE = false;
    const STATUS_COMPLETE = true;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];

    protected $appends = ['is_complete'];
    
    /**
     * Return calculate field 'is_complete' getIsCompleteAttribute
     *
     * @return string
     */
    public function getIsCompleteAttribute()
    {
        return $this->status?'Complete':'Incomplete';
    }
        
    /**
     * Todo's user
     *
     * @return HasOne
     */
    public function user(): HasOne
    {   
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
