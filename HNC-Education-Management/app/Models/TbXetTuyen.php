<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbXetTuyen extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_xettuyen';

    protected $visible = ['TrangThai','HinhThuc','DiemMon1','DiemMon2','DiemMon3','GhiChu'];
    
    protected $guarded = [];

    public function hoSo() {
        return $this->belongsTo(TbHoSo::class, 'HoSo_ID');
    }
}
