<?php
/*
 * INDEX.PHP : DEFAULT THEME LANDING/SHOP PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME."lib".DIRECTORY_SEPARATOR."site_def.php";

// HTML
require T_LIB."site_top.php"; ?>
<div class="spacer"></div>
<div class="container" dir="rtl"><?php
	if (is_array($cat)) {
		echo "<div class='row'>";
		foreach ($cat as $id=>$c) { ?>
		<div class="col-md-4">
			<a href="<?=URL_ROOT?>category/<?=$c['category_slug']?>">
				<img class="cat-img" src="<?=$c['category_image']==""?T_ASSET."no-image.jpg":URL_UPLOADS.$c['category_image']?>">
			</a>
			<div class="cat-name"><?=$c['category_name']?></div>
			<div class="cat-desc"><?=$c['category_description']?></div>
		</div>
		<?php }
		echo "</div>";
	} else {
		echo "<div>No categories found</div>";
	}
?></div>
<?php require T_LIB."site_bottom.php"; ?>