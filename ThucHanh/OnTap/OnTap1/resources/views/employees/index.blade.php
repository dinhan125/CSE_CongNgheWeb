<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Quản lý Nhân viên</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Thêm nhân viên mới</a>

        <form action="{{ route('employees.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm tên hoặc email..." value="{{ $search }}">
            <button type="submit" class="btn btn-outline-success">Tìm</button>
        </form>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã NV</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>SĐT</th> <th>Phòng ban</th>
                <th>Chức vụ</th>
                <th>Lương</th> <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            <tr>
                <td>{{ $emp->id }}</td>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->phone }}</td> <td>{{ $emp->department->name }}</td>
                <td>
                    <span class="badge {{ $emp->position == 'Manager' ? 'text-bg-warning' : 'text-bg-info' }}">
                        {{ $emp->position }}
                    </span>
                </td>
                <td>
                    {{ number_format($emp->salary) }} VNĐ
                </td> 
                <td>
                    <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                    <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-5') }}
    </div>
</div>
</body>
</html>