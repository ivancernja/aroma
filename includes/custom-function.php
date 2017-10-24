<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, CHILD_DIR . '/languages' );

	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');

	function myHelpPointers() {

	//First we define our pointers 
	$pointers = array(
		array(
			'id'       => 'xyz1', // unique id for this pointer
			'screen'   => 'options-permalink', // this is the page hook we want our pointer to show on
			'target'   => '#submit', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("submit_permalink"),
			'content'  => theme_locals("submit_permalink_desc"),
			'position' => array( 
								'edge'   => 'top', //top, bottom, left, right
								'align'  => 'left', //top, bottom, left, right, middle
								'offset' => '0 5'
								)
			),

		array(
			'id'       => 'xyz2', // unique id for this pointer
			'screen'   => 'themes', // this is the page hook we want our pointer to show on
			'target'   => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("import_sample_data"),
			'content'  => theme_locals("import_sample_data_desc"),
			'position' => array( 
								'edge'   => 'bottom', //top, bottom, left, right
								'align'  => 'top', //top, bottom, left, right, middle
								'offset' => '0 -10'
								)
			),

		array(
			'id'       => 'xyz3', // unique id for this pointer
			'screen'   => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
			'target'   => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("import_sample_data"),
			'content'  => theme_locals("import_sample_data_desc_2"),
			'position' => array( 
								'edge'   => 'left', //top, bottom, left, right
								'align'  => 'top', //top, bottom, left, right, middle
								'offset' => '0 18'
								)
			)
		// more as needed
		);

		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers);
	};

	add_filter( 'cherry_stickmenu_selector', 'cherry_change_selector' );
	function cherry_change_selector($selector) {
	    $selector = 'header.header';
	    return $selector;
	}

	/**
	 * Banner
	 *
	 */
	if (!function_exists('banner_shortcode')) {

		function banner_shortcode($atts, $content = null) {
			extract(shortcode_atts(
				array(
					'img'          => '',
					'banner_link'  => '',
					'title'        => '',
					'text'         => '',
					'btn_text'     => '',
					'target'       => '',
					'custom_class' => ''
			), $atts));

			// get attribute
			$content_url = content_url();
			$content_str = 'wp-content';

			$pos = strpos($img, $content_str);
			if ($pos !== false) {
				$img_new = substr( $img, $pos+strlen($content_str), strlen($img)-$pos );
				$img     = $content_url.$img_new;
			}

			$output =  '<div class="banner-wrap '.$custom_class.'">'; 
			if ($img !="") {
				$output .= '<figure class="featured-thumbnail">';
				if ($banner_link != "") {
					$output .= '<a href="'. $banner_link .'" title="'. $title .'"><img src="' . $img .'" title="'. $title .'" alt="" /></a>';
				} else {
					$output .= '<img src="' . $img .'" title="'. $title .'" alt="" />';
				}
				$output .= '<div class="desc"><div class="inner">';
					if ($title!="") {
						$output .= '<h5>';
						$output .= $title;
						$output .= '</h5>';
					}
					if ($text!="") {
						$output .= '<p>';
						$output .= $text;
						$output .= '</p>';
					}
					if ($btn_text!="") {
						$output .=  '<div class="link-align banner-btn"><a href="'.$banner_link.'" title="'.$btn_text.'" class="btn btn-link" target="'.$target.'">';
						$output .= $btn_text;
						$output .= '</a></div>';
					} else {
						$output .=  '<div class="link-align banner-btn-alt"><a href="'.$banner_link.'" target="'.$target.'">';
						$output .= '<i class="icon-link"></i>';
						$output .= '</a></div>';
					}
				$output .= '</div></div>';
				$output .= '</figure>';
			}
			
			$output .= '</div><!-- .banner-wrap (end) -->';
			return $output;

		}
		add_shortcode('banner', 'banner_shortcode');
	}

	/**
	 * Service Box
	 *
	 */
	if (!function_exists('service_box_shortcode')) {

		function service_box_shortcode($atts, $content = null) { 
			extract(shortcode_atts(
				array(
					'title'        => '',
					'subtitle'     => '',
					'icon'         => '',
					'text'         => '',
					'btn_text'     => '',
					'btn_link'     => '',
					'btn_size'     => '',
					'target'       => '',
					'custom_class' => ''
			), $atts));
			
			$output =  '<div class="service-box '.$custom_class.'">';
		
			if($icon != 'no'){
				$icon_url = CHERRY_PLUGIN_URL . 'includes/assets/images/' . strtolower($icon) . '.png' ;
				if( defined ('CHILD_DIR') ) {
					if(file_exists(CHILD_DIR.'/images/'.strtolower($icon).'.png')){
						$icon_url = CHILD_URL.'/images/'.strtolower($icon).'.png';
					}
				}
				$output .= '<figure class="icon"><img src="'.$icon_url.'" alt="" /></figure>';
			}

			$output .= '<div class="service-box_body">';

			if ($title!="") {
				$output .= '<h2 class="title">';
				$output .= $title;
				$output .= '</h2>';
			}
			if ($subtitle!="") {
				$output .= '<h5 class="sub-title">';
				$output .= $subtitle;
				$output .= '</h5>';
			}
			$output .= '<div class="service-box_desc">';
				if ($text!="") {
					$output .= '<div class="service-box_txt">';
					$output .= $text;
					$output .= '</div>';
				}
				if (($btn_link!="") and ($btn_text!="")) {
					$output .=  '<div class="btn-align"><a href="'.$btn_link.'" title="'.$btn_text.'" class="btn btn-inverse btn-'.$btn_size.' btn-primary " target="'.$target.'">';
					$output .= $btn_text;
					$output .= '</a></div>';
				} elseif ($btn_link!="") {
					$output .=  '<div class="btn-align btn-align_alt"><a href="'.$btn_link.'" class="arrow-link" target="'.$target.'">';
					$output .= '';
					$output .= '</a></div>';
				}
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div><!-- /Service Box -->';
			return $output;
		}
		add_shortcode('service_box', 'service_box_shortcode');

	}

	/**
	 * Post Grid
	 *
	 */
	if (!function_exists('posts_grid_shortcode')) {

		function posts_grid_shortcode($atts, $content = null) {
			extract(shortcode_atts(array(
				'type'            => 'post',
				'category'        => '',
				'custom_category' => '',
				'columns'         => '3',
				'rows'            => '3',
				'order_by'        => 'date',
				'order'           => 'DESC',
				'thumb_width'     => '370',
				'thumb_height'    => '250',
				'meta'            => '',
				'excerpt_count'   => '15',
				'link'            => 'yes',
				'link_text'       => __('Read more', CHERRY_PLUGIN_DOMAIN),
				'custom_class'    => ''
			), $atts));

			$spans = $columns;
			$rand  = rand();

			// columns
			switch ($spans) {
				case '1':
					$spans = 'span12';
					break;
				case '2':
					$spans = 'span6';
					break;
				case '3':
					$spans = 'span4';
					break;
				case '4':
					$spans = 'span3';
					break;
				case '6':
					$spans = 'span2';
					break;
			}

			// check what order by method user selected
			switch ($order_by) {
				case 'date':
					$order_by = 'post_date';
					break;
				case 'title':
					$order_by = 'title';
					break;
				case 'popular':
					$order_by = 'comment_count';
					break;
				case 'random':
					$order_by = 'rand';
					break;
			}

			// check what order method user selected (DESC or ASC)
			switch ($order) {
				case 'DESC':
					$order = 'DESC';
					break;
				case 'ASC':
					$order = 'ASC';
					break;
			}

			// show link after posts?
			switch ($link) {
				case 'yes':
					$link = true;
					break;
				case 'no':
					$link = false;
					break;
			}

				global $post;
				global $my_string_limit_words;

				$numb = $columns * $rows;

				// WPML filter
				$suppress_filters = get_option('suppress_filters');

				$args = array(
					'post_type'         => $type,
					'category_name'     => $category,
					$type . '_category' => $custom_category,
					'numberposts'       => $numb,
					'orderby'           => $order_by,
					'order'             => $order,
					'suppress_filters'  => $suppress_filters
				);

				$posts      = get_posts($args);
				$i          = 0;
				$count      = 1;
				$output_end = '';
				if ($numb > count($posts)) {
					$output_end = '</ul>';
				}

				$output = '<ul class="posts-grid row-fluid unstyled '. $custom_class .'">';

				$latest = get_posts($args);
		
				foreach($latest as $j => $post) {
					// Unset not translated posts
					if ( function_exists( 'wpml_get_language_information' ) ) {
						global $sitepress;

						$check              = wpml_get_language_information( $posts[$j]->ID );
						$language_code      = substr( $check['locale'], 0, 2 );
						if ( $language_code != $sitepress->get_current_language() ) unset( $posts[$j] );

						// Post ID is different in a second language Solution
						if ( function_exists( 'icl_object_id' ) ) $posts[$j] = get_post( icl_object_id( $posts[$j]->ID, $type, true ) );
					}
					$post_id        = $posts[$j]->ID;
					setup_postdata($posts[$j]);
					$excerpt        = get_the_excerpt();
					$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
					$url            = $attachment_url['0'];
					$image          = aq_resize($url, $thumb_width, $thumb_height, true);
					$mediaType      = get_post_meta($post_id, 'tz_portfolio_type', true);
					$prettyType     = 0;

					if ($count > $columns) {
						$count = 1;
						$output .= '<ul class="posts-grid row-fluid unstyled '. $custom_class .'">';
					}

					$output .= '<li class="'. $spans .'">';
						if(has_post_thumbnail($post_id) && $mediaType == 'Image') {

							$prettyType = 'prettyPhoto-'.$rand;

							$output .= '<figure class="featured-thumbnail thumbnail">';
							$output .= '<a href="'.$url.'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
							$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
							$output .= '<span class="zoom-icon"></span></a></figure>';
						} elseif ($mediaType != 'Video' && $mediaType != 'Audio') {

							$thumbid = 0;
							$thumbid = get_post_thumbnail_id($post_id);

							$images = get_children( array(
								'orderby'        => 'menu_order',
								'order'          => 'ASC',
								'post_type'      => 'attachment',
								'post_parent'    => $post_id,
								'post_mime_type' => 'image',
								'post_status'    => null,
								'numberposts'    => -1
							) ); 

							if ( $images ) {

								$k = 0;
								//looping through the images
								foreach ( $images as $attachment_id => $attachment ) {
									$prettyType = "prettyPhoto-".$rand ."[gallery".$i."]";
									//if( $attachment->ID == $thumbid ) continue;

									$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
									$img = aq_resize( $image_attributes[0], $thumb_width, $thumb_height, true ); //resize & crop img
									$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
									$image_title = $attachment->post_title;

									if ( $k == 0 ) {
										if (has_post_thumbnail($post_id)) {
											$output .= '<figure class="featured-thumbnail thumbnail">';
											$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
											$output .= '<img src="'.$image.'" alt="'.get_the_title($post_id).'" />';
										} else {
											$output .= '<figure class="featured-thumbnail thumbnail">';
											$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
											$output .= '<img  src="'.$img.'" alt="'.get_the_title($post_id).'" />';
										}
									} else {
										$output .= '<figure class="featured-thumbnail thumbnail" style="display:none;">';
										$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
									}
									$output .= '<span class="zoom-icon"></span></a></figure>';
									$k++;
								}
							} elseif (has_post_thumbnail($post_id)) {
								$prettyType = 'prettyPhoto-'.$rand;
								$output .= '<figure class="featured-thumbnail thumbnail">';
								$output .= '<a href="'.$url.'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
								$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
								$output .= '<span class="zoom-icon"></span></a></figure>';
							}
						} else {

							// for Video and Audio post format - no lightbox
							$output .= '<figure class="featured-thumbnail thumbnail"><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">';
							$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
							$output .= '</a></figure>';
						}

						$output .= '<div class="clear"></div>';

						$output .= '<h5><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">';
							$output .= get_the_title($post_id);
						$output .= '</a></h5>';

						if ($meta == 'yes') {
							// begin post meta
							$output .= '<div class="post_meta">';

								// post category
								$output .= '<span class="post_category">';
								if ($type!='' && $type!='post') {
									$terms = get_the_terms( $post_id, $type.'_category');
									if ( $terms && ! is_wp_error( $terms ) ) {
										$out = array();
										$output .= '<em>Posted in </em>';
										foreach ( $terms as $term )
											$out[] = '<a href="' .get_term_link($term->slug, $type.'_category') .'">'.$term->name.'</a>';
											$output .= join( ', ', $out );
									}
								} else {
									$categories = get_the_category($post_id);
									if($categories){
										$out = array();
										$output .= '<em>Posted in </em>';
										foreach($categories as $category)
											$out[] = '<a href="'.get_category_link($category->term_id ).'" title="'.$category->name.'">'.$category->cat_name.'</a> ';
											$output .= join( ', ', $out );
									}
								}
								$output .= '</span>';

								// post date
								$output .= '<span class="post_date">';
								$output .= '<time datetime="'.get_the_time('Y-m-d\TH:i:s', $post_id).'">' .get_the_date(). '</time>';
								$output .= '</span>';

								// post author
								$output .= '<span class="post_author">';
								$output .= '<em> by </em>';
								$output .= '<a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('display_name').'</a>';
								$output .= '</span>';

								// post comment count
								$num = 0;
								$queried_post = get_post($post_id);
								$cc = $queried_post->comment_count;
								if( $cc == $num || $cc > 1 ) : $cc = $cc.' Comments';
								else : $cc = $cc.' Comment';
								endif;
								$permalink = get_permalink($post_id);
								$output .= '<span class="post_comment">';
								$output .= '<a href="'. $permalink . '" class="comments_link">' . $cc . '</a>';
								$output .= '</span>';
							$output .= '</div>';
							// end post meta
						}
						$output .= cherry_get_post_networks(array('post_id' => $post_id, 'display_title' => false, 'output_type' => 'return'));
						if ($excerpt_count >= 1){
							$output .= '<p class="excerpt">';
								$output .= my_string_limit_words($excerpt,$excerpt_count);
							$output .= '</p>';
						}
						if($link){
							$output .= '<a href="'.get_permalink($post_id).'" class="btn btn-link btn-normal" title="'.get_the_title($post_id).'">';
							$output .= $link_text;
							$output .= '</a>';
						}
						$output .= '</li>';
						if ($j == count($posts)-1) {
							$output .= $output_end;
						}
					if ($count % $columns == 0) {
						$output .= '</ul><!-- .posts-grid (end) -->';
					}
				$count++;
				$i++;

			} // end for

			return $output;
		}
		add_shortcode('posts_grid', 'posts_grid_shortcode');
	}

	/**
	 * Mini Post List
	 *
	 */
	if (!function_exists('mini_posts_list_shortcode')) {

		function mini_posts_list_shortcode($atts, $content = null) {
			extract(shortcode_atts(array(
				'type'          => 'post',
				'numb'          => '3',
				'thumbs'        => '',
				'thumb_width'   => '',
				'thumb_height'  => '',
				'meta'          => '',
				'order_by'      => '',
				'order'         => '',
				'excerpt_count' => '0',
				'custom_class'  => ''
			), $atts));

			$template_url = get_template_directory_uri();

			// check what order by method user selected
			switch ($order_by) {
				case 'date':
					$order_by = 'post_date';
					break;
				case 'title':
					$order_by = 'title';
					break;
				case 'popular':
					$order_by = 'comment_count';
					break;
				case 'random':
					$order_by = 'rand';
					break;
			}

			// check what order method user selected (DESC or ASC)
			switch ($order) {
				case 'DESC':
					$order = 'DESC';
					break;
				case 'ASC':
					$order = 'ASC';
					break;
			}

			// thumbnail size
			$thumb_x = 0;
			$thumb_y = 0;
			if (($thumb_width != '') && ($thumb_height != '')) {
				$thumbs = 'custom_thumb';
				$thumb_x = $thumb_width;
				$thumb_y = $thumb_height;
			} else {
				switch ($thumbs) {
					case 'small':
						$thumb_x = 110;
						$thumb_y = 110;
						break;
					case 'smaller':
						$thumb_x = 90;
						$thumb_y = 90;
						break;
					case 'smallest':
						$thumb_x = 60;
						$thumb_y = 60;
						break;
				}
			}

				global $post;
				global $my_string_limit_words;

				// WPML filter
				$suppress_filters = get_option('suppress_filters');

				$args = array(
					'post_type'        => $type,
					'numberposts'      => $numb,
					'orderby'          => $order_by,
					'order'            => $order,
					'suppress_filters' => $suppress_filters
				);

				$posts = get_posts($args);
				$i = 0;

				$output = '<ul class="mini-posts-list '.$custom_class.'">';
				
				foreach($posts as $key => $post) {
					// Unset not translated posts
					if ( function_exists( 'wpml_get_language_information' ) ) {
						global $sitepress;

						$check              = wpml_get_language_information( $post->ID );
						$language_code      = substr( $check['locale'], 0, 2 );
						if ( $language_code != $sitepress->get_current_language() ) unset( $posts[$key] );

						// Post ID is different in a second language Solution
						if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, $type, true ) );
					}
					setup_postdata($post);
					$excerpt        = get_the_excerpt();
					$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
					$url            = $attachment_url['0'];
					$image          = aq_resize($url, $thumb_x, $thumb_y, true);
					$mediaType      = get_post_meta($post->ID, 'tz_portfolio_type', true);
					$format         = get_post_format();

						//$output .= '<div class="row-fluid">';
						$output .= '<li class="mini-post-holder clearfix">';

						//post thumbnail
						if ($thumbs != 'none') {

							if ((has_post_thumbnail($post->ID)) && ($format == 'image' || $mediaType == 'Image')) {

								$output .= '<figure class="a featured-thumbnail thumbnail '.$thumbs.'">';
								$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
								$output .= '</a></figure>';

							} elseif ($mediaType != 'Video' && $mediaType != 'Audio') {

								$thumbid = 0;
								$thumbid = get_post_thumbnail_id($post->ID);
								$images = get_children( array(
									'orderby'        => 'menu_order',
									'order'          => 'ASC',
									'post_type'      => 'attachment',
									'post_parent'    => $post->ID,
									'post_mime_type' => 'image',
									'post_status'    => null,
									'numberposts'    => -1
								) ); 

								if ( $images ) {

									$k = 0;
									//looping through the images
									foreach ( $images as $attachment_id => $attachment ) {
										//$prettyType = "prettyPhoto[gallery".$i."]";
										//if( $attachment->ID == $thumbid ) continue;

										$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
										$img = aq_resize($image_attributes[0], $thumb_x, $thumb_y, true);  //resize & crop img
										$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
										$image_title = $attachment->post_title;

										if ( $k == 0 ) {
											if (has_post_thumbnail($post->ID)) {
												$output .= '<figure class="featured-thumbnail thumbnail">';
												$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
												$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
											} else {
												$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
												$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
												$output .= '<img  src="'.$img.'" alt="'.get_the_title($post->ID).'" />';
											}
										}
										$output .= '</a></figure>';
										$k++;
									}
								} elseif (has_post_thumbnail($post->ID)) {
									//$prettyType = 'prettyPhoto';
									$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
									$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
									$output .= '</a></figure>';
								}
								else {
									// empty_featured_thumb.gif - for post without featured thumbnail
									$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
									$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= '<img src="'.$template_url.'/images/empty_thumb.gif" alt="'.get_the_title($post->ID).'" />';
									$output .= '</a></figure>';
								}
							} else {

								// for Video and Audio post format - no lightbox
								$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
								$output .= '</a></figure>';
							}
						}

							//mini post content
							$output .= '<div class="mini-post-content">';
								$output .= '<h4><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= get_the_title($post->ID);
								$output .= '</a></h4>';
								if ($meta == 'yes') {
									// mini post meta
									$output .= '<div class="mini-post-meta">';
										$output .= '<time datetime="'.get_the_time('Y-m-d\TH:i:s', $post->ID).'"> <span>' .get_the_date(). '</span></time>';
									$output .= '</div>';
								}
								$output .= cherry_get_post_networks(array('post_id' => $post->ID, 'display_title' => false, 'output_type' => 'return'));
								if ($excerpt_count >= 1){
									$output .= '<div class="excerpt">';
										$output .= my_string_limit_words($excerpt,$excerpt_count);
									$output .= '</div>';
								}
							$output .= '</div>';
							$output .= '</li>';
							$i++;

				} // end foreach

				$output .= '</ul><!-- .mini-posts-list (end) -->';
				return $output;
		} 
		add_shortcode('mini_posts_list', 'mini_posts_list_shortcode');
		
	}

	// Fullwidth Box
	if (!function_exists('fullwidth_box_shortcode')) {
		function fullwidth_box_shortcode($atts, $content = null) {
			$output = '<div class="fullwidth-box">';
			$output .= do_shortcode($content);
			$output .= '</div>';

			return $output;
		}
		add_shortcode('fullwidth_box', 'fullwidth_box_shortcode');
	}

	/*-----------------------------------------------------------------------------------*/
	/* Custom Comments Structure
	/*-----------------------------------------------------------------------------------*/
	if ( !function_exists( 'mytheme_comment' ) ) {
		function mytheme_comment($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
				<div class="wrapper">
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
						<?php printf('<span class="author">%1$s</span>', get_comment_author_link()) ?>
					</div>
					<?php if ($comment->comment_approved == '0') : ?>
						<em><?php echo theme_locals("your_comment") ?></em>
					<?php endif; ?>
					<div class="extra-wrap">
						<?php comment_text() ?>
					</div>
				</div>
				<div class="wrapper">
					<div class="reply">
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
					<div class="comment-meta commentmetadata"><?php printf('%1$s', get_comment_date()) ?></div>
				</div>
			</div>
	<?php }
	}

?>