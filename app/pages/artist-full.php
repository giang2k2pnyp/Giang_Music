<!--start music card-->
<div class="artist-full-container" style="display: flex; max-width: 1400px; margin: 0 auto; padding: 20px; gap: 20px;">
    <!-- Left column: Random artists -->
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

	<div class="center-column" style="flex: 1; min-width: 0;">
		<div class="music-card-full" style="max-width: 600px; max-width: 100%; margin: 0 auto; display: flex; flex-direction: column; align-items: center;">
	
			<h2 class="card-title"><?=esc($row['name'])?></h2>

			<div style="overflow: hidden; display: flex; width: 350px;">
				<img src="<?=ROOT?>/<?=$row['image']?>">
			</div>
			<div class="card-content">
				<div><?=esc($row['bio'])?></div>

				<div>Bài hát của nghệ sĩ:</div>
				<div style="display: flex;flex-wrap: wrap;justify-content: center;">
					<?php 
						$query ="select * from songs where artist_id = :artist_id order by views desc limit 8";
						$songs = db_query($query,['artist_id'=>$row['id']]);
					?>

					<?php if(!empty($songs)):?>
						<?php foreach($songs as $row):?>
							<?php include page('includes/song')?>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>

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
</div>
<!--end music card-->