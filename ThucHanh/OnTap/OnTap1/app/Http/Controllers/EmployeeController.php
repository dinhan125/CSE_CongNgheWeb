<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource. (Trang chủ - Dashboard)
     */
    public function index(Request $request)
    {
        // MVC Flow: Controller nhận request tìm kiếm (nếu có)
        $search = $request->input('search');

        // MVC Flow: Gọi Model để lấy dữ liệu.
        // with('department'): Kỹ thuật Eager Loading để lấy tên phòng ban tránh n+1 query [cite: 36]
        $query = Employee::with('department');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%"); // [cite: 42]
        }

        // Phân trang 10 bản ghi [cite: 40]
        $employees = $query->paginate(10);

        // MVC Flow: Trả dữ liệu về View 'employees.index'
        return view('employees.index', compact('employees', 'search'));
    }

    /**
     * Show the form for creating a new resource. (Form thêm mới)
     */
    public function create()
    {
        // MVC Flow: Cần lấy danh sách phòng ban để hiển thị trong dropdown [cite: 48]
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage. (Lưu dữ liệu)
     */
    public function store(Request $request)
    {
        // MVC Flow: Validate dữ liệu đầu vào [cite: 51]
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email', // Format email và duy nhất [cite: 52, 54]
            'department_id' => 'required',
            'position' => 'required',
            'salary' => 'numeric'
        ]);

        // MVC Flow: Gọi Model để tạo bản ghi mới
        Employee::create($request->all());

        // MVC Flow: Điều hướng lại về trang danh sách kèm thông báo [cite: 55]
        return redirect()->route('employees.index')
                         ->with('success', 'Thêm nhân viên thành công!');
    }

    /**
     * Show the form for editing the specified resource. (Form sửa)
     */
    public function edit(string $id)
    {
        // MVC Flow: Lấy nhân viên cần sửa và danh sách phòng ban
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage. (Cập nhật dữ liệu)
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        // Validate (Lưu ý: email unique ngoại trừ chính id đang sửa)
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$id,
            'department_id' => 'required',
            'salary' => 'numeric'
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Cập nhật thông tin nhân viên thành công!'); // [cite: 59]
    }

    /**
     * Remove the specified resource from storage. (Xóa)
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete(); // [cite: 64]

        return redirect()->route('employees.index')
                         ->with('success', 'Xóa nhân viên thành công!'); // [cite: 65]
    }
}
