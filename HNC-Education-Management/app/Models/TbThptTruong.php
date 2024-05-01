<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbThptTruong extends Model
{
    use HasFactory;

    protected $table = 'tb_thpt_truong';

    protected $guarded = [];

    public function thptTinh(){
        return $this->belongsTo(TbThptTinh::class);
    }

    public function thptQuanHuyen(){
        return $this->belongsTo(TbThptQuanHuyen::class);
    }
}
