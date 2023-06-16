<?php
echo "<div id='div_pagination'>";

	echo "<ul class='pagination' id='lst_pagination'>";
	 
	// first page button will be here
	// first page button
	echo "<li>";
		echo "<a onClick='search_campuses(1)' style='cursor: pointer !important;'>";
			echo "First";
		echo "</a>";
		/* echo "<a href='{$page_url}page={$prev_page}'>";
			echo "<span style='margin:0 .5em;'>&laquo;</span>";
		echo "</a>"; */
	echo "</li>";
	
		
	if($page>1){
	 
		$prev_page = $page - 1;
		echo "<li>";
			echo "<a onClick='search_campuses({$prev_page})' style='cursor: pointer !important;'>";
				echo "Previous &laquo;";
			echo "</a>";
			/* echo "<a href='{$page_url}page={$prev_page}'>";
				echo "<span style='margin:0 .5em;'>&laquo;</span>";
			echo "</a>"; */
		echo "</li>";
	}
	 
	// clickable page numbers will be here
	// clickable page numbers
	 
	 $total_rows = $_SESSION['campuses_count'];
	 //echo $total_rows;
	 
	// find out total pages
	$total_pages = ceil($total_rows / $records_per_page);

	//echo "<br />" . $records_per_page;
	//echo "<br />" . $total_pages;
	  
	// range of num links to show
	// $range = 1;
	$range = 5;
	 
	// display links to 'range of pages' around 'current page'
	$initial_num = $page - $range;
	$condition_limit_num = ($page + $range)  + 1;
	 
	for ($x=$initial_num; $x<$condition_limit_num; $x++) {
	 
		// be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
		if (($x > 0) && ($x <= $total_pages)) {
	 
			// current page
			if ($x == $page) {
				echo "<li class='active'>";
					echo "<a href='javascript:void(0);'>{$x}</a>";
				echo "</li>";
			}
	 
			// not current page
			else {
				echo "<li>";
				echo " <a onClick='search_campuses({$x})' style='cursor:pointer !important;'>{$x}</a> ";
					// echo " <a href='{$page_url}page={$x}' onClick='search_campuses({$x})' style='cursor:hand;'>{$x}</a> ";
				echo "</li>";
			}
		}
	}
	 
	// last page button will be here
	// last page button
	if($page<$total_pages){
		$next_page = $page + 1;
	 
		echo "<li>";
			echo "<a onClick='search_campuses({$next_page})' style='cursor: pointer !important;'>";
				echo "Next &raquo;";
			echo "</a>";
			/* echo "<a href='{$page_url}page={$next_page}'>";
				echo "<span style='margin:0.5em;'>&raquo;</span>";
			echo "</a>"; */
		echo "</li>";
	}



		echo "<li>";
			echo "<a onClick='search_campuses({$total_pages})' style='cursor: pointer !important;'>";
				echo "Last";
			echo "</a>";
			/* echo "<a href='{$page_url}page={$next_page}'>";
				echo "<span style='margin:0.5em;'>&raquo;</span>";
			echo "</a>"; */
		echo "</li>";
		
				
	echo "</ul>";



	echo '<div id="div_page_navigation">';   

		echo '<input id="txt_page" type="number" min="1" max="' . $total_pages . '" placeholder="' .  $page . '/' . $total_pages . '" required />';   
		
		echo'<button class="btn btn-success btn_go_to_page" onClick="go2Page(' . $total_pages . ');">Go</button>';

		//echo '<label id="lbl_page">' .  $page . '/' . $total_pages . '</label>';   

	echo '</div>';




echo '</div>';
	
?>