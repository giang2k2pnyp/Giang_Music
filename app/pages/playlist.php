<?php require page('includes/header')?>

<center><div class="section-title">Chi tiết Playlist</div></center>

<section class="content">
    <?php 
        $id = $URL[1] ?? null;
        $playlist = get_playlist_info($id);
    ?>

    <?php if(!empty($playlist)):?>
        <?php include page('playlist-full')?>
    <?php else:?>
        <div class="playlist-not-found">
            <p>Không tìm thấy playlist!</p>
            <a href="<?=ROOT?>/playlists" class="btn bg-purple">Quay lại danh sách</a>
        </div>
    <?php endif;?>
</section>

<style>
.playlist-not-found {
    text-align: center;
    padding: 50px;
    color: #666;
}

.playlist-not-found p {
    margin-bottom: 20px;
    font-size: 1.2em;
}
</style>

<?php require page('includes/footer')?>