<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbHanhChinhPhuongXa extends Model
{
    use HasFactory;

    protected $table = 'tb_hanh_chinh_phuong_xa';

    protected $guarded = [];

    public function hanhChinhQuanHuyen(){
        return $this->belongsTo(TbHanhChinhQuanHuyen::class,'idQuanHuyen');
    }

    public function hanhChinhTinh(){
        return $this->belongsTo(TbHanhChinhTinh::class,'idTinh');
    }
}
