<?php

namespace App\Http\Controllers\ApiResources;

use App\Http\Controllers\Controller;
use App\Models\TbDanToc;

class ApiDanTocController extends Controller
{
    public function getDanToc()
    {
        try {
            $data = TbDanToc::all();
            return response()->json([
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi'], 500);
        }
    }
}
