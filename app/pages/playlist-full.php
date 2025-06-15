    <div class="left-column" style="flex: 0 0 250px; position: sticky; top: 20px; height: fit-content;">
        <div class="sidebar-section" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Nghệ Sĩ Ngẫu Nhiên</h3>
			<?php 
                $query = "SELECT * FROM artists ORDER BY RAND() LIMIT 10";
                $random_artists = db_query($query);
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

<!-- Right column: Random playlists -->
    <div class="right-column" style="flex: 0 0 250px; position: sticky; top: 20px; height: fit-content;">
        <div class="sidebar-section" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Playlist Ngẫu Nhiên</h3>
            <?php 
                $query = "SELECT * FROM list_song ORDER BY RAND() LIMIT 5";
                $random_playlists = db_query($query);
            ?>
            <?php if(!empty($random_playlists)):?>
                <div style="display: grid; gap: 15px;">
                    <?php foreach($random_playlists as $playlist):?>
                        <div class="playlist-card">
                            <a href="<?=ROOT?>/playlist/<?=$playlist['id']?>" style="text-decoration: none; color: inherit;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 50px; height: 50px; overflow: hidden; border-radius: 4px; margin-right: 10px;">
                                        <img src="<?=ROOT?>/<?=$playlist['image']?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">
                                            <?=esc($playlist['name_list'])?>
                                        </div>
                                        <div style="font-size: 0.8em; color: #666;">
                                            <?=count_playlist_songs($playlist['id'])?> bài hát
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
    width: 350px;
}

.song-item img {
    width: 70px;
    height: 70px;
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