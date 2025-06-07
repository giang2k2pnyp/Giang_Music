<?php
// Lấy ID playlist từ URL
$playlist_id = $_GET['id'] ?? 0;

if (empty($playlist_id)) {
    redirect('');
}

// Lấy thông tin playlist
$playlist = get_playlist_info($playlist_id);
if (!$playlist) {
    message("Không tìm thấy danh sách phát!");
    redirect('');
}

// Kiểm tra quyền chỉnh sửa
$can_edit = logged_in() && (is_admin() || user('id') == $playlist['create_by']);

// Xử lý các hành động với playlist
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$can_edit) {
        message("Bạn không có quyền chỉnh sửa danh sách này!");
        redirect("playlist?id=" . $playlist_id);
    }

    // Xóa bài hát khỏi playlist
    if (!empty($_POST['remove_song'])) {
        $song_id = (int)$_POST['song_id'];
        if (remove_song_from_playlist($playlist_id, $song_id)) {
            message("Đã xóa bài hát khỏi danh sách!");
        } else {
            message("Có lỗi khi xóa bài hát!");
        }
        redirect("playlist?id=" . $playlist_id);
    }

    // Cập nhật thông tin playlist
    if (!empty($_POST['update_playlist'])) {
        $name = trim($_POST['playlist_name']);
        $description = trim($_POST['playlist_description']);
        
        if (!empty($name)) {
            if (update_playlist($playlist_id, $name, $description)) {
                message("Cập nhật danh sách thành công!");
            } else {
                message("Lỗi khi cập nhật danh sách!");
            }
        } else {
            message("Vui lòng nhập tên danh sách!");
        }
        redirect("playlist?id=" . $playlist_id);
    }

    // Xóa toàn bộ playlist
    if (!empty($_POST['delete_playlist'])) {
        if (delete_playlist($playlist_id)) {
            message("Đã xóa danh sách phát!");
            redirect('');
        } else {
            message("Lỗi khi xóa danh sách!");
            redirect("playlist?id=" . $playlist_id);
        }
    }
}

// Xử lý xóa bài hát khỏi playlist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['remove_song'])) {
    if (logged_in() && (is_admin() || user('username') == $playlist['create_by'])) {
        $song_id = $_POST['song_id'];
        if (remove_song_from_playlist($playlist_id, $song_id)) {
            message("Đã xóa bài hát khỏi danh sách!");
        } else {
            message("Có lỗi khi xóa bài hát!");
        }
        redirect("playlist?id=" . $playlist_id);
    }
}

// Lấy các bài hát trong playlist
$songs = get_playlist_songs($playlist_id);
$song_count = count_playlist_songs($playlist_id);
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    <!-- Header playlist -->
    <div class="playlist-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                        color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <img src="<?=ROOT?>/<?=$playlist['image']?>" alt="<?=esc($playlist['name_list'])?>" 
                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <h1 style="margin: 0; font-size: 2.5em;"><?=esc($playlist['name_list'])?></h1>
                    <?php if($can_edit): ?>
                        <div class="playlist-actions">
                            <button class="btn bg-blue" onclick="showEditModal()">Chỉnh sửa</button>
                            <form method="post" style="display: inline;" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ danh sách này?')">
                                <button type="submit" name="delete_playlist" class="btn bg-red">Xóa danh sách</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <p style="margin: 10px 0; opacity: 0.9;">Tạo bởi: <?=esc($playlist['username'] ?? $playlist['create_by'])?></p>
                <p style="margin: 5px 0; opacity: 0.8;"><?=$song_count?> bài hát • <?=get_date($playlist['date_create'])?></p>
                <?php if(!empty($playlist['description'])): ?>
                    <p style="margin: 15px 0; opacity: 0.9;"><?=esc($playlist['description'])?></p>
                <?php endif; ?>
                <?php if(!empty($songs)): ?>
                    <div class="play-controls" style="margin-top: 20px;">
                        <button class="btn bg-green" style="padding: 10px 20px;" onclick="playAll()">
                            ▶ Phát tất cả
                        </button>
                        <button class="btn bg-purple" style="padding: 10px 20px; margin-left: 10px;" onclick="shufflePlay()">
                            🔀 Phát ngẫu nhiên
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(empty($songs)): ?>
        <div class="empty-playlist" style="text-align: center; padding: 50px; color: #666;">
            <h3>Danh sách phát trống</h3>
            <p>Chưa có bài hát nào trong danh sách này.</p>
            <a href="<?=ROOT?>/" class="btn bg-purple">Khám phá nhạc</a>
        </div>
    <?php else: ?>
        <!-- Danh sách bài hát -->
        <div class="songs-list">
            <div class="list-header" style="display: grid; grid-template-columns: 50px 1fr 200px 100px 150px 100px; gap: 15px; padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: #666;">
                <div>#</div>
                <div>Bài hát</div>
                <div>Nghệ sĩ</div>
                <div>Lượt nghe</div>
                <div>Ngày thêm</div>
                <div>Hành động</div>
            </div>

            <?php $index = 1; foreach($songs as $song): ?>
                <div class="song-item" style="display: grid; grid-template-columns: 50px 1fr 200px 100px 150px 100px; gap: 15px; padding: 15px; border-bottom: 1px solid #f5f5f5; align-items: center; transition: background 0.3s;"
                     onmouseover="this.style.background='#f9f9f9'" 
                     onmouseout="this.style.background='white'">
                    
                    <div class="track-number"><?=$index?></div>
                    
                    <div class="song-info" style="display: flex; align-items: center; gap: 15px;">
                        <img src="<?=ROOT?>/<?=$song['image']?>" alt="<?=esc($song['title'])?>" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        <div>
                            <div style="font-weight: bold; margin-bottom: 5px;">
                                <a href="<?=ROOT?>/song/<?=$song['slug']?>" style="text-decoration: none; color: #333;">
                                    <?=esc($song['title'])?>
                                </a>
                            </div>
                            <div style="font-size: 0.9em; color: #666;">
                                <?=esc(get_category($song['category_id']))?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="artist-name"><?=esc($song['artist_name'])?></div>
                    <div class="views"><?=number_format($song['views'])?></div>
                    <div class="date-added"><?=get_date($song['date_added'])?></div>
                    
                    <div class="actions">
                        <a href="<?=ROOT?>/song/<?=$song['slug']?>" class="btn-small bg-blue" style="padding: 5px 10px; font-size: 0.8em; margin-right: 5px;">Nghe</a>
                        <?php if($can_edit): ?>
                            <form method="post" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa bài hát này khỏi danh sách?')">
                                <input type="hidden" name="song_id" value="<?=$song['id']?>">
                                <button type="submit" name="remove_song" class="btn-small bg-red" style="padding: 5px 10px; font-size: 0.8em;">Xóa</button>
                            </form>
                        <?php endif; ?>
                        
                        <!-- ?php if(logged_in() && (is_admin() || user('username') == $playlist['create_by'])): ?>
                            <form method="post" style="display: inline;" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài hát này khỏi danh sách?')">
                                <input type="hidden" name="song_id" value="?=$song['id']?>">
                                <button type="submit" name="remove_song" class="btn-small bg-red" 
                                        style="padding: 5px 10px; font-size: 0.8em;">Xóa</button>
                            </form>
                        ?php endif; ?> -->
                    </div>
                </div>
                <?php $index++; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal chỉnh sửa playlist -->
