<link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css">
<?php 
    // Xử lý thêm vào playlist
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (logged_in()) {
            // Thêm vào playlist có sẵn
            if (isset($_POST['add_to_playlist'])) {
                $list_id = (int)$_POST['playlist_id'];
                $song_id = (int)$row['id'];
                
                if (add_song_to_playlist($list_id, $song_id)) {
                    message("Đã thêm vào danh sách!");
                } else {
                    message("Bài hát đã có trong danh sách này!");
                }
                redirect("song/" . $row['slug']);
                die();
            }
            
            // Tạo playlist mới
            if (isset($_POST['create_playlist'])) {
                $name = trim($_POST['playlist_name']);
                $description = trim($_POST['playlist_description']);

                $image_path = 'uploads/Giang_Music.jpg';

                if (!empty($_FILES['playlist_image']['name'])) {
                    // Tạo thư mục nếu chưa tồn tại
                    $folder = "uploads/playlists/";
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }
                    
                    // Xử lý tệp tải lên
                    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
                    $file_type = $_FILES['playlist_image']['type'];
                    
                    if (in_array($file_type, $allowed)) {
                        $destination = $folder . time() . $_FILES['playlist_image']['name'];
                        if (move_uploaded_file($_FILES['playlist_image']['tmp_name'], $destination)) {
                            $image_path = $destination;
                        }
                    }
                }
                
                if (!empty($name)) {
                    if ($playlist_id = create_playlist($name, $description, $image_path)) {
                        message("Tạo danh sách thành công!");
                        // Thêm bài hát hiện tại vào playlist mới
                        $song_id = (int)$row['id'];
                        add_song_to_playlist($playlist_id, $song_id);
                    } else {
                        message("Lỗi khi tạo danh sách!");
                    }
                } else {
                    message("Vui lòng nhập tên danh sách!");
                }
                redirect("song/" . $row['slug']);
                die();
            }
            redirect("song/" . $row['slug']);
        } else {
            message("Vui lòng đăng nhập!");
            redirect("login");
        }
    }

    // Lấy danh sách playlist của user
    $user_playlists = logged_in() ? get_user_playlists() : [];

	db_query("update songs set views = views + 1 where id = :id limit 1",['id'=>$row['id']]);
?>

<div class="song-full-container" style="display: flex; max-width: 1400px; margin: 0 auto; padding: 20px; gap: 20px;">
    <!-- Cột trái: Danh sách nghệ sĩ ngẫu nhiên -->
    <div class="left-column" style="flex: 0 0 250px; position: sticky; top: 20px; height: fit-content;">
        <div class="sidebar-section" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Nghệ Sĩ Ngẫu Nhiên</h3>
            <?php 
                $random_artists = db_query("SELECT * FROM artists ORDER BY RAND() LIMIT 5");
            ?>
            <?php if(!empty($random_artists)):?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($random_artists as $artist):?>
                        <li style="margin-bottom: 15px; display: flex; align-items: center;">
                            <div style="width: 40px; height: 40px; overflow: hidden; border-radius: 50%; margin-right: 10px;">
                                <img src="<?=ROOT?>/<?=$artist['image']?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <a href="<?=ROOT?>/artist/<?=$artist['id']?>" style="color: #333; text-decoration: none;">
                                <?=esc($artist['name'])?>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
        </div>
    </div>

    <!-- Cột giữa: Chi tiết bài hát -->
    <div class="center-column" style="flex: 1; min-width: 0; display: flex; justify-content: center;"> 
        <div class="music-card-full" style="width: 600px; max-width: 100%; display: flex; flex-direction: column; align-items: center;">
	        <h2 class="card-title"><?=esc($row['title'])?></h2>
	        <div class="card-subtitle">by: <?=esc(get_artist($row['artist_id']))?></div>

	        <!-- Cập nhật phần hiển thị ảnh để căn giữa -->
	        <div style="overflow: hidden; display: flex; justify-content: center; width: 100%; margin: 10px 0;">
		        <a href="<?=ROOT?>/song/<?=$row['slug']?>" style="display: block; width: 350px; max-width: 100%;">
			        <img src="<?=ROOT?>/<?=$row['image']?>" style="width: 100%; height: auto; border-radius: 8px;">
		        </a>
	        </div>
	        
	        <div class="card-content" style="width: 100%;">
		        <div class="action-buttons" style="margin: 15px 0; display: flex; justify-content: space-between;">
                    <?php 
                        $prev_song = db_query_one("SELECT slug FROM songs WHERE id != :current_id ORDER BY RAND() LIMIT 1", ['current_id' => $row['id']]);
                        $prev_song_slug = $prev_song ? $prev_song['slug'] : '';
                        
                        $next_song = db_query_one("SELECT slug FROM songs WHERE id != :current_id ORDER BY RAND() LIMIT 1", ['current_id' => $row['id']]);
                        $next_song_slug = $next_song ? $next_song['slug'] : '';
                    ?>
                    <?php if ($prev_song_slug): ?>
                        <a href="<?=ROOT?>/song/<?=$prev_song_slug?>" class="btn bg-blue" style="flex: 1; margin-right: 5px; text-align: center;">&larr;</a>
                    <?php endif; ?>
                    <audio controls style="width: 100%">
			            <source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
		            </audio>
                    <?php if ($next_song_slug): ?>
                        <a href="<?=ROOT?>/song/<?=$next_song_slug?>" class="btn bg-blue" style="flex: 1; margin-left: 5px; text-align: center;">&rarr;</a>
                    <?php endif; ?>
                </div>

                <div>Views: <?=$row['views']?></div>
                <div>Date added: <?=get_date($row['date'])?></div>

                <div class="action-buttons" style="margin: 15px 0; display: flex;">
                    <a href="<?=ROOT?>/download/<?=$row['slug']?>" style="flex: 1; margin-right: 10px;">
                        <button class="btn bg-purple" style="width: 100%;">Download</button>
                    </a>
            
                    <?php if(logged_in()): ?>
                        <button class="btn bg-green" onclick="showPlaylistModal()" style="margin-left: 10px; flex: 1;">
                            + Thêm vào danh sách
                        </button>
                    <?php else: ?>
                        <?php
                            $path_only = str_replace(parse_url(ROOT, PHP_URL_PATH), '', $_SERVER['REQUEST_URI']);
                        ?>
                        <a href="<?=ROOT?>/login?redirect=<?=urlencode($path_only)?>" style="flex: 1; margin-left: 10px;">
                            <button class="btn bg-green" style="margin-left: 10px;">
                                Đăng nhập để thêm vào danh sách
                            </button>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
	</div>

    <!-- Cột phải: Danh sách bài hát ngẫu nhiên -->
    <div class="right-column" style="flex: 0 0 250px; position: sticky; top: 20px; height: fit-content;">
        <div class="sidebar-section" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Bài Hát Ngẫu Nhiên</h3>
            <?php 
                $random_songs = db_query("SELECT * FROM songs WHERE id != :current_song_id ORDER BY RAND() LIMIT 5", ['current_song_id' => $row['id']]);
            ?>
            <?php if(!empty($random_songs)):?>
                <div style="display: grid; gap: 15px;">
                    <?php foreach($random_songs as $song):?>
                        <div class="playlist-card">
                            <a href="<?=ROOT?>/song/<?=$song['slug']?>" style="text-decoration: none; color: inherit;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 50px; height: 50px; overflow: hidden; border-radius: 4px; margin-right: 10px;">
                                        <img src="<?=ROOT?>/<?=$song['image']?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">
                                            <?=esc($song['title'])?>
                                        </div>
                                        <div style="font-size: 0.8em; color: #666;">
                                            <?=esc(get_artist($song['artist_id']))?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>


