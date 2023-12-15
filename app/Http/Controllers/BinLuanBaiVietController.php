<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use App\Models\BinhLuanBaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinLuanBaiVietController extends Controller
{
    public function getDanhSach()
    {
        $binhluanbaiviet = BinhLuanBaiViet::orderBy('created_at', 'desc')->get();
        return view('admin.binhluanbaiviet.danhsach', compact('binhluanbaiviet'));
    }

    public function getThem()
    {
        $baiviet = BaiViet::orderBy('created_at', 'desc')->get();
        return view('admin.binhluanbaiviet.them', compact('baiviet'));
    }

    public function postThem(Request $request)
    {
        // Kiểm tra
        $request->validate([
        'baiviet_id' => ['required', 'integer'],
        'noidungbinhluan' => ['required', 'string', 'min:20'],
        ]);

        $orm = new BinhLuanBaiViet();
        $orm->baiviet_id = $request->baiviet_id;
        $orm->user_id = Auth::user()->id;
        $orm->noidungbinhluan = $request->noidungbinhluan;
        $orm->save();

        // Sau khi thêm thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getSua($id)
    {
        $baiviet = BaiViet::orderBy('created_at', 'desc')->get();
        $binhluanbaiviet = BinhLuanBaiViet::find($id);
        return view('admin.binhluanbaiviet.sua', compact('baiviet', 'binhluanbaiviet'));
    }

    public function postSua(Request $request, $id)
    {
        // Kiểm tra
        $request->validate([
        'baiviet_id' => ['required', 'integer'],
        'noidungbinhluan' => ['required', 'string', 'min:20'],
        ]);

        $orm = BinhLuanBaiViet::find($id);
        $orm->baiviet_id = $request->baiviet_id;
        $orm->noidungbinhluan = $request->noidungbinhluan;
        $orm->save();

        // Sau khi sửa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getXoa($id)
    {
        $orm = BinhLuanBaiViet::find($id);
        $orm->delete();

        // Sau khi xóa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getKiemDuyet($id)
    {
        $orm = BinhLuanBaiViet::find($id);
        $orm->kiemduyet = 1 - $orm->kiemduyet;
        $orm->save();

        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getKichHoat($id)
    {
        $orm = BinhLuanBaiViet::find($id);
        $orm->kichhoat = 1 - $orm->kichhoat;
        $orm->save();

        return redirect()->route('admin.binhluanbaiviet');
    }

}
