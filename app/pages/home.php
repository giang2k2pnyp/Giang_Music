<?php require page('includes/header')?>

	<section>
		<img class="hero" src="<?=ROOT?>/assets/images/festival1.jpeg">
	</section>
	
	<div class="section-title">Bài Hát</div>

	<section class="content">
		
		<?php 

			//$rows = db_query("select * from songs where featured = 1 order by id desc limit 16");
			$rows = db_query("SELECT * FROM songs ORDER BY RAND() LIMIT 16");

			// $rows = db_query("select * from songs order by id desc limit 16");

		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/song')?>
			<?php endforeach;?>
		<?php else:?>
			<div class="m-2">Không tìm thấy bài hát nào</div>
		<?php endif;?>

	</section>
	</section>
	
	<div class="section-title">Nghệ Sĩ</div>

	<section class="content">
		
		<?php 

			//$rows = db_query("select * from songs where featured = 1 order by id desc limit 16");
			$rows = db_query("SELECT * FROM artists ORDER BY RAND() LIMIT 8");

			// $rows = db_query("select * from songs order by id desc limit 16");

		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/artist')?>
			<?php endforeach;?>
		<?php else:?>
			<div class="m-2">Không tìm thấy nghệ sĩ nào</div>
		<?php endif;?>

	</section>

	<div class="section-title">Playlists</div>

	<section class="content">
		
		<?php 
			//$rows = db_query("select * from songs where featured = 1 order by id desc limit 16");
			$rows = db_query("SELECT * FROM list_song ORDER BY RAND() LIMIT 4");
			// $rows = db_query("select * from songs order by id desc limit 16");
		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/playlist')?>
			<?php endforeach;?>
		<?php else:?>
			<div class="m-2">Không tìm thấy playlist nào</div>
		<?php endif;?>

	</section>

<?php require page('includes/footer')?>