<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function spaces()
    {
        return $this->hasMany(Space::class);
    }

    public function wikis()
    {
        return $this->hasMany(Wiki::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
     public function chatbots()
    {
        return $this->hasMany(Chatbot::class);
    }
}
