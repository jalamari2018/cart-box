<?php
/*
 * PAGE-PRODUCTS.PHP : ADMIN PRODUCTS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<nav class='subnav'>
	<h3 class="float-left">Manage Products</h3>
	<form class="float-right" id="search-form" onsubmit="return pdt.search()">
		<input type="hidden" id="search-page" value="1">
		<input type="hidden" id="search-name" value="">
		<div class="input-group">
			<input type="text" class="form-control form-control-sm" id="entry-name" placeholder="Product Name">
			<div class="input-group-append">
				<button type="submit" class="input-group-text">
					<i class="fa fa-search"></i>
				</button>
				<span class="input-group-text" onclick="pdt.addedit()">
					<i class="fa fa-plus"></i>
				</span>
			</div>
		</div>
	</form>
</nav>
<div id="pdt-list" class="sublist"></div>
<link href="<?=URL_ROOT?>public/jquery/jquery-ui.css" rel="stylesheet">
<link href="<?=URL_ROOT?>public/elfinder/css/elfinder.min.css" rel="stylesheet">
<script src="<?=URL_ROOT?>public/jquery/jquery-ui.min.js"></script>
<script src="<?=URL_ROOT?>public/elfinder/js/elfinder.min.js"></script>
<script>
var pdt = {
	list : function(){
	// list() : show list of products

		cb.load({
			to : "pdt-list",
			module : "products",
			data : { 
				req : "list",
				page : $('#search-page').val(),
				search : $('#search-name').val()
			}
		});
	},

	pg : function(pg){
	// pg() : go to selected page

		$('#search-page').val(pg);
		pdt.list();
	},

	search : function(){
	// search() : search for users

		$('#search-page').val("1");
		$('#search-name').val($('#entry-name').val());
		pdt.list();
		return false;
	},

	addedit : function(id){
	// addedit() : add/edit product
	// PARAM id : product ID, add new product if none

		cb.page("B");
		cb.load({
			to : "page-B",
			module : "products",
			data : { 
				req : "addedit",
				product_id : id
			}
		});
	},

	pick : function(){
	// pdt.pick() : fire up the file picker

		if ($('#elpick').length==0) {
			$('#page-E').html("<h3>Choose an image</h3><div id='elpick'></div><br><span class='btn btn-danger' onclick='cb.page(\"B\")'><i class='fa fa-reply'></i></span>");
			$('#elpick').elfinder({
				url  : '<?=URL_API?>admin/elf',
				lang : 'en',
				cssAutoLoad : false,
				rememberLastDir : false,
				resizable: false,
				height: 400,
				getFileCallback : function(file) {
					var relative = file['url'].replace(cb.upurl,"");
					$('#product_image').val(relative);
					cb.page("B");
				}
			});
		}
		cb.page("E");
	},

	save : function(){
	// pdt() : save product

		cb.api({
			module : "admin/catalog",
			data : {
				req : ($('#product_id').val()=="" ? "add-pdt" : "edit-pdt"),
				product_id : $('#product_id').val(),
				product_name : $('#product_name').val(),
				product_slug : $('#product_slug').val(),
				product_price : $('#product_price').val(),
				product_description : $('#product_description').val(),
				product_image : $('#product_image').val()
			},
			before : function(){
				var err = $("#pdt_form .is-invalid");
				if (err.length>0) {
					err.each(function(){
						$(this).removeClass("is-invalid");
					});
				}
			},
			pass : function(res){
				pdt.list();
				if ($('#product_id').val()=="") {
					pdt.addedit(res['cb-more']);
				} else {
					pdt.addedit($('#product_id').val());
				}
			},
			fail : function(res){
				for (var key in res['cb-more']) {
					$('#'+key).addClass("is-invalid");
					$('#e_'+key).html(res['cb-more'][key]);
				}
			}
		});
		return false;
	},

	cdel : function(id){
	// cdel() : confirm delete product
	// PARAM id : product ID

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> Delete product?",
			body : "Product data will be lost!",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="pdt.del('+id+')"><i class="fa fa-check"></i></button>'
		});
	},

	del : function(id){
	// del() : delete product
	// PARAM id : product ID

		cb.mhide();
		cb.api({
			module : "admin/catalog",
			data : {
				req : "del-pdt",
				product_id : id
			},
			pass : function(){
				pdt.list();
			}
		});
	}
};

$(document).ready(function() {
	pdt.list();
});
</script>