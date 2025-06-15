
<?php
// Xử lý xóa playlist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_playlist'])) {
    $playlist_id = (int)$_POST['playlist_id'];
    if (delete_playlist($playlist_id)) {
        message("Đã xóa playlist thành công!");
    } else {
        message("Lỗi khi xóa playlist!");
    }
    redirect('admin?section=playlist');
}

// Lấy tất cả playlist từ database
$query = "SELECT ls.*, u.username, 
          (SELECT COUNT(*) FROM playlist_songs WHERE list_id = ls.id) AS song_count 
          FROM list_song ls 
          LEFT JOIN users u ON ls.create_by = u.id 
          ORDER BY ls.date_create DESC";
$playlists = db_query($query);
?>

<?php require page('includes/admin-header')?>

<div class="container">
    <h2>Quản lý Danh sách Phát</h2>
    
    <?php if(empty($playlists)): ?>
        <p>Không có danh sách phát nào.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Người tạo</th>
                    <th>Số bài hát</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($playlists as $playlist): ?>
                    <tr>
                        <td><?=$playlist['id']?></td>
                        <td>
                            <a href="<?=ROOT?>/playlist?id=<?=$playlist['id']?>" target="_blank">
                                <?=esc($playlist['name_list'])?>
                            </a>
                        </td>
                        <td><?=esc($playlist['username'])?></td>
                        <td><?=$playlist['song_count']?></td>
                        <td><?=get_date($playlist['date_create'])?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa playlist này?');">
                                <input type="hidden" name="playlist_id" value="<?=$playlist['id']?>">
                                <button type="submit" name="delete_playlist" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require page('includes/admin-footer')?>

<style>
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background-color:rgb(83, 83, 83);
    font-weight: 600;
}

.table tr:hover {
    background-color: #f9f9f9;
}

.btn-danger {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-danger:hover {
    background-color: #c0392b;
}
</style>