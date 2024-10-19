<?php

namespace App\Models;

class Advertiser extends Model
{
    protected $fillable = [
        'company_name',
        'corporate_email',
        'phone_number',
        'company_address',
        'cnpj',
    ];

    public $timestamps = true;

    // estabelece o relacionamento de pertencimento a users através do user_id da tabela advertisers
    // o tipo do relacionamento será um para muitos um usuário pode ter muitos anunciantes.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
