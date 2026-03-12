<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['seminar_id', 'user_id', 'parent_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function replies()
    {
        return $this->hasMany(Discussion::class, 'parent_id')->oldest();
    }

    public function parent()
    {
        return $this->belongsTo(Discussion::class, 'parent_id');
    }
}