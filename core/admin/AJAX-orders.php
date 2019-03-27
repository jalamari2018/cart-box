<?php
/*
 * AJAX-ORDERS.PHP : AJAX ORDERS HANDLER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// ORDER CODE
$_OCODE = array(
	1 => "Pending Payment",
	2 => "Processing",
	3 => "Closed",
	4 => "Canceled"
);

// MANAGE REQUESTS
$_CB->extend("Order");
switch ($_POST['req']){
	/* [DEFAULT] */
	default:
		die("Invalid request");
		break;

	/* [LIST ORDERS] */
	case "list":
		$pages = $_CB->pages($_CB->Order->count());
		$page = is_numeric($_POST['page']) ? $_POST['page'] : 1 ;
		if ($page > $pages) { $page = $pages; }
		$orders = $_CB->Order->getAll($_POST['page']); ?>
		<div class="table-responsive">
			<?php if (is_array($orders)) { ?>
			<table class="table">
				<?php foreach ($orders as $id=>$o) { ?>
				<tr>
					<td>
						<div class="dataA">
							<i class="fa fa-user"></i> <?=$o['order_name']?>
						</div>
						<div class="dataB">
							<i class="fa fa-calendar"></i> <?=$o['order_date']?>
						</div>
						<div class="dataB">
							<i class="fa fa-question-circle"></i> <?=$_OCODE[$o['order_status']]?>
						</div>
					</td>
					<td style="text-align:right">
						<span class="btn btn-info" onclick="orders.show(<?=$id?>)">
							<i class="fa fa-edit"></i>
						</span>
					</td>
				</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<div class="nolist">
				<i class="fa fa-exclamation-circle"></i> No orders found.
			</div>
			<?php } ?>
		</div>
		<?php
		if ($pages>1) {
			$_CB->extend("ATheme");
			$_CB->ATheme->paginate($pages,$page,"orders.pg");
		}
		break;

	/* [SHOW ORDER] */
	case "show":
		$order = $_CB->Order->getID($_POST['order_id']); ?>
		<h3>Manage Order</h3>

		<!-- [ORDER DETAILS] -->
		<form onsubmit="return order.save();" id="order_form" class="form-wrap form-limit">
			<div class="form-wrap-head">
				Order Details
			</div>
			<div class="form-wrap-body">
				<input type="hidden" id="order_id" value="<?=$order['order_id']?>">
				<div class="form-group">
					<label for="order_date">* Date of Purchase</label>
					<input type="text" class="form-control" id="order_date" placeholder="Order date" value="<?=$order['order_date']?>" required readonly>
					<div class="invalid-feedback" id="e_order_date"></div>
				</div>
				<div class="form-group">
					<label for="order_name">* Name</label>
					<input type="text" class="form-control" id="order_name" placeholder="Order name" value="<?=$order['order_name']?>" required readonly>
					<div class="invalid-feedback" id="e_order_name"></div>
				</div>
				<div class="form-group">
					<label for="order_status">* Status</label>
					<select class="form-control" id="order_status">
					<?php
					foreach ($_OCODE as $id=>$n) {
						printf("<option value='%s'>%s</option>",
							$id, $n
						);
					}
					?>
					</select>
				</div>
			</div>
		</form><br>

		<div class="form-wrap">
			<!-- [ORDER ITEMS] -->
			<div class="form-wrap-head">
				Order Items
			</div>
			<div class="table-responsive">
				<?php if (is_array($order['items'])) { ?>
				<table class="table">
				<?php foreach ($order['items'] as $id=>$p) { ?>
				<tr>
					<td>
						<?php if ($p['product_image']) { ?>
						<img class="nail" src="<?=URL_UPLOADS?><?=$p['product_image']?>">
						<?php } else { ?>
						<div class="nail"></div>
						<?php } ?>
						<div>
							<?=$p['quantity']?> X <?=$p['product_name']?>
						</div>
						<small>$<?=$p['product_price']?> ea</small>
					</td>
				</tr>
				<?php } ?>
				</table>
				<?php } else { ?>
				<div class="nolist">
					<i class="fa fa-exclamation-circle"></i> No items found.
				</div>
				<?php } ?>
			</div>

			<!-- [TOTALS] -->
			<div class="table-responsive">
				<?php if (is_array($order['totals'])) { ?>
				<table class="table">
					<?php
					foreach ($order['totals'] as $t) {
						printf("<tr><td><strong>%s - %s</strong></td></tr>", $t['total_text'], $t['total_value']);
					}
					?>
				</table>
				<?php } ?>
			</div>

			<div class="form-wrap-foot">
				<span class="btn btn-danger" onclick="cb.page('A')">
					<i class="fa fa-reply"></i>
				</span>
				<span class="btn btn-primary" onclick="orders.save()">
					<i class="fa fa-check"></i>
				</span>
			</div>
		</div>
		<?php
		break;
}
?>