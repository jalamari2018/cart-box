/*
 * D-BOXX.JS : DEFAULT THEME JS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

var cb = {
	/* [LOADING BLOCK] */
	block : function(){
	// cb.block() : block the page

		$('#page-loader').addClass("active");
	},

	unblock : function(){
	// cb.unblock() : unblock the page

		$('#page-loader').removeClass("active");
	},

	/* [MODAL BOX] */
	mshow : function(opt={}){
	// mshow() : show modal box
	// PARAM opt : options object, see below

		/* MODAL BOX OPTIONS --------------
		 * header : modal box header color
		 *   see the admin/cart-boxx.css file & define your own
		 *   none - blue
		 *   warn - yellow
		 *   error - red
		 * title : modal box title
		 * body : modal box body
		 * footer : modal box footer
		--------------------------------- */

		$('#modal-header').removeClass();
		$('#modal-header').addClass("modal-header");
		if (opt.header) { $('#modal-header').addClass(opt.header); }
		$('#modal-title').html(opt.title?opt.title:"");
		$('#modal-body').html(opt.body?opt.body:"");
		$('#modal-footer').html(opt.footer?opt.footer:'<button type="button" class="btn btn-primary" data-dismiss="modal">اغلاق</button>');
		$("#page-modal").modal();
	},

	mhide : function(){
	// mhide() : hide modal box

		$('#page-modal').modal('hide');
	},

	/* [GROWL NOTIFICATION] */
	growl : function(opt={}){
	// growl : growl-like notification
	// PARAM opt : options object, see below

		/* GROWL OPTIONS --------------
		 * msg : growl message
		 * type : notification type - success, info, warning, danger
		 * delay : optional, autoclose delay, defaults to 2000ms
		--------------------------------- */

		// AUTO ADD ICON
		switch (opt.type) {
			default: break;
			case "success" : opt.msg = "<i class='fa fa-check fa-sm'></i> " + opt.msg; break;
			case "info" : opt.msg = "<i class='fa fa-info fa-sm'></i> " + opt.msg; break;
			case "warning" : opt.msg = "<i class='fa fa-exclamation fa-sm'></i> " + opt.msg; break;
			case "danger" : opt.msg = "<i class='fa fa-exclamation-triangle fa-sm'></i> " + opt.msg; break;
		}

		// DELAY
		if (!Number.isInteger(opt.delay)) { opt.delay = 2000; }

		// ROAR!
		$.notify({
			message:opt.msg
		},{
			type:opt.type,
			delay:opt.delay,
			placement: {
				from: 'bottom',
				align: 'right'
			}
		});
	},

	/* [AJAX - API] */
	api : function(opt={}){
	// api() : do ajax call to Cart Boxx API
	// PARAM opt : options object, see below

		/* API CALL OPTIONS --------------
		 * [DATA]
		 * module : target API module
		 * data : data to send
		 * debug : debug mode
		 * [NOTIFICATIONS & INTERFACE]
		 * [0 - NONE | 1 - MODAL | 2 - GROWL]
		 * notipass : notification on pass (optional, defaults to 2)
		 * notifail : notification on fail (optional, defaults to 1)
		 * passtitle : notification title on pass (modal only, optional)
		 * failtitle : notification title on fail (modal only, optional)
		 * block : show screen block? (optional, defaults to true)
		 * [HOOKS]
		 * before : function to perform before AJAX send
		 * pass : function to perform on AJAX pass
		 * fail : function to perform on AJAX fail
		--------------------------------- */

		// NOTIFICATIONS & INTERFACE
		opt.passtitle = opt.passtitle ? opt.passtitle : "<i class='fa fa-thumbs-up'></i> تمت العملية بنجاح!";
		opt.failtitle = opt.failtitle ? opt.failtitle : "<i class='fa fa-exclamation-triangle'></i> عفوا حصل خطأ";
		if (!Number.isInteger(opt.notipass)) { opt.notipass = 2; }
		if (!Number.isInteger(opt.notifail)) { opt.notifail = 1; }
		opt.block = opt.block ? opt.block : true;

		// DEBUG
		if (opt.debug) { console.log(opt); }

		// GO AJAX!
		$.ajax({
			method: "POST",
			url: this.apiurl + opt.module,
			data: opt.data,
			beforeSend: function(){
				if (typeof opt.before=="function") { opt.before(); }
				if (opt.block) { cb.block(); }
			}
		})
		.done(function(res){
			// DEBUG
			if (opt.debug) { console.log(res); }

			// PASS
			if (res['cb-status']==1) {
				// MODAL NOTIFICATION
				if (opt.notipass==1) {
					cb.mshow({
						title : opt.passtitle,
						body : res['cb-msg']
					});
				}
				// GROWL NOTIFICATION
				if (opt.notipass==2) {
					cb.growl({
						msg : res['cb-msg'],
						type : 'success'
					});
				}
				// PASS HOOK
				if (typeof opt.pass=="function") { opt.pass(res); }
			}
			// FAIL
			else if (res['cb-status']==0) {
				// MODAL NOTIFICATION
				if (opt.notifail==1) {
					cb.mshow({
						header : 'error',
						title : opt.failtitle,
						body : res['cb-msg']
					});
				}
				// GROWL NOTIFICATION
				if (opt.notifail==2) {
					cb.growl({
						msg : res['cb-msg'],
						type : 'danger'
					});
				}
				// FAIL HOOK
				if (typeof opt.fail=="function") { opt.fail(res); }
			}
			// UNKNOWN
			else {
				alert("SYSTEM FAILURE - UNKNOWN SERVER RESPONSE");
				if (opt.debug) { console.log(res); }
			}
		})
		.fail(function(res){
			alert("SYSTEM FAILURE - SERVER NOT RESPONDING");
			if (opt.debug) { console.log(res); }
		})
		.always(cb.unblock);
	},

	/* [AJAX - CONTENT] */
	load : function(opt={}){
	// load() : do ajax call to load content
	// PARAM opt : options object, see below

		/* CONTENT LOAD OPTIONS --------------
		 * [DATA]
		 * to : ID of target element to put contents
		 * module : target API module
		 * data : data to send
		 * debug : debug mode
		 * block : show AJAX spinner?
		 * [HOOKS]
		 * before : function to perform before AJAX send
		 * after : function to perform after AJAX done
		--------------------------------- */

		// OPTIONS
		var container = $('#'+opt.to);
		opt.block = opt.block ? opt.block : true;

		// DEBUG
		if (opt.debug) { console.log(opt); }

		// GO AJAX!
		$.ajax({
			method: "POST",
			url: cb.rooturl + "ajax/" + opt.module,
			data: opt.data,
			beforeSend: function(){
				if (typeof opt.before=="function") { opt.before(); }
				if (opt.block) {
					container.html("<img src='"+cb.rooturl+"public/img/bars-loader.gif'>");
				}
			}
		})
		.done(function(res){
			// DEBUG
			if (opt.debug) { console.log(res); }

			// DONE
			container.html(res);

			// HOOK
			if (typeof opt.after=="function") { opt.after(); }
		})
		.fail(function(res){
			alert("SYSTEM FAILURE - SERVER NOT RESPONDING");
			if (opt.debug) { console.log(res); }
		});
	},

	page : function(pg){
	// page() : switch to page (ABCDE)

		$('#page-A, #page-B, #page-C, #page-D, #page-E').hide();
		$('#page-'+pg).show();
	},

	/* [USER SESSION] */
	hi : function(){
	// cb.hi() : sign in user

		cb.api({
			module : "user",
			data : {
				req : "login",
				user_email : $('#signin-email').val(),
				user_password : $('#signin-password').val()
			},
			notipass : 0,
			pass : function(){
				location.href = cb.rooturl;
			}
		});
		return false;
	},

	bye : function(){
	// bye() : sign off user

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> تأكيد",
			body : "هل فعلا تريد الخروج",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="cb.gobye()"><i class="fa fa-check"></i></button>'
		});
	},

	gobye : function(){
	// bye() : sign off user

		cb.mhide();
		cb.api({
			module : "user",
			data : { req : "logoff" },
			notipass : 0,
			pass : function(){
				location.href = cb.rooturl;
			}
		});
	},

	forgot : function(){
	// forgot() : forgot password
		var email = $('#signin-email').val();
		
		if (email=="") {
			cb.mshow({
				title : "<i class='fa fa-info-circle'></i> الرجاء كتابة بريدك الالكتروني",
				body : "اكتب بريدك الالكتروني ليتم ارسال رابط الاستعادة لك"
			});
		} else {
			cb.api({
				module : "user",
				notipass : 1,
				data : {
					req : "forgot",
					user_email : $('#signin-email').val()
				}
			});
		}
	}
};

