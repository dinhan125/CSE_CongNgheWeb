<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Computer;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Hiển thị danh sách có phân trang (10 bản ghi/trang)
     */
    public function index()
    {
        // Eager loading 'computer' để lấy thông tin máy tính tránh lỗi N+1 query
        $issues = Issue::with('computer')->paginate(10);
        return view('issues.index', compact('issues'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        $computers = Computer::all(); // Lấy danh sách máy tính để chọn
        return view('issues.create', compact('computers'));
    }

    /**
     * Lưu dữ liệu mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'computer_id' => 'required',
            'reported_by' => 'max:50',
            'reported_date' => 'required|date',
            'description' => 'required',
            'urgency' => 'required',
            'status' => 'required',
        ]);

        Issue::create($request->all());

        return redirect()->route('issues.index')->with('success', 'Thêm vấn đề thành công!');
    }

    /**
     * Form cập nhật
     */
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $computers = Computer::all();
        return view('issues.edit', compact('issue', 'computers'));
    }

    /**
     * Xử lý cập nhật
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'computer_id' => 'required',
            'reported_date' => 'required|date',
            'description' => 'required',
            'urgency' => 'required',
            'status' => 'required',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update($request->all());

        return redirect()->route('issues.index')->with('success', 'Cập nhật vấn đề thành công!');
    }

    /**
     * Xóa bản ghi
     */
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return redirect()->route('issues.index')->with('success', 'Đã xóa vấn đề thành công!');
    }
}
