<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css">
<?php require page('includes/header')?>

<div class="section-title">Playlists</div>

<section class="content">
    <?php 
        // Lấy danh sách playlist của user đang đăng nhập
        $user_playlists = logged_in() ? get_user_playlists(user('id')) : [];
    ?>

    <?php if(!empty($user_playlists)):?>
        <div class="playlist-grid">
            <?php foreach($user_playlists as $playlist):?>
                <div class="playlist-card">
                    <a href="<?=ROOT?>/playlist/<?=$playlist['id']?>">
                        <img src="<?=ROOT?>/<?=$playlist['image']?>" alt="<?=esc($playlist['name_list'])?>">
                        <h3><?=esc($playlist['name_list'])?></h3>
                    </a>
                    <p><?=count_playlist_songs($playlist['id'])?> bài hát</p>
                    <p>Tạo ngày: <?=get_date($playlist['date_create'])?></p>
                </div>
            <?php endforeach;?>
        </div>
    <?php else:?>
        <div class="empty-playlist">
            <p>Bạn chưa có danh sách phát nào.</p>
            <a href="<?=ROOT?>/music" class="btn bg-purple">Khám phá nhạc</a>
        </div>
    <?php endif;?>
</section>

<style>
.playlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.playlist-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.playlist-card:hover {
    transform: translateY(-5px);
}

.playlist-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.playlist-card h3 {
    margin: 10px;
    font-size: 1.1em;
    text-align: center;
}

.playlist-card p {
    margin: 0 10px 10px;
    font-size: 0.9em;
    color: #666;
    text-align: center;
}

.empty-playlist {
    text-align: center;
    padding: 50px;
    color: #666;
}

.empty-playlist p {
    margin-bottom: 20px;
}
</style>

<?php require page('includes/footer')?>