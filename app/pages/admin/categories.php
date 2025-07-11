<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['category']))
			{
				$errors['category'] = "a category is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['category'])){
				$errors['category'] = "a category can only have letters & spaces";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['category'] = trim($_POST['category']);
				$values['disabled'] 	= trim($_POST['disabled']);

				$query = "insert into categories (category,disabled) values (:category,:disabled)";
				db_query($query,$values);

				message("category created successfully");
				redirect('admin/categories');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from categories where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['category']))
			{
				$errors['category'] = "a category is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['category'])){
				$errors['category'] = "a category can only have letters with no spaces";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['category'] = trim($_POST['category']);
				$values['disabled'] 	= trim($_POST['disabled']);
				$values['id'] 		= $id;

				$query = "update categories set category = :category, disabled = :disabled where id = :id limit 1";
				db_query($query,$values);

				message("category edited successfully");
				redirect('admin/categories');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from categories where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{

				$values = [];
				$values['id'] 		= $id;

				$query = "delete from categories where id = :id limit 1";
				db_query($query,$values);

				message("category deleted successfully");
				redirect('admin/categories');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Thêm thể loại nhạc mới</h3>

	  				<input class="form-control my-1" value="<?=set_value('category')?>" type="text" name="category" placeholder="Category name">
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>
 
	  				<select name="disabled" class="form-control my-1">
	  					<option value="">--Select Disabled--</option>
	  					<option <?=set_select('disabled','1')?> value="1">Yes</option>
	  					<option <?=set_select('disabled','0')?> value="0">No</option>
	  				</select>
	  				<?php if(!empty($errors['disabled'])):?>
	  					<small class="error"><?=$errors['disabled']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Chỉnh sửa</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('category',$row['category'])?>" type="text" name="category" placeholder="Categoryname">
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>

	  				<select name="disabled" class="form-control my-1">
	  					<option value="">--Select Disabled--</option>
	  					<option <?=set_select('disabled','1',$row['disabled'])?> value="1">Yes</option>
	  					<option <?=set_select('disabled','0',$row['disabled'])?> value="0">No</option>
	  				</select>

	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Cập nhật không thành công</div>
	  					<a href="<?=ROOT?>/admin/categories">
		  					<button type="button" class="float-end btn">Trở lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Xóa thể loại nhạc</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('category',$row['category'])?></div>
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Xóa</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Trở lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Xóa không thành công</div>
	  					<a href="<?=ROOT?>/admin/categories">
		  					<button type="button" class="float-end btn">Trỏ lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from categories order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Thể loại 
  				<a href="<?=ROOT?>/admin/categories/add">
  					<button class="float-end btn bg-purple">Thêm mới</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Tên thể loại nhạc</th>
  					<th>Tính khả dụng</th>
  					<th>Thao tác</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['category']?></td>
		  					<td><?=$row['disabled'] ? 'No':'Yes'?></td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/categories/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/categories/delete/<?=$row['id']?>">
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