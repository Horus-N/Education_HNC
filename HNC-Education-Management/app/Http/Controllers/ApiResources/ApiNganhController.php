<?php

namespace App\Http\Controllers\ApiResources;

use App\Http\Controllers\Controller;
use App\Models\TbNganh;
use Illuminate\Http\Request;

class ApiNganhController extends Controller
{
    public function getNganh()
    {
        try {
            $data = TbNganh::all();
            return response()->json([
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Đã xảy ra lỗi'], 500);
        }
    }
}

