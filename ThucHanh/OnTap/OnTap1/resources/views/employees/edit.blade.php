<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Cập nhật thông tin nhân viên</h4>
                    </div>
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="mb-3">
                                <label for="name" class="form-label">Tên nhân viên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $employee->name) }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $employee->email) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $employee->phone) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="department_id" class="form-label">Phòng ban <span class="text-danger">*</span></label>
                                <select class="form-select" id="department_id" name="department_id" required>
                                    <option value="">-- Chọn phòng ban --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" 
                                            {{-- Kiểm tra: Nếu ID phòng ban của NV trùng với ID trong vòng lặp thì chọn --}}
                                            {{ (old('department_id', $employee->department_id) == $dept->id) ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">Chức vụ</label>
                                    <select class="form-select" id="position" name="position" required>
                                        <option value="Staff" {{ (old('position', $employee->position) == 'Staff') ? 'selected' : '' }}>Staff</option>
                                        <option value="Manager" {{ (old('position', $employee->position) == 'Manager') ? 'selected' : '' }}>Manager</option>
                                        <option value="VP" {{ (old('position', $employee->position) == 'VP') ? 'selected' : '' }}>VP</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="salary" class="form-label">Lương</label>
                                    <input type="number" step="0.01" class="form-control" id="salary" name="salary" 
                                           value="{{ old('salary', $employee->salary) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                                <button type="submit" class="btn btn-warning">Cập nhật thông tin</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>