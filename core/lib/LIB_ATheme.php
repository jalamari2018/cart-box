<?php
/*
 * CLASS ATHEME : THEME HTML STUFF
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class ATheme {
	function paginate($all=1,$pnow=1,$base=""){
	// paginate() : bootstrap pagination
	// PARAM $all : total number of pages
	//       $pnow : current page
	//       $base : base JS function

		echo '<nav class="sublist-pg"><ul class="pagination">';
		for ($i=1;$i<=$all;$i++) {
			printf('<li class="page-item%s"><span class="page-link" onclick="%s(%s)">%s</span></li>',
				$i==$pnow ? " active" : "",
				$base, $i, $i
			);
		}
		echo '</ul></nav>';
	}
}
?>