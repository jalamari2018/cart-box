<?php
/*
 * SITE_BOTTOM.PHP : BOTTOM HALF
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
 ?>
				</div>
				<div id="page-B"></div>
				<div id="page-C"></div>
				<div id="page-D"></div>
				<div id="page-E"></div>
			</div>
		</main>

		<!-- [FOOTER] -->
		<footer id="page-foot" class="container">
			<div>  &copy; <?=SITE_NAME?> <?=date("Y")?>. جميع الحقوق محفوظة.</div>
			<small> اتجار للبرمجيات</a></small>
		</footer>

		<!-- [CATFISH SCRIPTS] -->
		<script src="<?= URL_ROOT ?>public/jquery/jquery.min.js"></script>
		<script src="<?= URL_ROOT ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?= URL_ROOT ?>public/bootstrap-notify/bootstrap-notify.min.js"></script>
		<script src="<?= URL_ROOT ?>public/fontawesome/svg-with-js/js/fa-solid.min.js"></script>
		<script src="<?= URL_ROOT ?>public/fontawesome/svg-with-js/js/fontawesome.min.js"></script>
		<script src="<?=T_ASSET?>d-boxx.js"></script>
		<script>
		cb.rooturl = "<?=URL_ROOT?>";
		cb.apiurl = "<?=URL_API?>";
		cb.upurl = "<?=URL_UPLOADS?>";
		</script>
	</body>
</html>