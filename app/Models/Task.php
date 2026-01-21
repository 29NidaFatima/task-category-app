<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\User;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
        'archived_at',
    ];


    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function isOverdue(): bool
    {
        return $this->status === 'pending'
            && $this->due_date
            && $this->due_date->isPast();
    }

    public function isArchived(): bool
    {
        return !is_null($this->archived_at);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
