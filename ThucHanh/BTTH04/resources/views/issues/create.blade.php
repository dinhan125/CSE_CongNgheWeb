<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sự cố mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Thêm sự cố mới</h1>

    <form action="{{ route('issues.store') }}" method="POST">
        @csrf <div class="mb-3">
            <label class="form-label">Máy tính</label>
            <select name="computer_id" class="form-select" required>
                @foreach($computers as $computer)
                    <option value="{{ $computer->id }}">{{ $computer->computer_name }} ({{ $computer->model }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Người báo cáo</label>
            <input type="text" name="reported_by" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Thời gian báo cáo</label>
            <input type="datetime-local" name="reported_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mức độ sự cố</label>
            <select name="urgency" class="form-select" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái hiện tại</label>
            <select name="status" class="form-select" required>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>