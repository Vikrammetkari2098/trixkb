<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseCategory extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name', 'category_status', 'created_by'];
    protected $attributes = [
        'status' => 1,
    ];


    /**
     * Relationship to user who created the category
     */public function user()
    {
        return $this->belongsTo(User::class, 'created_by'); // Adjust foreign key if needed
    }

    /**
     * Helper method to create a category
     */
    public static function createCategory(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'status' => $data['status'] ?? 1,
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);
    }
}
