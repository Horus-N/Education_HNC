<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TbHoSo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_hoso';

    protected $fillable = [
        'MaHoSo', 'HoDem', 'Ten', 'NgayThangNamSinh',
        'GioiTinh', 'DanToc', 'CCCD', 'HKTT', 'MaTinh', 'MaQuanHuyen', 'MaPhuongXa', 'MaTinhTruong', 'MaQuanHuyenTruong',
        'TenTruong', 'NamTotNghiep', 'Email', 'SDT', 'DoiTuongUT', 'KhuVucUT', 'DiaChi',
        'NgayNop', 'Nganh_ID'
    ];

    // protected $guarded = [];

    public function xetTuyen()
    {
        return $this->hasOne(TbXetTuyen::class, 'HoSo_ID');
    }

    public function minhChung()
    {
        return $this->hasOne(TbMinhChung::class, 'HoSo_ID');
    }

    public function hoSoTsCanBo()
    {
        return $this->hasOne(TbCanBoTSHoSo::class, 'HoSo_ID');
    }

    public function nganh()
    {
        return $this->belongsTo(TbNganh::class, 'Nganh_ID');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->NgayNop = now()->setTimezone('Asia/Ho_Chi_Minh');

            // Tạo mã hồ sơ theo định dạng aabbcccc
            $namTuyenSinh = date('y');
            $maNganh = TbNganh::find($model->Nganh_ID)->MaNganh;

            $soThuTuHoSo = static::getUniqueSoThuTuHoSo($namTuyenSinh, $maNganh);

            $model->MaHoSo = sprintf('%02d%s%04d', $namTuyenSinh, $maNganh, $soThuTuHoSo);
        });
    }
    protected static function getUniqueSoThuTuHoSo($namTuyenSinh, $maNganh)
    {
        $soThuTuHoSo = 0;

        while (static::where('MaHoSo', '=', sprintf('%02d%s%04d', $namTuyenSinh, $maNganh, $soThuTuHoSo))->exists()) {
            $soThuTuHoSo++;
        }

        return $soThuTuHoSo;
    }
}
