<?php
/*
Plugin Name: Posts for Page Plugin
Plugin URI: http://www.mywebdeveloperblog.com/development/wordpress/posts-for-page-wordpress-plugin
Description: This plugin allows for posts to be assigned to pages as snippets or full posts. Posts can be selected by category slug, category id, tag slug, single post id, author and ordered by date or title.
Version: 1.71
Author: Simon Hibbard
Author URI: http://www.mywebdeveloperblog.com/
License: GPL2
*/
?>
<?php

//tell wordpress to register the children-excerpt shortcode
add_shortcode("posts-for-page", "sc_posts_for_page");

function remove_images( $content ) {
   $postOutput = preg_replace('/<img[^>]+./','', $content);
   return $postOutput;
}

function robins_get_the_excerpt($post_id) {
  global $post;  
  $save_post = $post;
  $post = get_post($post_id);
  $output = get_the_excerpt();
  $post = $save_post;
  //return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
  return $output;
}


//children excerpt shortcode worker function
function sc_posts_for_page($atts, $content = null){
		
	if($atts['length'] > 0 ){
	}else{
		$atts['length'] = 50;
	}
	//echo $atts['read_more'];
	if($atts['read_more'] != "" ){
		$_opts['readMoreText'] = $atts['read_more'];
	}else{
		$_opts['readMoreText'] = "Read More &raquo;";
	}

	if($atts['prev_text'] != "" ){
		$_opts['prevText'] = $atts['prev_text'];
	}else{
		$_opts['prevText'] = "&laquo; Newer Entries";
	}

	if($atts['next_text'] != "" ){
		$_opts['nextText'] = $atts['next_text'];
	}else{
		$_opts['nextText'] = "Older Entries &raquo; ";
	}

	// set values from the shortcode
	$_opts['cat_slug'] = $atts['cat_slug'];
	$_opts['cat'] = $atts['cat'];
	$_opts['tag_slug'] = $atts['tag_slug'];
	$_opts['order_by'] = $atts['order_by'];
	$_opts['post_id'] = $atts['post_id'];
	$_opts['author'] = $atts['author'];
	$_opts['num'] = $atts['num'];
	
	$_opts['showFullPost'] = $atts['show_full_posts'];

	global $paged;
	
	if (empty($paged)) {
			$_opts['cur_page'] = 1;
	}
	else
	{
		$_opts['cur_page'] = $paged;
	}

	$_opts['hide_images'] = $atts['hide_images'];
	$_opts['use_wp_excerpt'] = $atts['use_wp_excerpt'];
	$_opts['strip_html'] = $atts['strip_html'];
	$_opts['hide_post_content'] = $atts['hide_post_content'];
	$_opts['show_meta'] = $atts['show_meta'];
	$_opts['hide_post_title'] = $atts['hide_post_title'];
    $_opts['hide_read_more'] = $atts['hide_read_more'];
    $_opts['create_para_tags'] = $atts['create_para_tags'];
    $_opts['order'] = $atts['order'];
    
	//get the id of the current article that is calling the shortcode
	$parent_id = get_the_ID();
	
	$output = "";
	
	$i = 0;
	
	$children  = pfp_get_posts($_opts);

	if (is_array($children))
	{
		if(count($children) <= 0){
			$out = "<strong>Items for Page:</strong> There are no posts that match the selection criteria.";
			return $out;
		}

		foreach( $children as $child ) {
			$title = $child->post_title;
			$link = get_permalink($child->ID);
			$content;
			$date;
			$thumb = get_the_post_thumbnail($child->ID,array(60, 60, true));
			$imageSrc = "";

            if($_opts['create_para_tags'] == "true")
            {
                $content = wpautop($child->post_content);
                //echo "wpautop";
            }
            else
            {
                $content = $child->post_content;
                //echo "no wpautop";
            }
            

			if($_opts['showFullPost'] != "true")
			{

				if($_opts['hide_images'] != 'true')
				{
					$args = array(
					'numberposts' => 1,
					'order'=> 'ASC',
					'post_mime_type' => 'image',
					'post_parent' => $child->ID ,
					'post_status' => null,
					'post_type' => 'attachment'
					);
					//get the first image and resize it 
					$attachments = get_children( $args );
					//echo "here" .$_opts['imageH'];
					if ($attachments) {
						foreach($attachments as $attachment) {				
							$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )  ? wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );
							$imageSrc = '<img src="'.wp_get_attachment_thumb_url( $attachment->ID ).'" />';
						}
					}	
				}

				if($_opts['use_wp_excerpt'] == 'true')
				{					
					// use wp excerpt function
					//$post = get_post($post_id);
					setup_postdata($child);
					$content = robins_get_the_excerpt($child->ID);
				}
				else
				{   
					// remove all images from the post
                    if($_opts['hide_images'] == 'true')
                    {
					    $content = remove_images($content);		
                    }
                    else
                    {
                        $content = ($content);		
                    }
          
					if($_opts['strip_html'] == 'true')
					{
						$content = strip_tags($content);
					}
					//split excerpt into array for processing
					$words = explode(' ', $content);
			
					//chop off the excerpt based on the atts->lenth
					$words = array_slice($words, 0, $atts['length']);
			
					//merge the array of words for the excerpt back into sentances
					$content = implode(' ', $words) . "...";	
				}	
			} 	
			
			// output post

			$output .= "<div class='pfpItem entry-content'>";
			
			if($_opts['hide_post_title'] != 'true')
			{
				$output .= "<h2 class='entry-title'><a href='$link'>$title</a></h2>";
			}
			if($_opts['show_meta'] == 'true')
			{
				$userid = $child->post_author;
				$userdata = get_userdata($userid); 
				$output .= "<div class='entry-meta'>";
				$output .= "Posted on " . mysql2date('F j, Y',$child->post_date) . " by " . $userdata->user_nicename;
				$output .= "</div>";
			}
			// do not get any content if it is to be hidden (i.e. show titles only)
			if($_opts['hide_post_content'] != 'true')
			{
				//if($_opts['hide_images'] != 'true')
				//{
					//$output .= $imageSrc;
				//}
				$output .= $content;
                if( ($_opts['hide_read_more'] != 'true') && ($_opts['use_wp_excerpt'] != 'true'))
                {    
				    $output .= "<a href='$link' class='pfpReadMore'>" . $_opts['readMoreText'] . "</a>";
                }
			}
			$output .= "<div class='clear'></div>";

			$output .= "<hr>";				
			$output .= "</div>";	
									
		}
	}
	
    global $wp_query;
    $page_links_total =  $wp_query->max_num_pages;

	if($_opts['cur_page'] > 1)
	{
		// show prev
		$output .= "<span class='pfpNav'>" . get_previous_posts_link($_opts['prevText']) . "</span>";
	}
	if($_opts['cur_page'] <  $page_links_total)
	{
		// show next
		$output .= "<span class='pfpNav'>" . get_next_posts_link($_opts['nextText']) . "</span>";
	}


	wp_reset_query();
	return $output;

}
	
