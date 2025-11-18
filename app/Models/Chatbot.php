<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Chatbot extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wiki_chatbot';

    protected $fillable = [
        'ref_id',
        'name',
        'region',
        'language_id',
        'status',
        'organisation_id',
        'description',
        'main_category',
        'service',
        'sub_service',
        'user_id',
        'space_id',
        'team_id',
        'views',
        'slug',
        'created_by',
        'modified_by',
        'deleted_by',
        'bulk_id',
    ];

    // Constants
    const REGION = [
        1 => 'Semenanjung',
        2 => 'Sabah',
        3 => 'Sarawak',
    ];

    const LANGUAGE = [
        1 => 'BM',
        2 => 'EN',
    ];

    const STATUS = [
        1 => 'Active',
        2 => 'Inactive',
    ];

    protected $casts = [
        'organisation_id' => 'integer',
        'department_id' => 'integer',
        'ministry_id' => 'integer',
        'space_id' => 'integer',
        'language_id' => 'integer',
    ];
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'subject');
    }

    // Scopes
    public function scopeFilterByKeyword($query, $keyword)
    {
        return $query->where('name', 'like', "%$keyword%")
                     ->orWhere('description', 'like', "%$keyword%")
                     ->orWhereHas('organisation.ministry', function ($q) use ($keyword) {
                         $q->where('name', 'like', "%$keyword%");
                     });
    }

    // Accessors
    public function getRegionNameAttribute()
    {
        return self::REGION[$this->region] ?? 'Unknown';
    }

    public function getLanguageNameAttribute()
    {
        return self::LANGUAGE[$this->language_id] ?? 'Unknown';
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->status] ?? 'Unknown';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i:s A');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i:s A');
    }

    // Methods
    public static function generateRefId(): string
    {
        $latest = self::withTrashed()->latest('ref_id')->first();
        $next = $latest ? ((int) str_replace('Chatbot', '', $latest->ref_id) + 1) : 1;
        return 'Chatbot' . str_pad($next, 15, '0', STR_PAD_LEFT);
    }

    public function saveChatbot(array $data, $team)
    {
        $user = auth()->user();

        $organisationId = $this->getOrgaId($data['ministry'] ?? null, $data['department'] ?? null);

        return $this->create([
            'ref_id' => self::generateRefId(),
            'name' => $data['name'] ?? null,
            'region' => $data['region'] ?? 1,
            'language_id' => $data['language'] ?? 1,
            'status' => 1,
            'organisation_id' => $organisationId,
            'description' => $data['description'] ?? null,
            'main_category' => $data['main_category'] ?? null,
            'service' => $data['service'] ?? null,
            'sub_service' => $data['sub_service'] ?? null,
            'slug' => uniqid(),
            'space_id' => $this->getMinistryId($data['ministry'] ?? null),
            'team_id' => $team->id,
            'views' => 0,
            'user_id' => $user->id,
            'created_by' => $user->id,
            'modified_by' => $user->id,
        ]);
    }

    public function getOrgaId($ministryId = null, $departmentId = null)
    {
        $category = $departmentId ? 2 : 1;

        $organisation = Organisation::where('ministry_id', $ministryId)
                                    ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
                                    ->where('category', $category)
                                    ->first();

        return $organisation?->id ?? null;
    }

    public function getMinistryId($ministryOrgaId)
    {
        return Organisation::where('id', $ministryOrgaId)->value('ministry_id');
    }

    public function recordView()
    {
        DB::table('wiki_chatbot_views')->insert([
            'wiki_chatbot_id' => $this->id,
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function recordDeleteLog()
    {
        DB::table('wiki_delete_chatbot_log')->insert([
            'chatbot_id' => $this->id,
            'user_id' => auth()->id(),
            'ref_id' => auth()->id() . '_' . time(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function logs()
    {
        return $this->hasMany(ChatbotLog::class, 'chatbot_id');
    }
}
