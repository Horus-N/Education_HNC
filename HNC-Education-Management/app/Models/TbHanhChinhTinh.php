<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbHanhChinhTinh extends Model
{
    use HasFactory;

    protected $table = 'tb_hanh_chinh_tinh';

    protected $guarded = [];

    public function hanhChinhQuanHuyen(){
        return $this->hasMany(TbHanhChinhQuanHuyen::class,'id');
    }

    public function hanhChinhPhuongXa(){
        return $this->hasManyThrough(TbHanhChinhPhuongXa::class,TbHanhChinhQuanHuyen::class,'idTinh','idQuanHuyen');
    }
}