<?php if($can_edit): ?>
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Chỉnh sửa danh sách phát</h3>
                <span class="close" onclick="hideEditModal()">&times;</span>
            </div>
            
            <div class="modal-body">
                <form method="POST">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tên danh sách</label>
                        <input type="text" name="playlist_name" value="<?=esc($playlist['name_list'])?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mô tả</label>
                        <textarea name="playlist_description" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 100px; resize: vertical;"><?=esc($playlist['description'])?></textarea>
                    </div>
                    
                    <button type="submit" name="update_playlist" class="btn bg-green" style="width: 100%;">
                        Lưu thay đổi
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

    <!-- Play all button -->
    <?php if(!empty($songs)): ?>
        <div class="play-controls" style="margin: 30px 0; text-align: center;">
            <button class="btn bg-green" style="padding: 15px 30px; font-size: 1.1em;" onclick="playAll()">
                ▶ Phát tất cả
            </button>
            <button class="btn bg-purple" style="padding: 15px 30px; font-size: 1.1em; margin-left: 15px;" onclick="shufflePlay()">
                🔀 Phát ngẫu nhiên
            </button>
        </div>
    <?php endif; ?>

</div>

<style>
.btn-small {
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    color: white;
    font-size: 0.8em;
}

.bg-red { background-color: #e74c3c; }
.bg-blue { background-color: #3498db; }
.bg-green { background-color: #2ecc71; }
.bg-purple { background-color: #9b59b6; }

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    overflow: auto;
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    margin: 0;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #333;
}

@media (max-width: 768px) {
    .playlist-header > div {
        flex-direction: column;
        text-align: center;
    }
    
    .playlist-header img {
        width: 120px;
        height: 120px;
    }

    .playlist-actions {
        margin-top: 15px;
    }
    
    .songs-list .list-header,
    .songs-list .song-item {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .songs-list .list-header > div:not(:first-child),
    .songs-list .song-item > div:not(.song-info) {
        display: none;
    }
    
    .song-info {
        padding: 10px 0;
    }
}
</style>

<script>
// Phát tất cả bài hát
function playAll() {
    // Mở bài hát đầu tiên
    <?php if(!empty($songs)): ?>
        window.open('<?=ROOT?>/song/<?=$songs[0]['slug']?>', '_blank');
    <?php endif; ?>
}

function shufflePlay() {
    // Chọn ngẫu nhiên một bài hát
    var songs = [
        <?php foreach($songs as $song): ?>
            '<?=$song['slug']?>',
        <?php endforeach; ?>
    ];
    
    if(songs.length > 0) {
        var randomIndex = Math.floor(Math.random() * songs.length);
        window.open('<?=ROOT?>/song/' + songs[randomIndex], '_blank');
    }
}

// Hiển thị modal chỉnh sửa
function showEditModal() {
    document.getElementById('editModal').style.display = 'block';
}

function hideEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    var modal = document.getElementById('editModal');
    if (event.target == modal) {
        hideEditModal();
    }
}

// Đóng modal khi nhấn ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideEditModal();
    }
});

// Hiển thị thông báo nếu có
<?php if(message()): ?>
    alert('<?=message(true)?>');
<?php endif; ?>
</script>