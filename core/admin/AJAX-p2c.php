<?php
/*
 * AJAX-P2C.PHP : AJAX ASSIGN PRODUCT TO CATEGORY
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// MANAGE REQUESTS
$_CB->extend("Catalog");
switch ($_POST['req']){
	/* [DEFAULT] */
	default:
		die("Invalid request");
		break;

	/* [ASSIGNMENT PAGE SHELL] */
	case "shell":
		$cat = $_CB->Catalog->getCat($_POST['category_id']); ?>
		<nav class='subnav'>
			<h5 class="float-left">
				Assign Products to <?=$cat['category_name']?>
			</h5>
			<form class="float-right" id="search-form" onsubmit="return ass.search()">
				<input type="hidden" id="ass-cat" value="<?=$_POST['category_id']?>">
				<input type="hidden" id="ass-page" value="1">
				<input type="hidden" id="ass-pdt" value="">
				<div class="input-group">
					<input type="text" class="form-control form-control-sm" id="entry-ass" placeholder="Product Name">
					<div class="input-group-append">
						<button type="submit" class="input-group-text">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</nav>
		<div id="ass-list" class="sublist"></div><br>
		<span class="btn btn-danger" onclick="cb.page('A')">
			<i class="fa fa-reply"></i>
		</span>
		<?php
		break;

	/* [ASSIGNMENT PRODUCTS] */
	case "list":
		$pages = $_CB->pages($_CB->Catalog->pdtCount($_POST['search']));
		$page = is_numeric($_POST['page']) ? $_POST['page'] : 1 ;
		if ($page > $pages) { $page = $pages; }
		$products = $_CB->Catalog->getAllPdt($_POST['search'],$page,$_POST['category_id']); ?>
		<div class="table-responsive">
			<?php if (is_array($products)) { ?>
			<table class="table">
				<?php foreach ($products as $id=>$p) { ?>
				<tr><td><div class="form-check">
				<label class="form-check-label">
					<input id="sel-<?=$p['product_id']?>" class="form-check-input" type="checkbox" value="<?=$p['product_id']?>"<?=is_numeric($p['category_id'])?" checked":""?> onchange="ass.save(<?=$p['product_id']?>);">
					<?php if ($p['product_image']) { ?>
						<img class="nail" src="<?=URL_UPLOADS?><?=$p['product_image']?>">
						<?php } else { ?>
						<div class="nail"></div>
						<?php } ?>
					<div class="dataA"><?=$p['product_name']?></div>
					<div class="dataB"><?=$p['product_description']?></div>
				</label>
				</div></td></tr>
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
			$_CB->ATheme->paginate($pages,$page,"ass.pg");
		}
		break;
}
?>