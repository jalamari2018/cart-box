<?php
/*
 * AJAX-PRODUCTS.PHP : AJAX PRODUCTS HANDLER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */


// MANAGE REQUESTS
$_CB->extend("Catalog");
switch ($_POST['req']){
	/* [DEFAULT] */
	default:
		die("Invalid request");
		break;

	/* [LIST PRODUCTS] */
	case "list":
		$pages = $_CB->pages($_CB->Catalog->pdtCount($_POST['search']));
		$page = is_numeric($_POST['page']) ? $_POST['page'] : 1 ;
		if ($page > $pages) { $page = $pages; }
		$products = $_CB->Catalog->getAllPdt($_POST['search'],$page); ?>
		<div class="table-responsive">
			<?php if (is_array($products)) { ?>
			<table class="table">
				<?php foreach ($products as $id=>$p) { ?>
				<tr>
					<td>
						<?php if ($p['product_image']) { ?>
						<img class="nail" src="<?=URL_UPLOADS?><?=$p['product_image']?>">
						<?php } else { ?>
						<div class="nail"></div>
						<?php } ?>
						<div class="dataA">
							<i class="fa fa-cube"></i> <?=$p['product_name']?> $<?=$p['product_price']?>
						</div>
						<div class="dataB">
							<i class="fa fa-ellipsis-h"></i> <?=$p['product_description']?$p['product_description']:"NA"?>
						</div>
						<div class="dataB">
							<i class="fa fa-globe"></i> /<?=$p['product_slug']?>
						</div>
					</td>
					<td style="text-align:right">
						<span class="btn btn-danger" onclick="pdt.cdel(<?=$id?>);">
							<i class="fa fa-window-close"></i>
						</span>
						<span class="btn btn-primary" onclick="pdt.addedit(<?=$id?>)">
							<i class="fa fa-edit"></i>
						</span>
					</td>
				</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<div class="nolist">
				<i class="fa fa-exclamation-circle"></i> No products found.
			</div>
			<?php } ?>
		</div>
		<?php
		if ($pages>1) {
			$_CB->extend("ATheme");
			$_CB->ATheme->paginate($pages,$page,"pdt.pg");
		}
		break;

	/* [ADD/EDIT PRODUCT] */
	case "addedit":	
		if (is_numeric($_POST['product_id'])) {
			$pdt = $_CB->Catalog->getPdt($_POST['product_id']);
		}
		$edit = is_array($pdt); ?>
		<form onsubmit="return pdt.save();" id="pdt_form" class="form-wrap form-limit">
			<div class="form-wrap-head">
				<?=($edit?"Edit":"Add")?> Product
			</div>
			<div class="form-wrap-body">
				<input type="hidden" class="form-control" id="product_id" value="<?=$pdt['product_id']?>">
				<div class="form-group">
					<label for="product_name">* Name</label>
					<input type="text" class="form-control" id="product_name" placeholder="Product name" value="<?=$pdt['product_name']?>" required autofocus>
					<div class="invalid-feedback" id="e_product_name"></div>
				</div>
				<div class="form-group">
					<label for="slug">* Slug</label>
					<input type="text" class="form-control" id="product_slug" placeholder="Product slug" value="<?=$pdt['product_slug']?>" required>
					<div class="invalid-feedback" id="e_product_slug"></div>
				</div>
				<div class="form-group">
					<label for="slug">* Price</label>
					<input type="text" class="form-control" id="product_price" placeholder="Product price" value="<?=$pdt['product_price']?>" required>
					<div class="invalid-feedback" id="e_product_price"></div>
				</div>
				<div class="form-group">
					<label for="slug">Description</label>
					<input type="text" class="form-control" id="product_description" placeholder="Description" value="<?=$pdt['product_description']?>">
					<div class="invalid-feedback" id="e_product_description"></div>
				</div>
				<div class="form-group">
					<label for="product_image">Image</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" id="product_image" placeholder="Image" value="<?=$pdt['product_image']?>">
						<div class="input-group-append" onclick="pdt.pick();">
							<span class="input-group-text"><i class="fa fa-external-link-square-alt"></i></span>
						</div>
					</div>
					<div class="invalid-feedback" id="e_product_image"></div>
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
		break;
}
?>