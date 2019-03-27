<?php
/*
 * PAGE-CATEGORIES.PHP : ADMIN CATEGORIES
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<nav class='subnav'>
	<h3 class="float-left">Manage Categories</h3>
	<form class="float-right" id="search-form" onsubmit="return cat.search()">
		<input type="hidden" id="search-page" value="1">
		<input type="hidden" id="search-cat" value="">
		<div class="input-group">
			<input type="text" class="form-control form-control-sm" id="entry-cat" placeholder="Category Name">
			<div class="input-group-append">
				<button type="submit" class="input-group-text">
					<i class="fa fa-search"></i>
				</button>
				<span class="input-group-text" onclick="cat.addedit()">
					<i class="fa fa-plus"></i>
				</span>
			</div>
		</div>
	</form>
</nav>
<div id="cat-list" class="sublist"></div>
<link href="<?=URL_ROOT?>public/jquery/jquery-ui.css" rel="stylesheet">
<link href="<?=URL_ROOT?>public/elfinder/css/elfinder.min.css" rel="stylesheet">
<script src="<?=URL_ROOT?>public/jquery/jquery-ui.min.js"></script>
<script src="<?=URL_ROOT?>public/elfinder/js/elfinder.min.js"></script>
<script>
var cat = {
	list : function(){
	// list() : show list of categories

		cb.load({
			to : "cat-list",
			module : "categories",
			data : { 
				req : "list",
				page : $('#search-page').val(),
				search : $('#search-cat').val()
			}
		});
	},

	pg : function(pg){
	// pg() : go to selected page

		$('#search-page').val(pg);
		cat.list();
	},

	search : function(){
	// search() : search for categories

		$('#search-page').val("1");
		$('#search-cat').val($('#entry-cat').val());
		cat.list();
		return false;
	},

	addedit : function(id){
	// addedit() : add/edit category
	// PARAM id : category ID, add new category if none

		cb.page("B");
		cb.load({
			to : "page-B",
			module : "categories",
			data : { 
				req : "addedit",
				category_id : id
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
					$('#category_image').val(relative);
					cb.page("B");
				}
			});
		}
		cb.page("E");
	},

	save : function(){
	// cat() : save category

		cb.api({
			module : "admin/catalog",
			data : {
				req : ($('#category_id').val()=="" ? "add-cat" : "edit-cat"),
				category_id : $('#category_id').val(),
				category_name : $('#category_name').val(),
				category_slug : $('#category_slug').val(),
				category_description : $('#category_description').val(),
				category_image : $('#category_image').val()
			},
			before : function(){
				var err = $("#cat_form .is-invalid");
				if (err.length>0) {
					err.each(function(){
						$(this).removeClass("is-invalid");
					});
				}
			},
			pass : function(res){
				cat.list();
				if ($('#category_id').val()=="") {
					cat.addedit(res['cb-more']);
				} else {
					cat.addedit($('#category_id').val());
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
	// cdel() : confirm delete category
	// PARAM id : category ID

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> Delete category?",
			body : "Category data will be lost, but products will remain.",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="cat.del('+id+')"><i class="fa fa-check"></i></button>'
		});
	},

	del : function(id){
	// del() : delete category
	// PARAM id : category ID

		cb.mhide();
		cb.api({
			module : "admin/catalog",
			data : {
				req : "del-cat",
				category_id : id
			},
			pass : function(){
				cat.list();
			}
		});
	}
};

var ass = {
	shell : function(id){
	// shell() : show product assigment screen
	// PARAM id : category ID

		cb.page("B");
		cb.load({
			to : "page-B",
			module : "p2c",
			data : { 
				req : "shell",
				category_id : id
			},
			after : ass.list
		});
	},

	list : function(){
	// list() : show list of products

		cb.load({
			to : "ass-list",
			module : "p2c",
			data : { 
				req : "list",
				page : $('#ass-page').val(),
				search : $('#ass-pdt').val(),
				category_id : $('#ass-cat').val()
			}
		});
	},

	pg : function(pg){
	// pg() : go to selected page

		$('#ass-page').val(pg);
		ass.list();
	},

	search : function(){
	// search() : search for products

		$('#ass-page').val("1");
		$('#ass-pdt').val($('#entry-ass').val());
		ass.list();
		return false;
	},

	save : function(id){
	// ass.save() : save current assignement
	// PARAM id : product id

		var cat = $('#ass-cat').val();
		var data = {
			req : ($('#sel-'+id).is(':checked')) ? "add-pdt-to-cat" : "del-pdt-to-cat",
			p2c : {}
		};
		data.p2c[id] = [cat];
		cb.api({
			module : "admin/catalog",
			data : data
		});
	}
};

$(document).ready(function() {
	cat.list();
});
</script>