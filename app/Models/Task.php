<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['teks', 'waktu', 'selesai'];

    protected $casts = [
        'selesai' => 'boolean',
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}