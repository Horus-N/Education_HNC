<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbHanhChinhQuanHuyen extends Model
{
    use HasFactory;

    protected $table = 'tb_hanh_chinh_quan_huyen';

    protected $guarded = [];

    public function hanhChinhTinh()
    {
        return $this->belongsTo(TbHanhChinhTinh::class,'idTinh');
    }

    public function hanhChinhPhuongXa()
    {
        return $this->hasMany(TbHanhChinhPhuongXa::class,'id');
    }
}
