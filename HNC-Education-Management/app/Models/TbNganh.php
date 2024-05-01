<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNganh extends Model
{
    use HasFactory;

    protected $table = 'tb_nganh';

    protected $fillable = ['MaNganh', 'TenNganh', 'GhiChu'];

    protected $visible = ['id', 'MaNganh', 'TenNganh'];
    public function hoSo()
    {
        return $this->hasMany(TbHoSo::class);
    }
}
