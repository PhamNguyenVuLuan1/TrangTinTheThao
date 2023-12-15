<?php

namespace App\Http\Controllers;

use App\Models\ChuDe;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BaiVietController extends Controller
{
    public function getDanhSach()
    {
        $baiviet = BaiViet::orderBy('created_at', 'desc')->get();
        return view('admin.baiviet.danhsach', compact('baiviet'));
    }

    public function getThem()
    {
        $chude = ChuDe::all();
        return view('admin.baiviet.them', compact('chude'));
    }

    public function postThem(Request $request)
    {
        // Kiểm tra
        $request->validate([
        'chude_id' => ['required', 'integer'],
        'tieude' => ['required', 'string', 'max:300', 'unique:baiviet'],
        'noidung' => ['required', 'string', 'min:20'],
        ]);

        $orm = new BaiViet();
        $orm->chude_id = $request->chude_id;
        $orm->user_id = Auth::user()->id;
        $orm->tieude = $request->tieude;
        $orm->tieude_slug = Str::slug($request->tieude, '-');
        if(!empty($request->tomtat)) $orm->tomtat = $request->tomtat;
        $orm->noidung = $request->noidung;
        $orm->save();

        // Sau khi thêm thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.baiviet');
    }

    public function getSua($id)
    {
        $chude = ChuDe::all();
        $baiviet = BaiViet::find($id);
        return view('admin.baiviet.sua', compact('chude', 'baiviet'));
    }

    public function postSua(Request $request, $id)
    {
        // Kiểm tra
        $request->validate([
        'chude_id' => ['required', 'integer'],
        'tieude' => ['required', 'string', 'max:300', 'unique:baiviet,tieude,' . $id],
        'noidung' => ['required', 'string', 'min:20'],
        ]);

        $orm = BaiViet::find($id);
        $orm->chude_id = $request->chude_id;
        $orm->tieude = $request->tieude;
        $orm->tieude_slug = Str::slug($request->tieude, '-');
        $orm->tomtat = $request->tomtat;
        $orm->noidung = $request->noidung;
        $orm->save();

        // Sau khi sửa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.baiviet');
    }

    public function getXoa($id)
    {
        $orm = BaiViet::find($id);
        $orm->delete();

        // Sau khi xóa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.baiviet');
    }

    public function getKiemDuyet($id)
    {
        $orm = BaiViet::find($id);
        $orm->kiemduyet = 1 - $orm->kiemduyet;
        $orm->save();

        return redirect()->route('admin.baiviet');
    }

    public function getKichHoat($id)
    {
        $orm = BaiViet::find($id);
        $orm->kichhoat = 1 - $orm->kichhoat;
        $orm->save();

        return redirect()->route('admin.baiviet');
    }
}
