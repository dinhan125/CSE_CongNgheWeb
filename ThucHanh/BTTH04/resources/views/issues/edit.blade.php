<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sự cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Cập nhật thông tin sự cố</h1>
    <form action="{{ route('issues.update', $issue->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Máy tính</label>
            <select name="computer_id" class="form-select" required>
                @foreach($computers as $computer)
                    <option value="{{ $computer->id }}" {{ $issue->computer_id == $computer->id ? 'selected' : '' }}>
                        {{ $computer->computer_name }} ({{ $computer->model }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Người báo cáo</label>
            <input type="text" name="reported_by" class="form-control" value="{{ $issue->reported_by }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Thời gian báo cáo</label>
            <input type="datetime-local" name="reported_date" class="form-control" 
                   value="{{ date('Y-m-d\TH:i', strtotime($issue->reported_date)) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mức độ sự cố</label>
            <select name="urgency" class="form-select" required>
                <option value="Low" {{ $issue->urgency == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $issue->urgency == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $issue->urgency == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái hiện tại</label>
            <select name="status" class="form-select" required>
                <option value="Open" {{ $issue->status == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="3" required>{{ $issue->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>