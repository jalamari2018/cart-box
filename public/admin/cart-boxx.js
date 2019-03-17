/*
 * CART-BOXX.JS : ADMIN PAGE JS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

var cb = {
	/* [LOADING BLOCK] */
	block : function(){
	// block() : block the page

		$('#page-loader').addClass("active");
	},

	unblock : function(){
	// unblock() : unblock the page

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

	/* [SIDE BAR] */
	togside : function(){
	// togside() : TOGGLE SIDE BAR

		$('#page-sidebar').toggleClass('active');
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
		opt.failtitle = opt.failtitle ? opt.failtitle : "<i class='fa fa-exclamation-triangle'></i> حصل خطأ";
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
				alert("خطأ في النظام ");
				if (opt.debug) { console.log(res); }
			}
		})
		.fail(function(res){
			alert("خطأ في النظام الخادم لا يستجيب");
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
			url: this.admurl + "AJAX/" + opt.module,
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
			alert("خطأ في النظام الخادم لا يستجيب ");
			if (opt.debug) { console.log(res); }
		});
	},

	page : function(pg){
	// page() : switch to page (ABCDE)

		$('#page-A, #page-B, #page-C, #page-D, #page-E').hide();
		$('#page-'+pg).show();
	},

	/* [SIGN OFF] */
	bye : function(){
	// bye() : sign off user

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> تأكيد",
			body : "هل تريد بالفعل تسجيل الخروج؟",
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
				location.href = cb.admurl;
			}
		});
	}
};