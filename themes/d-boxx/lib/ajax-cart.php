<?php
/*
 * AJAX-CART.PHP : AJAX CART HANDLER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("Cart");
switch ($_POST['req']) {
	default :
		die("INVALID REQUEST");
		break;

	/* [NUMBER OF ITEMS IN CART] */
	case "count":
		echo $_CB->Cart->count();
		break;

	/* [SHOW CART] */
	case "show": ?>
		<div class="spacer"></div>
		<div class="container">
			<h3>سلة التسوق</h3>
			<?php if (empty($_SESSION['cart'])) { ?>
			<div>
				سلة التسوق فارغة
			</div>
			<?php } else { ?>
			<div class="table-responsive"><table class="table table-striped" dir="rtl"><?php
				$_CB->extend("Cart");
				$show = $_CB->Cart->show();
				foreach ($show['cart'] as $id=>$p) { ?>
				<tr>
					<td>
						<img class="cart-img" src="<?=$p['product_image']==""?T_ASSET."no-image.jpg":URL_UPLOADS.$p['product_image']?>">
						<div class="cart-name"><?=$p['product_name']?></div>
						<div class="cart-price">
							السعر<?=$p['product_price']?>  ر.س 
						</div>
					</td>
					<td class="text-right">
						<div class="form-group">
							<div class="input-group mb-3">
								<input type="text" class="form-control cart-pdt-qty" id="cart-qty-<?=$p['product_id']?>" placeholder="Quantity" value="<?=$p['qty']?>" onchange="cart.change(<?=$p['product_id']?>);" required>
								<button type="button" class="input-group-append btn btn-danger" onclick="cart.remove(<?=$id?>)">
									<i class="fa fa-times"></i>
								</button>
							</div>
						</div>
					</td>
				</tr>
				<?php }
			?></table></div>
			<div class="cart-total">
				السعر الإجمالي :<?=$show['total']?> ريال سعودي
			</div>
			<?php } ?>
			<span class="btn btn-danger" onclick="cb.page('A')">
				<i class="fa fa-reply"></i> عودة
			</span>
			<?php if (!empty($_SESSION['cart'])) { ?>
			<span onclick="cart.out()" class="btn btn-primary">
				<i class="fa fa-cart-arrow-down"></i> إتمام عملية الشراء
			</span>
			<?php } ?>
		</div>
		<?php break;
}
 ?>