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
<div class="container" dir="rtl">
<!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="<?php //echo T_ASSET.'a1.jpg';?>" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="<?php //echo T_ASSET.'a2.jpg';?>"  alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100"  src="<?php //echo T_ASSET.'a3.jpg';?>"  alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="spacer"></div> -->
<?php
	if (is_array($cat)) {
		echo "<div class='row'>";
		foreach ($cat as $id=>$c) { ?>
		<div class="col-md-4">
			<a href="<?=URL_ROOT?>category/<?=$c['category_slug']?>">
				<img class="cat-img" src="<?=$c['category_image']==""?T_ASSET."no-image.jpg":URL_UPLOADS.$c['category_image']?>">
				
				<div class="btn btn-outline-primary"><?=$c['category_name']?></div>
				
			</a>
			<div class="cat-desc"><?=$c['category_description']?></div>

		</div>
		<?php }
		echo "</div>";
	} else {
		echo "<div>لم يتم العثور على الي صنف </div>";
	}
?></div>
<?php require T_LIB."site_bottom.php"; ?>