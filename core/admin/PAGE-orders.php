<?php
/*
 * PAGE-ORDERS.PHP : ADMIN ORDERS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<h3>Manage Orders</h3>
<input type="hidden" id="search-page" value="1">
<div id="orders-list" class="sublist"></div>
<script>
var orders = {
	list : function(){
		cb.load({
			to : "orders-list",
			module : "orders",
			data : { 
				req : "list",
				page : $('#search-page').val()
			}
		});
	},

	pg : function(pg){
	// pg() : go to selected page

		$('#search-page').val(pg);
		orders.list();
	},

	show : function(id){
	// show() : show order
	// PARAM id : order id

		cb.page("B");
		cb.load({
			to : "page-B",
			module : "orders",
			data : { 
				req : "show",
				order_id : id
			}
		});
	},

	save : function(){
	// save() : update order status

		cb.api({
			module : "admin/orders",
			data : {
				req : "up-status",
				order_id : $('#order_id').val(),
				order_status : $('#order_status').val()
			},
			pass : function(res){
				orders.list();
			}
		});
	}
};

$(document).ready(function() {
	orders.list();
});
</script>