<?php

namespace App\Models;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'cpf',
        'address',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // mapeamento inverso da relação advertiser -> user
    // aqui especificamos que um usuário pode ter vários
    // advertisers. esse relacionamento usa o atributo
    // user_id da tabela advertisers
    public function advertisers()
    {
        return $this->hasMany(Advertiser::class, 'user_id');
    }
}
