<?php require page('includes/header')?>
	
	<div class="section-title">Category</div>

	<section class="content">
		
		<?php 
			$category = isset($URL[1]) ? rawurldecode($URL[1]) : null;
			// $category = $URL[1] ?? null;
			$query = "SELECT * FROM songs 
					  WHERE category_id IN (
						SELECT id FROM categories 
						WHERE TRIM(category) = :category
					  ) 
					  ORDER BY views DESC 
					  LIMIT 24";
			
			$rows = db_query($query,['category'=>$category]);

		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/song')?>
			<?php endforeach;?>
		<?php else:?>
			<div class="m-2">Không tìm thấy bài hát nào</div>
		<?php endif;?>

	</section>

<?php require page('includes/footer')?>