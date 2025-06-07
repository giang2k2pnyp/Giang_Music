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
    </div>
</div>
<!--end playlist card-->

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
</style>