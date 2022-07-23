<?php 

if( !function_exists( 'storm_infinite_posts' )){

	function storm_infinite_posts(){

		$filter = (isset($_GET['filter'])) ? $_GET['filter'] : 'all' ;
		$paged = (isset($_GET['paged'])) ? $_GET['paged'] : 1 ;
		$cats = (isset($_GET['cat'])) ? $_GET['cat'] : null ;
		
		$posts = storm_get_posts($filter, $paged);

		echo $posts;

		die();
	}

	add_action('wp_ajax_storm_infinite_posts','storm_infinite_posts');
	add_action('wp_ajax_nopriv_storm_infinite_posts','storm_infinite_posts');

}

if( !function_exists( 'storm_get_posts' ) ){

	function storm_get_posts( $filter = 'all', $page = 1, $cats = null, $year = null, $yearmonth = null ){

		if($filter=='all'){
			$post_types = array('post');
		} else {
			$post_types = $filter;
		}

		// Default Arguements
		$args = array(
			'post_type' => $post_types,
			'post_status' => 'publish',
			'orderby' => 'post_date', 
			'order' => 'DESC',
			'paged' => $page
		);

		// Archive posts Year
		if($year !== null){
			$args['year'] = $year;
		}

		// Archive Posts Year and Month
		if($yearmonth !== null){
			$args['m'] = $yearmonth;
		}

		// Category
		if($cats!==null){
			$args['cat'] = $cats;
		}

		$posts = new WP_Query( $args );

		$html = '';
		$amount = 0;

		if( $posts->have_posts() ){

			$postcount = 1;
			
			while($posts->have_posts()){
				$posts->the_post();
				$post_type = get_post_type();
				
				ob_start();
				set_query_var( 'postcount', $postcount );
				if ( 'post' == get_post_type() ){ 
					get_template_part( 'templates/post','news' );
				} 	
				$html .= ob_get_contents();
		   		ob_end_clean();

	   			$postcount++;
	   			$amount++;
			}

			$response = true;
		
		} else {
		
			$response = false;
		
		}

		return json_encode( array('response' => $response, 'html' => $html, 'amount' => $amount ) );

	}
}