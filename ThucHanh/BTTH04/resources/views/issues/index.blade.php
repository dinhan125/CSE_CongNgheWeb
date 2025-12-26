<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sự cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Danh sách sự cố máy tính</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('issues.create') }}" class="btn btn-primary">Thêm sự cố mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mã vấn đề</th>
                <th>Tên máy tính</th>
                <th>Tên phiên bản</th>
                <th>Người báo cáo</th>
                <th>Thời gian báo cáo</th>
                <th>Mức độ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($issues as $issue)
            <tr>
                <td>{{ $issue->id }}</td>
                <td>{{ $issue->computer->computer_name }}</td>
                <td>{{ $issue->computer->model }}</td>
                <td>{{ $issue->reported_by }}</td>
                <td>{{ $issue->reported_date }}</td>
                <td>
                    <span class="badge 
                        @if($issue->urgency == 'High') bg-danger 
                        @elseif($issue->urgency == 'Medium') bg-warning 
                        @else bg-info @endif">
                        {{ $issue->urgency }}
                    </span>
                </td>
                <td>{{ $issue->status }}</td>
                <td>
                    <a href="{{ route('issues.edit', $issue->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    
                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vấn đề này không?')">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $issues->links() }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>