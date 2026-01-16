<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    use HasFactory;

    // टेबलचे नाव
    protected $table = 'article_views';

    // हे फिल्ड्स डेटाबेसमध्ये सेव्ह करण्याची परवानगी द्या
    protected $fillable = [
        'article_id',
        'user_id',
        'ip_address',
        'country',          // लोकेशन (Map साठी)
        'user_agent',       // लॅपटॉप/मोबाईल माहिती
        'duration_seconds', // वाचलेला वेळ (Reads साठी)
        'viewed_at'         // कधी पाहिले?
    ];

    // जर तुमच्या टेबलमध्ये 'updated_at' नसेल तर हे false ठेवा
    // (Analytics टेबलमध्ये सहसा आपण डेटा अपडेट करत नाही, फक्त insert करतो)
    public $timestamps = false;

    // तारखेचे कॉलम सांगणे (Date Casting)
    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /* ==========================
       Relationships
       ========================== */

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}