<?php
	/* template name: basic */
	
	//slider layout
	$slider_gallery.= '<div class="wa_chpcs_image_carousel" id="wa_chpcs_image_carousel'.$id.'">';

	$slider_gallery.='<ul id="wa_chpcs_foo'.$id.'" style="height:'.$wa_chpcs_query_posts_item_height.'px; overflow: hidden;">';
	
	foreach($myposts as $wa_post) {

		$post_title = $wa_post->post_title; //post title 
		$post_link =  get_permalink($wa_post->ID); //post link
		$post_content = $wa_post->post_content; //post content
		$post_id=	$wa_post->ID; //post id
		$post_excerpt = $wa_post->post_excerpt;//post excerpt

		$text_type = $this->get_text_type($wa_post, $wa_chpcs_query_display_from_excerpt);

		//woocommerce get data
		if ( function_exists( 'get_product' ) ) {
		$_product = get_product( $wa_post->ID );
		} else {

			//check if woocommerce active
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   				$_product = new WC_Product( $wa_post->ID );
			}

		}

		$first_cat_name = $this->get_post_category_first_name($qp_post_type, $wa_post->ID);

		$slider_gallery.= '<li style="width:'.$wa_chpcs_query_posts_item_width.'px; height:'.$wa_chpcs_query_posts_item_height.'px;" id="wa_chpcs_foo_content'.$id.'" class="wa_chpcs_foo_content">';

		if($displayimage){

			$featured_img = '';
			$image = '';
			
			if($wa_chpcs_query_posts_image_type=='featured_image'){

			$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'featured_image', 'full',$id);		
			$image_thumb = $this->wa_chpcs_get_post_image($post_content, $post_id, 'featured_image', $wa_chpcs_query_image_size,$id);

			$img_id = get_post_thumbnail_id($post_id);
			$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);


			if($wa_chpcs_query_lazy_loading) {
			$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' src=".$lazy_img."  data-original='".$image_thumb . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}else{
			$featured_img = "<img alt='".$post_title."'  id='wa_chpcs_img_".$id."' src='".$image_thumb."' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}
			
			}else if(isset($wa_chpcs_query_posts_image_type)&&$wa_chpcs_query_posts_image_type=='first_image'){

				$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'first_image', 'full',$id);
				
			if($wa_chpcs_query_lazy_loading) {

				$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' src=".$lazy_img."  data-original='".$image. "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			
			}else{

				$featured_img = "<img  alt='".$post_title."'  id='wa_chpcs_img_".$id."' src='". $image. "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			
			}

				}else if($wa_chpcs_query_posts_image_type=='last_image') {

			$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'last_image', 'full',$id);
			
			if($wa_chpcs_query_lazy_loading) {
				$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' src=".$lazy_img."  data-original='".$image . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			
				} else {

				$featured_img = "<img alt='".$post_title."' id='wa_chpcs_img_".$id."' src='". $image . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
		
				}

			}

			//display category
			if($wa_chpcs_query_show_categories=='1') {

				$slider_gallery.= '<div class="wa_chpcs_slider_show_cats" id="wa_chpcs_slider_show_cats'.$id.'">'.$first_cat_name.'</a></div>';
			
			}

			$slider_gallery.= '<div class="wa_featured_img" style="margin: 2px; ">';
			//display image
			if($wa_chpcs_query_posts_lightbox) {

				$slider_gallery.= '<a href="'.$image.'" class="wa_chpcs_post_link">'.$featured_img;

					//display hover image
					if($wa_chpcs_image_hover_effect=='hover_image') { 

					$slider_gallery.= '<div class="wa_chpcs_overlay"></div>';

					}

				$slider_gallery.= '<div style="clear:both;"></div></a>'; 

			} else {
				
				$slider_gallery.= '<a href="'.$post_link.'" class="wa_chpcs_post_link">'.$featured_img;

					//display hover image
					if($wa_chpcs_image_hover_effect=='hover_image') { 

					$slider_gallery.= '<div class="wa_chpcs_overlay"></div>';

					}

				$slider_gallery.= '<div style="clear:both;"></div></a>'; 

			}

			$slider_gallery.= '</div>';

		}
		
		/**********   Post title, Post Description, read more  **********/

		//display post title
		if($wa_chpcs_query_posts_title=='1') {

			$slider_gallery.= '<div  class="wa_chpcs_slider_title" id="wa_chpcs_slider_title'.$id.'"><a style="color:'.$wa_chpcs_query_font_colour.';" style=" text-decoration:none;" href="'.$post_link.'">'.$post_title.'</a></div>';
		
		}

		//display excerpt
		if($wa_chpcs_query_posts_display_excerpt=='1') {

			$slider_gallery.= '<div style="color:'.$wa_chpcs_query_font_colour.';" class="wa_chpcs_foo_con" id="wa_chpcsjj_foo_con'.$id.'">'.$this->wa_chpcs_clean($text_type, $word_imit).'</div>';
		
		}

		//display read more text
		if($wa_chpcs_query_posts_display_read_more=='1') {

			$slider_gallery.= '<span style="color:'.$wa_chpcs_query_font_colour.';" class="wa_chpcs_more" id="wa_chpcs_more'.$id.'"><a style="color:'.$wa_chpcs_query_font_colour.';" href="'.$post_link.'">'.$wa_chpcs_read_more.'</a></span>';
		
		}

		$slider_gallery.= '</li>';
	}

	$slider_gallery.='</ul>';
	$slider_gallery.='<div class="wa_chpcs_clearfix"></div>';

	//show direction arrows
	if($wa_chpcs_show_controls=='1') {

	if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") {

		$slider_gallery.='<a class="wa_chpcs_prev_v" id="foo'.$id.'_prev" href="#"><span style="">›</span></a>';
		$slider_gallery.='<a class="wa_chpcs_next_v" id="foo'.$id.'_next" href="#"><span>‹</span></a>';
	
	} else {

		$slider_gallery.='<a class="wa_chpcs_prev" id="foo'.$id.'_prev" href="#"><span>‹</span></a>';
		$slider_gallery.='<a class="wa_chpcs_next" id="foo'.$id.'_next" href="#"><span>›</span></a>';

		}
	}

	//show pagination
	if($wa_chpcs_show_paging=='1') {

		$slider_gallery.='<div class="wa_chpcs_pagination" id="wa_chpcs_pager_'.$id.'"></div>';
	}

	$slider_gallery.='</div>';