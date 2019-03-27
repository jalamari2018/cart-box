<?php
/*
 * AJAX-CATEGORIES.PHP : AJAX CATEGORIES HANDLER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// MANAGE REQUESTS
$_CB->extend("Catalog");
switch ($_POST['req']){
	/* [DEFAULT] */
	default:
		die("Invalid request");
		break;

	/* [LIST CATEGORIES] */
	case "list":
		$pages = $_CB->pages($_CB->Catalog->catCount($_POST['search']));
		$page = is_numeric($_POST['page']) ? $_POST['page'] : 1 ;
		if ($page > $pages) { $page = $pages; }
		$categories = $_CB->Catalog->getAllCat($_POST['search'], $page); ?>
		<div class="table-responsive">
			<?php if (is_array($categories)) { ?>
			<table class="table">
			<?php foreach ($categories as $id=>$c) { ?>
			<tr>
				<td>
					<?php if ($c['category_image']) { ?>
					<img class="nail" src="<?=URL_UPLOADS?><?=$c['category_image']?>">
					<?php } else { ?>
					<div class="nail"></div>
					<?php } ?>
					<div class="dataA">
						<i class="fa fa-cube"></i> <?=$c['category_name']?>
					</div>
					<div class="dataB">
							<i class="fa fa-ellipsis-h"></i> <?=$c['category_description']?$c['category_description']:"NA"?>
						</div>
						<div class="dataB">
							<i class="fa fa-globe"></i> /<?=$c['category_slug']?>
						</div>
				</td>
				<td style="text-align:right">
					<span class="btn btn-danger" onclick="cat.cdel(<?=$id?>);">
						<i class="fa fa-window-close"></i>
					</span>
					<span class="btn btn-primary" onclick="ass.shell(<?=$id?>)">
						<i class="fa fa-project-diagram"></i>
					</span>
					<span class="btn btn-primary" onclick="cat.addedit(<?=$id?>)">
						<i class="fa fa-edit"></i>
					</span>
				</td>
			</tr>
			<?php } ?>
			</table>
			<?php } else { ?>
			<div class="nolist">
				<i class="fa fa-exclamation-circle"></i> No categories found.
			</div>
			<?php } ?>
		</div>
		<?php
		if ($pages>1) {
			$_CB->extend("ATheme");
			$_CB->ATheme->paginate($pages,$page,"cat.pg");
		}
		break;

	/* [ADD/EDIT CATEGORY] */
	case "addedit":	
		if (is_numeric($_POST['category_id'])) {
			$cat = $_CB->Catalog->getCat($_POST['category_id']);
		}
		$edit = is_array($cat); ?>
		<form onsubmit="return cat.save();" id="cat_form" class="form-wrap form-limit">
			<div class="form-wrap-head">
				<?=($edit?"Edit":"Add")?> Category
			</div>
			<div class="form-wrap-body">
				<input type="hidden" class="form-control" id="category_id" value="<?=$cat['category_id']?>">
				<div class="form-group">
					<label for="category_name">* Name</label>
					<input type="text" class="form-control" id="category_name" placeholder="Category name" value="<?=$cat['category_name']?>" required autofocus>
					<div class="invalid-feedback" id="e_category_name"></div>
				</div>
				<div class="form-group">
					<label for="category_slug">* Slug</label>
					<input type="text" class="form-control" id="category_slug" placeholder="Category slug" value="<?=$cat['category_slug']?>" required>
					<div class="invalid-feedback" id="e_category_slug"></div>
				</div>
				<div class="form-group">
					<label for="category_description">Description</label>
					<input type="text" class="form-control" id="category_description" placeholder="Description" value="<?=$cat['category_description']?>">
					<div class="invalid-feedback" id="e_category_description"></div>
				</div>
				<div class="form-group">
					<label for="category_image">Image</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" id="category_image" placeholder="Image" value="<?=$cat['category_image']?>">
						<div class="input-group-append" onclick="cat.pick();">
							<span class="input-group-text"><i class="fa fa-external-link-square-alt"></i></span>
						</div>
					</div>
					<div class="invalid-feedback" id="e_category_image"></div>
				</div>
			</div>
			<div class="form-wrap-foot">
				<span class="btn btn-danger" onclick="cb.page('A')">
					<i class="fa fa-reply"></i>
				</span>
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-check"></i>
				</button>
			</div>
		</form>
		<?php
}
?>