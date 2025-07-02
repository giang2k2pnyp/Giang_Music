<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters & spaces";
			}

			if(empty($errors)) {
				$check_query = "select id from artists where name = :name limit 1";
				$check_data = ['name' => trim($_POST['name'])];
				$check_row = db_query_one($check_query, $check_data);

				if($check_row) {
					$errors['name'] = "That artist name is already in use";
				}
			}

			//image
			if(!empty($_FILES['image']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);

				}else{
					$errors['name'] = "image no valid. allowed types are ". implode(",", $allowed);
				}
				

			}else{
				$errors['name'] = "an image is required";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['image'] 	= $destination;
				$values['user_id'] 	= user('id');

				$query = "insert into artists (name,image,user_id,bio) values (:name,:image,:user_id,:bio)";
				db_query($query,$values);

				message("artist created successfully");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters with no spaces";
			}

			if(empty($errors)) {
				$check_query = "select id from artists where name = :name and id != :id limit 1";
				$check_data = [
					'name' => trim($_POST['name']),
					'id' => $id
				];
				$check_row = db_query_one($check_query, $check_data);

				if($check_row) {
					$errors['name'] = "That artist name is already in use";
				}
			}

 			//image
			if(!empty($_FILES['image']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png','image/jpg'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					
					//delete old file
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				}else{
					$errors['name'] = "image no valid. allowed types are ". implode(",", $allowed);
				}

			}

			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;

				$query = "update artists set name = :name,bio = :bio,user_id =:user_id where id = :id limit 1";
				
				if(!empty($destination)){
					$query = "update artists set name = :name,bio = :bio,user_id =:user_id, image = :image where id = :id limit 1";
					$values['image'] 	= $destination;
				}

				db_query($query,$values);

				message("artist edited successfully");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{
 
				$values = [];
				$values['id'] 		= $id;

				$query = "delete from artists where id = :id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}

				message("artist deleted successfully");
				redirect('admin/artists');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">

	  				<h3>Thêm nghệ sĩ mới</h3>

	  				<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Artist name">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>
 
 					<label>Ảnh nghệ sĩ:</label>
	  				<input class="form-control my-1" type="file" name="image">

	  				<label>Tiểu sử:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio')?></textarea>

	  				<?php if(!empty($errors['image'])):?>
	  					<small class="error"><?=$errors['image']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Chỉnh sửa</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="Artistname">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">

	  				<div>Ảnh nghệ sĩ:</div>
	  				<input class="form-control my-1" type="file" name="image">

	  				<label>Tiểu sử:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio',$row['bio'])?></textarea>

	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Cập nhật không thành công</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Trở lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Xóa nghệ sĩ</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Xóa</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Xóa không thành công</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Trở lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from artists order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Nghệ sĩ
  				<a href="<?=ROOT?>/admin/artists/add">
  					<button class="float-end btn bg-purple">Thêm mới</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Tên nghệ sĩ</th>
  					<th>Ảnh đại diện</th>
  					<th>Thao tác</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['name']?></td>
		  					<td>
		  						<a href="<?=ROOT?>/artist/<?=$row['id']?>">
		  						<img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;">
		  						</a>
		  					</td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/artists/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/artists/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>