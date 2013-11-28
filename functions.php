<?php 
    /**
    
     * @author Abiye Chris. I. Surulere < suruabiye@gmail.com >
    
     * @copyright 2013
    
     * @license GNU V3
    
     * Function.php file (Mutual Benefits).
    
     * */ 
     
     // This help to apply owned stylesheet to admin backend/dashboard..
     function load_custom_wp_admin_style(){
        wp_register_style('custom_wp_admin_css', get_template_directory_uri(). '/css/bootstrap.css', false, '1.0.0');
        wp_register_style('custom_wp_admin_css2', get_template_directory_uri(). '/css/admin.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
        wp_enqueue_style('custom_wp_admin_css2');
     }
     add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
     
     
     add_theme_support('post-formats',array('link'));
     // Menu areas
    //Registering a multiple menu..
    function register_my_menus() {
    	register_nav_menus(
    		array(
    			'main_nav' => __( 'Main Menu' ),
    			'footer_nav' => __( 'Footer Menu' ),
                'mobile_nav' => __( 'Mobile Menu' ),
                'rel_nav' => __('Related Links')
    		)
    	);
    }
    add_action( 'init', 'register_my_menus' );
    
    //Making bootstrap menu
    // Register custom navigation walker
    require_once('wp_bootstrap_navwalker.php');
    
    //extending functions.php
    require_once('functions_extends.php');
    
    
    //function to change logo url and title
    function my_login_logo_url() {
        return get_bloginfo( 'url' );
    }
    add_filter( 'login_headerurl', 'my_login_logo_url' );
    
    function my_login_logo_url_title() {
        return 'Mutual Benefits';
    }
    add_filter( 'login_headertitle', 'my_login_logo_url_title' );
    
    /* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

    
    //function to change logo
    function my_login_logo() { ?>
        <style type="text/css">
            body.login div#login h1 a {
                background-image: url(<?php echo (get_option('mutual_site-login-logo')) ? get_option('mutual_site-login-logo') : get_template_directory_uri() . '/images/logo.png' ?>);
            }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );
    
    /*
    *   Registering sidebar widgets
    */
    function arphabet_widgets_init() {
        //area one
    	register_sidebar( array(
    		'name' => 'social-widget',
    		'id' => 'social-widget',
    		'before_widget' => '<div>',
    		'after_widget' => '</div>',
    		'before_title' => '<h2 class="rounded">',
    		'after_title' => '</h2>',
    	) );
    register_sidebar( array(
    		'name' => 'two',
    		'id' => 'two',
    		'before_widget' => '<div>',
    		'after_widget' => '</div>',
    		'before_title' => '<h2 class="rounded">',
    		'after_title' => '</h2>',
    	) );
        
        register_sidebar( array(
    		'name' => 'three',
    		'id' => 'advert2',
    		'before_widget' => '<div>',
    		'after_widget' => '</div>',
    		'before_title' => '<h2 class="rounded">',
    		'after_title' => '</h2>',
    	) );
        
    }
    add_action( 'widgets_init', 'arphabet_widgets_init' );
    
     /**

  * function get page id with title

  * get the page id of a page through its title

  * */

  function get_page_id_with_title($title) {

    $page = get_page_by_title($title);

    return $page->ID;

    }
    
    /* Theme-Options Page */
    function themeoptions_admin_menu()
    {
    	// here's where we add the theme options page link to the dashboard sidebar
    	add_theme_page("Theme Options", __('Theme Options', 'mutual'), 'edit_themes', basename(__FILE__), 'themeoptions_page');
    }
    function themeoptions_page(){
        if ( isset( $_POST['update_themeoptions'] ) ) { themeoptions_update(); }  //check options update
        ?>
        <div class="theme-option-page">
            <form action="" method="post">
            <input type="hidden" name="update_themeoptions" value="true" />
            <h3><?php _e('Change the login logo.', 'mutual'); ?></h3>
            <label for="logo-image"><?php _e('Logo Image URL', 'mutual'); ?></label>
            <input type="text" name="site-login-logo" id="site-login-logo" size="70" value="<?php echo get_option('mutual_site-login-logo'); ?>"/>
            <br/>
            <span class="description">
            <a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank">
            <?php _e('Upload your login logo image', 'mutual'); ?>
            </a>
            <?php _e(' using the WordPress Media Library and insert the URL here<br/>(the maximum logo image size is: 274px x 63px Pixel)', 'mutual'); ?>
            <h3><?php _e('Use an image as your logo', 'mutual'); ?></h3>
            <label for="logo-image"><?php _e('Logo Image URL', 'mutual'); ?></label>
            <input type="text" name="logo-image" id="logo-image" size="70" value="<?php echo get_option('mutual_logo-image'); ?>"/>
            <br/>
            <span class="description">
            <a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank">
            <?php _e('Upload your logo image', 'mutual'); ?>
            </a>
            <?php _e(' using the WordPress Media Library and insert the URL here<br/>(the maximum logo image size is: 240 x 75 Pixel)', 'mutual'); ?>
            </span>
            <br/><br/>
            <img src="<?php echo (get_option('logo-image')) ? get_option('logo-image') : get_template_directory_uri() . '/images/logo.png' ?>" alt=""/>
            <p><input type="submit" name="search" value="<?php _e('Update Options', 'mutual'); ?>" class="button button-primary" /></p>
            </form>
        </div>
        <?php
    }
    
    // Update options
    function themeoptions_update(){
        
        update_option('mutual_site-login-logo', 	$_POST['site-login-logo']);
    	update_option('mutual_logo-image', 	$_POST['logo-image']);
    	
    }
    
    add_action('admin_menu', 'themeoptions_admin_menu');
    
     //Add Thumbnail Support  
    add_theme_support( 'post-thumbnails' );
    
    //set the length of the excerpt
    function custom_excerpt_length( $length ) {
    	return 10;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 10 );
     function new_excerpt_more($more){
        return '<a class="read-more" href="'.get_permalink(get_the_ID()) .'"> ...Read More</a>';
     }
     add_filter('excerpt_more','new_excerpt_more');
    /**
    
     * function my_admin_footer
    
     * Rewrite the text in the bottom-left footer area
    
     *
    
     * @since 1.0
    
     */
    
    function my_admin_footer() {
    
    	echo 'Designed and Developed by <a href="http://www.ennovatenigeria.com" target="_blank">ennovateNIGERIA</a>';
    
    }
    
    add_filter('admin_footer_text', 'my_admin_footer');
    
?>
