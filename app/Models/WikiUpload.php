<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiUpload extends Model
{
    use HasFactory;

    protected $table = 'wiki_upload';

    protected $fillable = [
        'space_id',
        'space_name',
        'type',
        'user_id',
        'filename',
        'log_filename',
        'total_count',
        'invalid_count',
        'nodata_count',
        'insert_failed_count',
        'update_failed_count',
        'exist_failed_count',
        'insert_success_count',
        'update_success_count',
        'bulk_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }
    public static function getIdByBulkId($bulkId)
    {
        $record = self::where('bulk_id', $bulkId)->first();
        return $record ? $record->id : null;
    }
}
