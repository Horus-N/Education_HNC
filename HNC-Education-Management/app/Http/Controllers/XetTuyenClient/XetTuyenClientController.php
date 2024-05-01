<?php

namespace App\Http\Controllers\XetTuyenClient;

use App\Http\Controllers\Controller;
use App\Models\TbHoSo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;


class XetTuyenClientController extends Controller
{
    use ValidationTrait;

    public function traCuuHoSo(Request $request)
    {

        $id = $request->input('VALUES');
        $result = TbHoSo::with(['xetTuyen', 'minhChung'])
            ->where('CCCD', $id)
            ->orWhere('SDT', $id)
            ->orWhere('Email', $id)
            ->orWhere('MaHoSo', $id)
            ->first();

        if (!$result) {
            return response()->json(['message' => 'Không tìm thấy hồ sơ'], 404);
        }
        $result->minhChung->BangKQ12 = json_decode($result->minhChung->BangKQ12);

        return response()->json(['data' => $result], 200);
    }


    public function nopHoSoXetTuyenClient(Request $request)
    {
        try {
            $this->validateHoSo($request);

            $hoSo = TbHoSo::create($request->all());
            $hoSo->save();

            if ($hoSo) {
                $xetTuyenData = [
                    'HoSo_ID' => $hoSo->id,
                    'HinhThuc' => $request->input('HinhThuc'),
                    'DiemMon1' => $request->input('DiemMon1'),
                    'DiemMon2' => $request->input('DiemMon2'),
                    'DiemMon3' => $request->input('DiemMon3'),
                ];

                // Xử lý và lưu trữ các hình ảnh từ yêu cầu gửi
                /**
                 * Sau này có thể lưu dữ liệu trên S3 https://youtu.be/xZQM9q_QxMA?si=Jai6sZOsIFpxbepf && https://youtu.be/9kMkMcOPL6k?si=p1ps-_bBYlshBmSH
                 * env('APP_URL') đảm bảo có dạng là APP_URL=http://localhost:8000/ và có thể thay đổi http://localhost:8000/ theo đường dẫn trang web khi deploy
                 * đảm bảo đã chạy dòng lệnh php artisan storage:link
                 * INFO  The [C:\Users\LeeNam\Desktop\HNC-Education-Management\public\storage] link has been connected to [C:\Users\LeeNam\Desktop\HNC-Education-Management\storage\app/public].
                 */

                // Start of Selection

                // Xử lý và lưu trữ các hình ảnh từ yêu cầu gửi
                $imagePaths = [];
                $SDT = $hoSo->SDT;

                // Process and store the images from the request
                foreach ($request->file('BangKQ12', []) as $image) {
                    $path = $image->store("images/{$SDT}/BangKQ12", "public");
                    $imagePaths[] = env('APP_URL') . 'storage/' . $path;
                }

                $HocBaBiaPath = $request->file('HocBaBia') ? $request->file('HocBaBia')->store("images/{$SDT}/HocBaBia", "public") : null;
                $ChungNhanTNPath = $request->file('ChungNhanTN') ? $request->file('ChungNhanTN')->store("images/{$SDT}/ChungNhanTN", "public") : null;
                $ChungNhanUTPath = $request->file('ChungNhanUT') ? $request->file('ChungNhanUT')->store("images/{$SDT}/ChungNhanUT", "public") : null;

                // Convert image paths to JSON
                $imagePathsJson = json_encode($imagePaths);

                // Save the image paths to the database as JSON
                $minhChungData = [
                    'HoSo_ID' => $hoSo->id,
                    'BangKQ12' => $imagePathsJson,
                    'HocBaBia' => $HocBaBiaPath ? env('APP_URL') . 'storage/' . $HocBaBiaPath : null,
                    'ChungNhanTN' => $ChungNhanTNPath ? env('APP_URL') . 'storage/' . $ChungNhanTNPath : null,
                    'ChungNhanUT' => $ChungNhanUTPath ? env('APP_URL') . 'storage/' . $ChungNhanUTPath : null,
                ];

                $hoSo->xetTuyen()->create($xetTuyenData);
                $hoSo->minhChung()->create($minhChungData);

                return response()->json([
                    'success' => true,
                    'code' => $hoSo['MaHoSo']
                ], 201);
            }

            return response()->json(['message' => 'Từ chối truy cập'], 403);
        } catch (ValidationException $e) {

            $errors = $e->validator->errors();

            $flattenedErrors = [];
            foreach ($errors->getMessages() as $field => $messages) {
                $flattenedErrors[$field] = $messages[0];
            }

            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $flattenedErrors
            ], 422);
        }
    }
}
