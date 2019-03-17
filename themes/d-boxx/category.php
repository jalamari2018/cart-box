<?php
/*
 * CATEGORY.PHP : CATEGORY PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME."lib".DIRECTORY_SEPARATOR."site_def.php";

// HTML
require T_LIB."site_top.php"; ?>
<div class="spacer"></div>

<nav aria-label="breadcrumb" dir="rtl">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=URL_ROOT?>">المعرض </a></li>
		<li class="breadcrumb-item active" aria-current="page"><?=$cat['category_name']?></li>
	</ol>
</nav>

<div class="container" dir="rtl">
	<h2><?=$cat['category_name']?></h2>
	<?php
	if (is_array($pdt)) {
		echo "<div class='row'>";
		foreach ($pdt as $id=>$p) { ?>
		<div class="col-md-4">
			<div>
				<img class="cat-img" src="<?=$p['product_image']==""?T_ASSET."no-image.jpg":URL_UPLOADS.$p['product_image']?>">
			</div>
			<div class="cat-name">
				<?=$p['product_name']?> SR <?=$p['product_price']?> 
			</div>
			<div class="cat-desc"><?=$p['product_description']?></div>
			<form onsubmit="return cart.add(<?=$id?>);"><div class="form-group">
				<div class="input-group mb-3">
					<input type="text" class="form-control" id="qty-<?=$p['product_id']?>" placeholder="Quantity" value="1" required>
					<button type="submit" class="input-group-append btn btn-primary">
						<i class="fa fa-cart-plus"></i>
					</button>
				</div>
			</div></form>
		</div>
		<?php }
		echo "</div>";
	} else {
		echo "No products found.";
	}
	?>
</div>
<?php require T_LIB."site_bottom.php"; ?>