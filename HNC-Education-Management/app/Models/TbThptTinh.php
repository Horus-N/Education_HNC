<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbThptTinh extends Model
{
    use HasFactory;

    protected $table = 'tb_thpt_tinh';

    protected $guarded = [];

    public function thptQuanHuyen(){
        return $this->hasMany(TbThptQuanHuyen::class);
    }

    public function thptTruong(){
        return $this->hasManyThrough(TbThptTruong::class,TbThptQuanHuyen::class,'idTinh','idQuanHuyen');
    }
}
