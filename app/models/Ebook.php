<?php

namespace App\Models;

class Ebook extends Model
{
    protected $fillable = [
        'category',
        'author',
        'age',
        'title',
        'target_audience',
        'description',
        'cover',
        'quantity_ebook',
        'price',

    ];

    public $timestamps = true;

    // estabelece o relacionamento de pertencimento a users através do user_id da tabela advertisers
    // o tipo do relacionamento será um para muitos um usuário pode ter muitos anunciantes.
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class, 'advertiser_id', 'id');
    }
}
