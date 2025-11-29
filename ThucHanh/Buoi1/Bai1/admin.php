<?php
// admin.php
require_once 'functions.php';

$flowers = load_flowers();
$msg = '';

$action = $_GET['action'] ?? null;

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $id = next_id($flowers);
    $image = handle_image_upload('image');
    $flowers[] = ['id'=>$id, 'name'=>$name, 'description'=>$desc, 'image'=>$image];
    save_flowers($flowers);
    $msg = "Đã thêm: $name";
    // reload
    header("Location: admin.php?msg=" . urlencode($msg));
    exit;
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    foreach ($flowers as &$f) {
        if ($f['id'] == $id) {
            $f['name'] = trim($_POST['name'] ?? $f['name']);
            $f['description'] = trim($_POST['description'] ?? $f['description']);
            $f['image'] = handle_image_upload('image', $f['image']);
            break;
        }
    }
    save_flowers($flowers);
    $msg = "Đã cập nhật";
    header("Location: admin.php?msg=" . urlencode($msg));
    exit;
}

// DELETE
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($flowers as $k => $f) {
        if ($f['id'] == $id) {
            // optionally delete image file
            // if (!empty($f['image']) && file_exists('images/'.$f['image'])) unlink('images/'.$f['image']);
            unset($flowers[$k]);
            break;
        }
    }
    save_flowers($flowers);
    header("Location: admin.php?msg=" . urlencode("Đã xóa"));
    exit;
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Quản trị - Danh sách hoa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    table img { max-height:80px; }
  </style>
</head>
<body>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản trị danh sách hoa</h2>
    <a href="index.php" class="btn btn-secondary btn-sm">Xem trang khách</a>
  </div>

  <?php if ($msg): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($msg); ?></div>
  <?php endif; ?>

  <!-- Table -->
  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Ảnh</th>
        <th>Tên</th>
        <th>Mô tả</th>
        <th style="width:170px">Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($flowers as $f): ?>
      <tr>
        <td><?php echo $f['id']; ?></td>
        <td>
          <?php if (!empty($f['image']) && file_exists('images/' . $f['image'])): ?>
            <img src="<?php echo 'images/' . htmlspecialchars($f['image']); ?>" alt="" class="img-thumbnail">
          <?php endif; ?>
        </td>
        <td><?php echo htmlspecialchars($f['name']); ?></td>
        <td style="max-width:400px"><?php echo nl2br(htmlspecialchars($f['description'])); ?></td>
        <td>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $f['id']; ?>">Sửa</button>
          <a href="admin.php?action=delete&id=<?php echo $f['id']; ?>" onclick="return confirm('Xác nhận xóa?')" class="btn btn-sm btn-danger">Xóa</a>
        </td>
      </tr>

      <!-- Edit modal -->
      <div class="modal fade" id="editModal<?php echo $f['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="post" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
            <div class="modal-header">
              <h5 class="modal-title">Sửa: <?php echo htmlspecialchars($f['name']); ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-2">
                <label class="form-label">Tên</label>
                <input name="name" class="form-control" value="<?php echo htmlspecialchars($f['name']); ?>" required>
              </div>
              <div class="mb-2">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($f['description']); ?></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label">Thay ảnh (nếu muốn)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Hủy</button>
              <button class="btn btn-primary" type="submit">Lưu</button>
            </div>
          </form>
        </div>
      </div>

      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add new -->
  <h4>Thêm hoa mới</h4>
  <form method="post" enctype="multipart/form-data" class="mb-5">
    <input type="hidden" name="action" value="create">
    <div class="mb-2">
      <label class="form-label">Tên</label>
      <input name="name" class="form-control" required>
    </div>
    <div class="mb-2">
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="mb-2">
      <label class="form-label">Ảnh</label>
      <input type="file" name="image" accept="image/*" class="form-control" required>
    </div>
    <button class="btn btn-success">Thêm</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
