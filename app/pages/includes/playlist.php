<!--start playlist card-->
<div class="playlist-card">
    <div style="overflow: hidden;">
        <a href="<?=ROOT?>/playlist/<?=$row['id']?>">
            <img src="<?=ROOT?>/<?=$row['image']?>" alt="<?=esc($row['name_list'])?>">
        </a>
    </div>
    <div class="card-content">
        <div class="card-title"><?=esc($row['name_list'])?></div>
        <div class="card-subtitle"><?=count_playlist_songs($row['id'])?> bài hát</div>
    </div>
</div>
<!--end playlist card-->