<?php if(logged_in()): ?>
<!-- Modal thêm vào playlist -->
<div id="playlistModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Thêm vào danh sách phát</h3>
            <span class="close" onclick="hidePlaylistModal()">&times;</span>
        </div>
        
        <div class="modal-body">
            <!-- Danh sách playlist hiện có -->
            <?php if(!empty($user_playlists)): ?>
                <div class="existing-playlists">
                    <h4>Chọn danh sách có sẵn:</h4>
                    <form method="POST" style="margin-bottom: 20px;">
                        <select name="playlist_id" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                            <option value="">-- Chọn danh sách phát --</option>
                            <?php foreach($user_playlists as $playlist): ?>
                                <option value="<?=$playlist['id']?>">
                                    <?=esc($playlist['name_list'])?> 
                                    <!-- (=count_playlist_songs($playlist['id'])?> bài hát) -->
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="add_to_playlist" class="btn bg-blue" style="width: 100%;">
                            Thêm vào danh sách này
                        </button>
                    </form>
                </div>
                
                <div class="divider" style="text-align: center; margin: 20px 0; position: relative;">
                    <span style="background: white; padding: 0 15px; color: #666;">HOẶC</span>
                    <hr style="position: absolute; top: 50%; left: 0; right: 0; z-index: -1;">
                </div>
            <?php endif; ?>
            
            <!-- Form tạo playlist mới -->
            <div class="create-new-playlist">
                <h4>Tạo danh sách mới:</h4>
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" 
                           name="playlist_name" 
                           placeholder="Tên danh sách phát..." 
                           required 
                           style="width: 100%; padding: 8px; margin-bottom: 10px;">
                    
                    <textarea name="playlist_description" 
                              placeholder="Mô tả (không bắt buộc)..." 
                              style="width: 100%; padding: 8px; margin-bottom: 10px; height: 60px; resize: vertical;"></textarea>
                    
                    <!-- Thêm trường tải ảnh -->
                    <div style="margin: 10px 0;">
                        <label>Ảnh playlist (nếu không chọn, sẽ lấy ảnh bài hát đầu tiên thêm vào)</label>
                        <input type="file" name="playlist_image" accept="image/*">
                    </div>

                    <button type="submit" name="create_playlist" class="btn bg-green" style="width: 100%;">
                        Tạo danh sách mới
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// JavaScript để điều khiển modal
function showPlaylistModal() {
    document.getElementById('playlistModal').style.display = 'block';
}

function hidePlaylistModal() {
    document.getElementById('playlistModal').style.display = 'none';
}

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    var modal = document.getElementById('playlistModal');
    if (event.target == modal) {
        hidePlaylistModal();
    }
}

// Đóng modal khi nhấn ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hidePlaylistModal();
    }
});
</script>