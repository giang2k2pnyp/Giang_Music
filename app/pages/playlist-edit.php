<?php
require_once __DIR__ . '/../core/init.php';

$id = $_GET['id'] ?? 0;
$id = (int)$id;

$playlist = get_playlist_info($id);

// Kiểm tra quyền chỉnh sửa
if (!$playlist || !logged_in() || ($playlist['create_by'] != user('id') && !is_admin())) {
    message("Bạn không có quyền chỉnh sửa playlist này!");
    redirect('profile');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($name)) {
        $errors['name'] = "Tên playlist không được để trống.";
    }

    if (empty($errors)) {
        if (update_playlist($id, $name, $description)) {
            message("Playlist đã được cập nhật thành công!");
            redirect('playlist/' . $id);
        } else {
            $errors['general'] = "Có lỗi xảy ra khi cập nhật. Vui lòng thử lại.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa Playlist - <?=esc($playlist['name_list'])?></title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css">
    <style>
        /* CSS mới thêm vào */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
        }
        
        .form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .error {
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php require page('includes/header')?>
    
    <div class="container">
        <h1>Chỉnh sửa Playlist</h1>
        
        <?php if(!empty($errors['general'])): ?>
            <div class="error"><?=$errors['general']?></div>
        <?php endif; ?>
        
        <form method="post" class="form">
            <div class="form-group">
                <label for="name">Tên playlist:</label>
                <input type="text" id="name" name="name" value="<?=esc($playlist['name_list'])?>" required>
                <?php if(!empty($errors['name'])): ?>
                    <div class="error"><?=$errors['name']?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4"><?=esc($playlist['description'])?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">Lưu thay đổi</button>
                <a href="<?=ROOT?>/playlist/<?=$id?>" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
    
<?php require page('includes/footer')?>
</body>
</html>