var cart = {
	count : function(){
	// count() : update cart count

		cb.load({
			to : "cart-count",
			module : "cart",
			data : {
				req : "count"
			},
			block : 0
		});
		
	},

	add : function(id){
	// add() : add item to cart
	// PARAM id : product id

		cb.api({
			module : "cart",
			data : {
				req : "add",
				product_id : id,
				qty : $('#qty-'+id).val()
			},
			pass : cart.count
		});
		return false;
	},

	toggle : function(refresh=false){
	// toggle: toggle cart
	// PARAM refresh : just reload the cart...

		// SHOW CART
		if (refresh || $('#page-A').is(':visible')) {
			cb.page('B');
			cb.load({
				to : "page-B",
				module : "cart",
				data : {
					req : "show"
				}
			});
		} 
		// HIDE CART
		else {
			cb.page('A');
		}
	},

	change : function(id){
	// change() : change qty
	// PARAM id : cart item id

		cb.api({
			module : "cart",
			data : {
				req : "change",
				product_id : id,
				qty : $('#cart-qty-'+id).val()
			},
			pass : function(){
				cart.toggle(true);
				cart.count();
			}
		});
	},

	remove : function(id){
	// remove() : remove item from cart
	// PARAM id : cart item id

		cb.api({
			module : "cart",
			data : {
				req : "remove",
				product_id : id,
				qty : 0
			},
			pass : function(){
				cart.toggle(true);
				cart.count();
			}
		});
	},

	out : function(){
	// out() : checkout confirm

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> تأكيد",
			body : "هل فعلا تريد تنفيذ عملية الشراء؟",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="cart.goout()"><i class="fa fa-check"></i></button>'
		});
	},

	goout : function(){
	// goout() : checkout

		cb.api({
			module : "cart",
			data : {
				req : "checkout"
			},
			notipass : 0,
			pass : function(){
				location.href = cb.rooturl+"thankyou";
			}
		});
	}
};

$(document).ready(function(){
	cart.count();
});


function showMorePics(el){
	var source = el.src;
	var image1= document.getElementById("productImage1");
	var image2= document.getElementById("productImage2");
	var image3= document.getElementById("productImage3");

	image1.src = source;
	var sourceClean = source.replace(/\.[^/.]+$/, "");

	console.log();


  url3 = sourceClean+"1.jpg";

 
	


var xhr = new XMLHttpRequest();
	    xhr.open("GET",url3,true);
	    xhr.onreadystatechange = function () {

	    	if (xhr.readyState == 4 && xhr.status== 200) {

	    		image2.src = url3;

	    	}else{

	    		image2.src= source; // the link to the main image

	    	}
	    }
 xhr.send();


url2 = sourceClean+"2.jpg";
 var xhr1 = new XMLHttpRequest();
 	    xhr1.open("GET",url2,true);
 	    xhr1.onreadystatechange = function () {

 	    	if (xhr.readyState == 4 && xhr.status== 200) {

 	    		image3.src = url2;

 	    	}else{

 	    		image3.src= source; // the link to the main image

 	    	}
 	    	$('#jebreelModal').modal('show');
 	    }
  xhr1.send();




	
	
}


