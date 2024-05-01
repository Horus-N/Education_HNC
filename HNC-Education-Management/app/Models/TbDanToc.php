<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbDanToc extends Model
{
    use HasFactory;

    protected $table = 'tb_dan_toc';
    protected $visible = ['id','MaDanToc', 'TenDanToc'];
    protected $guarded = [];

}
