<?php
// index.php
require_once 'functions.php';
$flowers = load_flowers();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Loại hoa tuyệt đẹp - Xuân Hè</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .flower-card img { max-height:200px; object-fit:cover; width:100%; }
    .hero { padding:2rem 0; }
  </style>
</head>
<body>
    
<div class="container">
  <header class="hero text-center">
    <h1>4 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</h1>
    <p class="text-muted">Bộ sưu tập gợi ý cho sân vườn, ban công và chậu hoa của bạn.</p>
    <a href="admin.php" class="btn btn-outline-primary btn-sm">Đăng nhập quản trị (demo)</a>
  </header>

  <div class="row">
    <?php foreach($flowers as $f): ?>
      <article class="col-md-6 mb-4">
        <div class="card flower-card">

          <?php 
            $imagePath = '../src/images/' . $f['image'];
          ?>

          <?php if (!empty($f['image']) && file_exists($imagePath)): ?>
            <img src="<?php echo $imagePath; ?>" 
                 class="card-img-top" 
                 alt="<?php echo htmlspecialchars($f['name']); ?>">
                 
          <?php endif; ?>
            
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($f['name']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($f['description'])); ?></p>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <footer class="text-center my-4 text-muted">
    Bản demo — bạn có thể mở <strong>admin.php</strong> để quản lý danh sách.
  </footer>
</div>
</body>
</html>