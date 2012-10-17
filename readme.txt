=== Posts for Page ===
Contributors: sihibbs
Donate link: 
Tags: post summary, posts in page, posts by tag, posts by category
Requires at least: 3.3
Tested up to: 3.4.2
Stable tag: 1.73

Include posts in a Page, by category, a selection of tags or by author with auto summary (read more) option. Supports pagination.

== Description ==

Include posts in a Page, by category, a selection of tags or by author with an auto summary (read more) option. Supports pagination when number of posts per page is specified.

For example if you want a Page (in the main header navigation) to show a list of all posts in a category or set of tags and summarise the posts then this plugin will do it. Add a simple shortcode to the page (in HTML view) and the page is generated from the matching posts.


== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create (or edit) a page. Switch to HTML view.
4. Insert the shortcode: [posts-for-page cat_slug='your-category-slug'] (to display all posts from this category)
5. Add any additional options, it will default to 50 words with the read-more link or set show_full_posts='true' to show full post content.

Example Usage:

[posts-for-page cat_slug='asp-net-programming-2' hide_images='false' num='5' read_more='<br>Read More &raquo;' show_full_posts='false' use_wp_excerpt='true' strip_html='true' hide_post_content='false' show_meta='true']

== Frequently Asked Questions ==
<ul>
<li>The first image in a post will be place at the start using the WP thumbnail if it is available. If images are a problem they can be hidden using: hide_images='true'</li>
<li>Pagination is added if number of posts is specifified (i.e. num='3')</li>
<li>"Read More" Text can be specified (i.e. read_more='More Here')</li>
<li>Pagination link text can be specified using 'prev_text' and 'next_text'</li>
</ul>
<ul>
	<li>Full Options:</li>
    <li>cat_slug : Show all posts with this category slug</li>
    <li>cat : Show all posts with a particular category ID</li>
    <li>tag_slug : Show all posts with a specific tag (more than one can be entered, comma separated, i.e. tag_slug='html,css' (note: no spaces)</li>
    <li>order_by : Order the posts by 'date' or 'title'</li>
    <li>post_id : Show one post</li>
    <li>author : Show posts by author</li>
    <li>num : Limit the number of posts to show</li>
    <li>hide_images (true/false) : If images are a problem they can be hidden using: hide_images='true'</li>
    <li>Added in V1.5 (Pagination if number of posts is specified e.g. num='x')</li>
    <li>read_more : Replace default read more text (i.e. read_more='Show me more...')</li>
    <li>prev_text : Replace default Previous entry link text when specifying number of posts (i.e. prev_text='Newer')</li>
    <li>next_text : Replace default Next entry link text when specifying number of posts (i.e. next_text='Older')</li>
    <li>show_full_posts(true/false) : Show full post rather than excerpt (i.e. show_full_posts='true')</li>
	<li>use_wp_excerpt - show the WP generated excerpt or the excerpt if defined for the post</li>
	<li>strip_html : attempts to strip all HTML content (if not using use_wp_excerpt option)</li>
	<li>hide_post_content : set to 'true' to only show the post titles</li>
	<li>show_meta : set to 'true' to show post date and author name</li>
	<li>hide_post_title : set to 'true' to hide the post title, e.g. if you just want to show one post using post_id</li>
	<li>hide_read_more : set to 'true' to hide the read more link</li>
	<li>create_para_tags : set to 'true' to use the WP 'wpautop' function to create <p> tags and <br> tags from line breaks</li>
	<li>order : set to 'ASC' or 'DESC' - Designates the ascending or descending order of the 'orderby' parameter. Defaults to 'DESC'.</li>
</ul>
<ul>
	<li>Each summary posts is contained in a div with  class="pfpItem", so you can override styles by setting them in the WP stylesheet "styles.css". E.g ".div.pfpItem{font-size:20px;}"</li>
</ul>
<ul>
	<li>Source code for extending can be found on github https://github.com/shibbard/posts-for-page</li>
</ul>
== Screenshots ==

1. `/postsforpage/1.0/screenshot-1.jpg`
2. `/postsforpage/1.0/screenshot-1.jpg`

== Changelog ==

= 1.0 =
* Release Version

= 1.1 =
* Update readme

= 1.2 =
* Fixed limit to number of posts which would be displayed

= 1.3 =
* Update readme

= 1.4 =
* Fixed header tag to be H2
* Removes all images and inserts first image (if found) at start of post using WP Thumbnail version
* If images are a problem they can be hidden using: hide_images='true'

= 1.5 =
* Pagination added if number of posts is specifified (i.e. num='3')
* "Read More" Text can be specified (i.e. read_more='<br>More Here')
* Pagination link text can be specified using 'prev_text' and 'next_text'
* show_full_posts='true' - will show the full post content.

= 1.6 =
* Number of display issues resolved
* new options added
* use_wp_excerpt - set to 'true' to show the WP generated excerpt or the excerpt if defined for the post
* strip_html - set to 'true' attempts to strip all HTML content (if not using use_wp_excerpt option)
* hide_post_content - set to 'true' to only show the post titles
* show_meta - set to 'true' to show post date and author name

= 1.61 =
* hide_post_title : set to 'true' to hide the post title, e.g. if you just want to show one post using post_id

= 1.7 =
* added create_para_tags 
* fixed a bug with hide_read_more 

= 1.71 =
* added order (ASC or DESC) for the order_by parameter

= 1.73 =
* fixed bug with num param

== Upgrade Notice ==
First Release



