<!--start playlist card-->
<div class="music-card-full" style="max-width: 800px; display: flex; flex-direction: column; align-items: center;">
    
    <h2 class="card-title"><?=esc($playlist['name_list'])?></h2>
    <p>Tạo bởi: <?=esc($playlist['username'])?> • <?=get_date($playlist['date_create'])?></p>

    <div style="overflow: hidden; display: flex; width: 350px;">
        <img src="<?=ROOT?>/<?=$playlist['image']?>">
    </div>
    
    <div class="card-content">
        <?php if(!empty($playlist['description'])): ?>
            <div style="margin-bottom: 20px;"><?=esc($playlist['description'])?></div>
        <?php endif; ?>
        
        <div class="playlist-songs-title">Bài hát trong playlist:</div>
        <div class="playlist-songs">
            <?php 
                $query = "SELECT s.*, a.name as artist_name 
                          FROM playlist_songs ps 
                          JOIN songs s ON ps.song_id = s.id 
                          JOIN artists a ON s.artist_id = a.id 
                          WHERE ps.list_id = :list_id 
                          ORDER BY ps.date_added DESC";
                $songs = db_query($query, ['list_id' => $playlist['id']]);
            ?>

            <?php if(!empty($songs)):?>
                <?php foreach($songs as $song):?>
                    <div class="song-item">
                        <a href="<?=ROOT?>/song/<?=$song['slug']?>">
                            <img src="<?=ROOT?>/<?=$song['image']?>">
                            <div>
                                <div class="song-title"><?=esc($song['title'])?></div>
                                <div class="song-artist"><?=esc($song['artist_name'])?></div>
                            </div>
                        </a>
                        <div class="song-views"><?=number_format($song['views'])?> lượt nghe</div>
                    </div>
                <?php endforeach;?>
            <?php else:?>
                <div class="empty-songs">Chưa có bài hát nào trong danh sách này</div>
            <?php endif;?>
        </div>
        <?php if(!empty($songs)): ?>
            <button id="random-play-button" style="margin: 20px 0; padding: 10px 25px; background: #1db954; color: white; border: none; border-radius: 20px; cursor: pointer; font-weight: bold; display: flex; align-items: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" style="margin-right: 8px; fill: white;">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
                Phát ngẫu nhiên
            </button>
        <?php endif; ?>
    </div>
</div>
<!--end playlist card-->

<!-- Player cố định ở cuối màn hình -->
<!-- <div id="fixed-player" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: #222; padding: 10px; z-index: 1000; border-top: 1px solid #444;">
    <div style="max-width: 800px; margin: 0 auto; display: flex; align-items: center; gap: 15px;">
        <img id="player-thumbnail" src="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
        <div style="flex: 1;">
            <div id="player-title" style="font-weight: bold; color: white;"></div>
            <div id="player-artist" style="font-size: 0.9em; color: #aaa;"></div>
        </div>
        
        <div style="display: flex; gap: 10px; align-items: center;">
            <button id="prev-btn" style="background: #333; border: none; color: white; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                    <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"></path>
                </svg>
            </button>
            
            <audio id="player-audio" controls style="flex: 2; min-width: 200px;"></audio>
            
            <button id="next-btn" style="background: #333; border: none; color: white; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                    <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"></path>
                </svg>
            </button>
        </div>
        
        <button id="close-player" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.2em;">
            &times;
        </button>
    </div>
</div> -->

<style>
.playlist-songs-title {
    font-weight: bold;
    margin: 20px 0 10px;
    font-size: 1.2em;
}

.song-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
    width: 100%;
}

.song-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin-right: 15px;
    border-radius: 5px;
}

.song-title {
    font-weight: bold;
}

.song-artist {
    font-size: 0.9em;
    color: #666;
}

.song-views {
    margin-left: auto;
    font-size: 0.9em;
    color: #666;
}

.empty-songs {
    text-align: center;
    padding: 20px;
    color: #666;
}

#random-play-button:hover {
    background: #1ed760;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

.song-item:hover {
    background-color: #f9f9f9;
    cursor: pointer;
}

/* #fixed-player audio {
    width: 100%;
    height: 40px;
    outline: none;
}

#close-player:hover {
    color: #1db954;
    transform: scale(1.1);
} */
</style>

<script>
// Gán sự kiện cho nút "Phát ngẫu nhiên"
document.getElementById('random-play-button').addEventListener('click', function() {
    if (!playlistSongs || playlistSongs.length === 0) {
        alert('Không có bài hát nào trong playlist!');
        return;
    }
    
    // Sao chép và xáo trộn playlist
    const shuffledPlaylist = [...playlistSongs];
    for (let i = shuffledPlaylist.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffledPlaylist[i], shuffledPlaylist[j]] = [shuffledPlaylist[j], shuffledPlaylist[i]];
    }
    
    // Kích hoạt player toàn cục
    if (window.playGlobalPlaylist) {
        window.playGlobalPlaylist(shuffledPlaylist);
    } else {
        alert('Player không khả dụng. Vui lòng tải lại trang!');
    }
});

// Chuyển dữ liệu PHP sang JS
const playlistSongs = <?= json_encode($songs) ?>;
</script>