function pfp_get_posts($pfp_opts) {

	$params = array();
	if ($pfp_opts['post_id'] == '') { // for multiposts
		
		if ($pfp_opts['tag_slug'] != ''){
			$params['tag_slug__in'] = explode(",", $pfp_opts['tag_slug']);
		}
		if ($pfp_opts['cat'] != ''){
			$params['category__in'] =  explode(",", $pfp_opts['cat']);
		}
		if ($pfp_opts['cat_slug'] != '') {
			$params['category_name'] = $pfp_opts['cat_slug'];
		}
		if($pfp_opts['author'] != '') {
			$params['author'] = $pfp_opts['author'];
		}
		if($pfp_opts['order_by'] != '') {
			$params['order_by'] = $pfp_opts['order_by'];
		}
		if($pfp_opts['num'] != '') {
			//$params['numberposts'] = $pfp_opts['num'];
			$params['posts_per_page'] = $pfp_opts['num'];
			$params['paged'] = $pfp_opts['cur_page'];
			//if($pfp_opts['page_num'] != '') {
				// work out offset depending on page num
				//$offset = $pfp_opts['page_num'] * $pfp_opts['num'];

				//$params['offset'] = $offset;
			//}
		}
		if($pfp_opts['order'] != '') {
			$params['order'] = $pfp_opts['order'];
		}        
		else
		{
			$params['posts_per_page'] =  -1; // gets them all
		}
		// apply whatever the case:
		$params['suppress_filters'] = false;


		// get the posts
		//$postslist = get_posts($params);
		$postslist = query_posts($params);

	}else{ // for single posts
		$postslist[0] = wp_get_single_post($pfp_opts['post_id']);
	}
	return $postslist;
}


//add_action('admin_menu', 'my_plugin_menu');

//function my_plugin_menu() {
	//add_options_page('Posts for Page Plugin Options', 'Posts for Page Plugin', 'manage_options', 'pfp-unique-identifier', 'my_plugin_options');
//}

function my_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
	echo '<p>How to use: In your page (HTML view) add shortcode e.g. [posts-in-page cat_slug=\'asp-net-programming-2\'] </p><p>This will get all posts with the category slug \'asp-net-programming-2\'</p> ';
	echo '<p>post_id - Gets a post by ID, tag_slug - gets posts by tag slug, cat - gets posts with a category ID, cat_slug - gets posts with this category slug, author - gets posts by author, order_by - date or title, num - number of posts to show</p>';
	echo '</div>';
}

add_action('wp_head', 'get_pfp_css');

function get_pfp_css()
{
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/posts-for-page/pfp.css" />' . "\n";
}
?>