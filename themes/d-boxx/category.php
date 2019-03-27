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



  <!-- Modal -->
  <div class="modal fade" id="jebreelModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">صور المنتج </h4>
        </div>
        <div class="modal-body">
           <!-- Got the slide show inside the modal -->
           <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
             <div class="carousel-inner">
               <div class="carousel-item active">
                 <img id="productImage1" class="d-block w-100" src="<?php //echo T_ASSET.'a1.jpg';?>" alt="First slide">
               </div>
               <div class="carousel-item">
                 <img id="productImage2" class="d-block w-100" src="<?php //echo T_ASSET.'a2.jpg';?>"  alt="Second slide">
               </div>
               <div class="carousel-item">
                 <img  id="productImage3" class="d-block w-100"  src="<?php //echo T_ASSET.'a3.jpg';?>"  alt="Third slide">
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
           <div class="spacer"></div> 

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
      
    </div>
  </div>
  


<div class="container" dir="rtl">
	<h2><?=$cat['category_name']?></h2>
	<?php
	if (is_array($pdt)) {
		echo "<div class='row'>";
		foreach ($pdt as $id=>$p) { ?>
		<div class="col-md-4">
			<div>
				<img class="cat-img" src="<?=$p['product_image']==""?T_ASSET."no-image.jpg":URL_UPLOADS.$p['product_image']?>" onclick="return showMorePics(this);">
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