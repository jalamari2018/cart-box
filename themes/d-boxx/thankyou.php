<?php
/*
 * ACTIVATE.PHP : FORGOT PASSWORD & ACCOUNT ACTIVATE PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME . "lib" . DIRECTORY_SEPARATOR . "site_def.php";

// HTML
require T_LIB . "site_top.php"; ?>
<div class="lost">
	<img src="<?= T_ASSET ?>ok.jpg">
	<h2>شكرا على التعامل معنا </h2>
	<div class="alert alert-success" role="alert">
	الرجاء التواصل معنا عبر المحاثة الفوريه أسفل الصفحة أو الإرسال 

			 <a href="https://wa.me/+966XXXXXX" class="btn btn-outline-success btn-block">   عبرالوتس اب الرقم الأول

         <a href="https://wa.me/+966XXXXXX" class="btn btn-outline-success btn-block">   عبرالوتس اب الرقم الثاني 

</a>
     </div>

	
	<a href="<?= URL_ROOT ?>" class='btn btn-danger'>عودة للمعرض </a>
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c88962fc37db86fcfcd785e/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</div>
<?php require T_LIB . "site_bottom.php"; ?>