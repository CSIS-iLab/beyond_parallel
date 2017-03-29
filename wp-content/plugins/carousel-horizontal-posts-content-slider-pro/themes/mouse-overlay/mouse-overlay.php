<?php
	/* template name: mouse-overlay */
	
	//slider layout
	$slider_gallery.= '<div class="wa_chpcs_image_carousel" id="wa_chpcs_image_carousel'.$id.'">';

	$slider_gallery.='<ul id="wa_chpcs_foo'.$id.'" style="height:'.$wa_chpcs_query_posts_item_height.'px; overflow: hidden;" >';
	
	foreach($myposts as $wa_post) {
	
		$post_title = $wa_post->post_title; //post title 
		$post_link =  get_permalink($wa_post->ID); //post link
		$post_content = $wa_post->post_content; //post content
		$post_id=	$wa_post->ID; //post id
		$post_excerpt = $wa_post->post_excerpt;//post excerpt

		$text_type = $this->get_text_type($wa_post, $wa_chpcs_query_display_from_excerpt);

		//get product category name
		$first_cat_name = $this->get_post_category_first_name($qp_post_type, $wa_post->ID);
		
		$slider_gallery.= '<li style="width:'.$wa_chpcs_query_posts_item_width.'px; height:'.$wa_chpcs_query_posts_item_height.'px;" id="wa_chpcs_foo_content'.$id.'" class="wa_chpcs_foo_content">';

		$slider_gallery.= '<div class="wa_chpcs_text_overlay_p_container"><div class="wa_chpcs_text_overlay_caption">'; 

		if($displayimage) {

			$featured_img = '';
			$image = '';

			if($wa_chpcs_query_posts_image_type=='featured_image'){

			$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'featured_image', 'full' , $id);		
			$image_thumb = $this->wa_chpcs_get_post_image($post_content, $post_id, 'featured_image', $wa_chpcs_query_image_size, $id);

			if($wa_chpcs_query_lazy_loading) {
			$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' data-original='".$image_thumb . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}else{
			$featured_img = "<img alt='".$post_title."'  id='wa_chpcs_img_".$id."' src='".$image_thumb."' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}
			
			}else if(isset($wa_chpcs_query_posts_image_type)&&$wa_chpcs_query_posts_image_type=='first_image'){

				$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'first_image', 'full', $id);
				
			if($wa_chpcs_query_lazy_loading) {
			$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' data-original='".$image. "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}else{
			$featured_img = "<img alt='".$post_title."'   id='wa_chpcs_img_".$id."' src='". $image. "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}

			}else if($wa_chpcs_query_posts_image_type=='last_image'){

				$image = $this->wa_chpcs_get_post_image($post_content, $post_id, 'last_image', 'full', $id);
			if($wa_chpcs_query_lazy_loading) {
			$featured_img = "<img alt='".$post_title."' class='wa_lazy'  id='wa_chpcs_img_".$id."' data-original='".$image . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}else{
			$featured_img = "<img alt='".$post_title."'   id='wa_chpcs_img_".$id."' src='". $image . "' width='". $wa_chpcs_query_posts_image_width . "' height='". $wa_chpcs_query_posts_image_height . "'  />";	
			}

			}

			//display image
			if($wa_chpcs_query_posts_lightbox){$slider_gallery.= '<a href="'.$image.'">'.$featured_img.'</a>';}else{
			$slider_gallery.= '<a href="'.$post_link.'">'.$featured_img.'</a>'; }

		}

		$slider_gallery.= '<div class="wa_chpcs_text_overlay_caption_overlay">';

		/**********   Post title, Post Description, read more  **********/

		//display post title
		if($wa_chpcs_query_posts_title=='1') {

			$slider_gallery.= '<div class="wa_chpcs_text_overlay_caption_overlay_title">';
			$slider_gallery.= '<br/><div style="color:'.$wa_chpcs_query_font_colour.';" class="wa_chpcs_slider_title" id="wa_chpcs_slider_title'.$id.'"><a style="color:'.$wa_chpcs_query_font_colour.';" style=" text-decoration:none;" href="'.$post_link.'">'.$post_title.'</a></div>';
			$slider_gallery.= '</div>';
		
		}


		//display category
		if($wa_chpcs_query_show_categories=='1') {

			$slider_gallery.= '<div class="wa_chpcs_slider_show_cats" id="wa_chpcs_slider_show_cats'.$id.'">'.$first_cat_name.'</a></div>';
			
		}

		//display excerpt
		$slider_gallery.= '<div class="wa_chpcs_text_overlay_caption_overlay_content">';

		if($wa_chpcs_query_posts_display_excerpt=='1') {

			$slider_gallery.= '<div style="color:'.$wa_chpcs_query_font_colour.';" class="wa_chpcs_foo_con" id="wa_chpcsjj_foo_con'.$id.'">'.$this->wa_chpcs_clean($text_type, $word_imit).'</div>';
		
		}
		//display read more text
		if($wa_chpcs_query_posts_display_read_more=='1') {

			$slider_gallery.= '<span style="color:'.$wa_chpcs_query_font_colour.';" class="wa_chpcs_more" id="wa_chpcs_more'.$id.'"><a style="color:'.$wa_chpcs_query_font_colour.';" href="'.$post_link.'">'.$wa_chpcs_read_more.'</a></span>';
		
		}


		
		$slider_gallery.= '</div></div></div></div></li>';
	}

	$slider_gallery.='</ul>';
	$slider_gallery.='<div class="wa_chpcs_clearfix"></div>';

	if($wa_chpcs_show_controls=='1') {

	if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") {

		$slider_gallery.='<a class="wa_chpcs_prev_v" id="foo'.$id.'_prev" href="#"><span style="">›</span></a>';
		$slider_gallery.='<a class="wa_chpcs_next_v" id="foo'.$id.'_next" href="#"><span>‹</span></a>';
	
	}else{

			$slider_gallery.='<a class="wa_chpcs_prev" id="foo'.$id.'_prev" href="#"><span>‹</span></a>';
			$slider_gallery.='<a class="wa_chpcs_next" id="foo'.$id.'_next" href="#"><span>›</span></a>';
		
		}
	}
	if($wa_chpcs_show_paging=='1') {

		$slider_gallery.='<div class="wa_chpcs_pagination" id="wa_chpcs_pager_'.$id.'"></div>';
	
	}
	$slider_gallery.='</div>';