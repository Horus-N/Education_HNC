<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbThptQuanHuyen extends Model
{
    use HasFactory;

    protected $table = 'tb_thpt_quan_huyen';

    protected $guarded = [];

    public function thptTinh(){
        return $this->belongsTo(TbThptTinh::class);
    }

    public function thptTruong(){
        return $this->hasMany(TbThptTruong::class);
    }
}
