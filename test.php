chargebee.php

<?php
/*
Plugin Name: ChargeBee
Description:
Version: 1
Author: vijay pancholi
Author URI: https://www.linkedin.com/in/vijay-pancholi-44b98895/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define('SUSCRIPTION_CHARGEBEE_URL',plugin_dir_url(__FILE__));
define('SUSCRIPTION_CHARGEBEE_DIR', plugin_dir_path(__FILE__));

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once(SUSCRIPTION_CHARGEBEE_DIR.'files/library.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Template.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/ChargebeeShorcode.php');
require_once(SUSCRIPTION_CHARGEBEE_DIR.'install.php');


install.php

<?php

/*Installation code for chargebee*/

class ChargeBeeInstallation{
     protected $lib;
     protected $setting;
	
    public function __construct(){
    	$this->lib = new ChargebeeLibrary(); 

          register_activation_hook(SUSCRIPTION_CHARGEBEE_DIR, array($this, 'activate') );
          add_action('init',array($this,'load_dependencies'));
            			
    }



	public function load_dependencies(){

         $this->lib->register_css_js_admin_script();
 
         include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Adminsetting.php');
         $this->setting = new AdminSetting();

	}


   public static function activate()
	{ 
	     
	}

}

$obj = new ChargeBeeInstallation();

library.php

<?php
/**
 * library file 
 */
/*include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Chargebee.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Template.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/ChargebeeShorcode.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/MetaBoxClass.php');
include_once(SUSCRIPTION_CHARGEBEE_DIR.'files/chargebee_api/chargebee-php-master/lib/ChargeBee.php');  */ 

class ChargebeeLibrary
{
        public $wc_connect_base_url;
        
	   
	   function __construct(){
         
         $this->wc_connect_base_url = SUSCRIPTION_CHARGEBEE_URL;
		 add_action('admin_enqueue_scripts', array($this,'register_css_js_admin_script'));

		}

		public function chargebee_update_option( $option, $value, $autoload = null){
	      return update_option( $option, $value, $autoload);
		}

		public function chargebee_get_edit_post_link($get_edit_post_id){
          return get_edit_post_link($get_edit_post_id);
        }
		

 	    public  function register_css_js_admin_script() {
 	    
	    wp_register_style( 'custom_wp_admin_css', plugin_dir_url(__FILE__).'css/custom.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_css');
		
		wp_register_style( 'custom_wp_admin_css', $this->wc_connect_base_url.'files/css/chargebee.min.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_css' );

		wp_register_style( 'custom_wp_form_css', $this->wc_connect_base_url.'files/css/chargebee.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_form_css' );

		wp_register_style( 'custom_wp_custom_css', $this->wc_connect_base_url.'files/css/custom.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_custom_css' );

		
		wp_enqueue_style( 'subscription_chargebee_datatable_fontIcon', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style( 'subscription_chargebee_datatablebot', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css' );

		wp_register_style( 'custom_wp_admin_dataTables.bootstrap.min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.bootstrap.min', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_dataTables.bootstrap.min' );

		wp_register_style( 'custom_wp_admin_dataTables.bootstrap4.min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.bootstrap.min.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_dataTables.bootstrap4.min' );

		wp_register_style( 'custom_wp_admin_dataTables.jqueryui.min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.bootstrap4.min.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_dataTables.jqueryui.min' );

		wp_register_style( 'custom_wp_admin_dataTables.semanticui.min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.jqueryui.min.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_dataTables.semanticui.min' );

		wp_register_style( 'custom_wp_admin_jquery.dataTables.min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.semanticui.min.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_jquery.dataTables.min' );

		wp_register_style('custom_subcrition_jquery.dataTables_themeroller' , $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/jquery.dataTables_themeroller.css', false, '1.0.0');
		wp_enqueue_style( 'custom_subcrition_jquery.dataTables_themeroller' );

		wp_register_style('custom_subcrition_ukit' , $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/css/dataTables.uikit.min', false, '1.0.0');
		wp_enqueue_style( 'custom_subcrition_ukit' );

		// wp_enqueue_style( 'subscription_chargebee_datatable15', 'https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
		// wp_enqueue_style( 'subscription_chargebee_datatable16', 'https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css' );
		// wp_enqueue_style( 'subscription_chargebee_datatable17', 'https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css' ); 
		// wp_enqueue_script( 'subscription_chargebee_datatable12', 'https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', true );
		// wp_enqueue_script( 'subscription_chargebee_datatable13', 'https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js', true );
		// wp_enqueue_script( 'subscription_chargebee_datatable14', 'https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js', true );

		wp_enqueue_script( 'subscription_chargebee_validate', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', true );
		wp_enqueue_script( 'subscription_chargebee_custom_js', $this->wc_connect_base_url.'files/js/custom.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_jquery', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/jquery.dataTables.min.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_bootstrap', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/dataTables.bootstrap.min.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_datatable', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/dataTables.dataTables.min.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_jquery', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/jquery.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_semanticui', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/dataTables.semanticui.min.js', true );
        wp_enqueue_script( 'subscription_chargebee_datatable_uikit_min', $this->wc_connect_base_url.'files/js/DataTables-1.10.19/media/js/dataTables.uikit.min.js', true );
	    }

        public function chargebee_sample_admin_notice__success($message){
        $class = 'notice notice-success is-dismissible';
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message);
        }

        public function chargebee_get_option($option_name){
	      return get_option($option_name);
		}

		public function chargebee_library($domain,$api_key){
                
		}

		public function chargebee_update_post_meta( $option, $value, $autoload = null){
	        return update_post_meta( $option, $value, $autoload);
		}

		public function chargebee_get_post_meta($post_id, $key = '', $single = false){
			
	        return  get_post_meta( $post_id, $key, $single);
		}

		public function get_meta_box_value($id){
		  $price      = $this->chargebee_get_post_meta($id, 'price', true);
		  $description      = $this->chargebee_get_post_meta($id, 'description', true);
          $metabox_title      = $this->chargebee_get_post_meta($id, 'metabox_title', true);
          $metabox_saving     = $this->chargebee_get_post_meta($id, 'metabox_saving', true);
          $metabox_separately = $this->chargebee_get_post_meta($id, 'metabox_separately', true);
          $metabox_include    = $this->chargebee_get_post_meta($id, 'metabox_include', true);
          $metabox_masks      = $this->chargebee_get_post_meta($id, 'metabox_masks', true);
          $metabox_cushions   = $this->chargebee_get_post_meta($id, 'metabox_cushions', true);
          $metabox_tub        = $this->chargebee_get_post_meta($id, 'metabox_tub', true);
          $metabox_filters    = $this->chargebee_get_post_meta($id, 'metabox_filters', true);
          $metabox_tubings    = $this->chargebee_get_post_meta($id, 'metabox_tubings', true);
  
          return array('price' => $price , 'description' => $description  ,'metabox_title' => $metabox_title ,'metabox_saving' => $metabox_saving , 'metabox_separately' => $metabox_separately , 'metabox_include' => $metabox_include , 'metabox_masks' => $metabox_masks , 'metabox_cushions' => $metabox_cushions , 'metabox_tub' => $metabox_tub , 'metabox_filters' => $metabox_filters , 'metabox_tubings' => $metabox_tubings );
    }
    
    public function get_mask_box_value($id){
    	    
			$mask_1     = $this->chargebee_get_post_meta($id, 'mask_1', true);
			$mask_2     = $this->chargebee_get_post_meta($id, 'mask_2', true);
			$mask_3     = $this->chargebee_get_post_meta($id, 'mask_3', true);
			$mask_4     = $this->chargebee_get_post_meta($id, 'mask_4', true);
          
  
          return array('mask_1'=> $mask_1 ,'mask_2' => $mask_2 ,'mask_3' => $mask_3 , 'mask_4' => $mask_4);
    }


}





Controller folder all file 
1. Template.php
2. Addmetabox.php
3. Adminsetting.php
4. Chargebee.php
5. ChargebeeShorcode.php


Template.php

<?php   
class Template {  

     public function __construct()    
     {    
           
     }   
      
     public function load( $tpl, $arr = array(),$type='',$return = false) {
          $path = SUSCRIPTION_CHARGEBEE_DIR.$tpl.'.php';
     if( file_exists($path) ) {
          foreach( $arr as $key => $value ) {
               $$key = $value;
          }
          unset( $arr );

          ob_start();
          require_once( $path );
          $template = ob_get_contents();
          ob_end_clean();

          if( $return == false ) {
               echo $template;
          } else {
               return $template;
          }
     } else {
          return false;
     }
}
     

}

Addmetabox.php


<?php

/**
 * 
 */
class AddmetaboxController
{
	 private $lib;
	 private $tpl;
	 private $mdl;
	
	function __construct()
	{
		  $this->lib = new ChargebeeLibrary();
		  $this->tpl = new Template();

		  include_once(SUSCRIPTION_CHARGEBEE_DIR.'model/Addmetabox.php');    
		  $this->mdl = new Addmetabox();
		  add_action('add_meta_boxes', array($this, 'cs_add_meta_box'));
      add_action('save_post', array($this, 'save'));
      $this->mask_section_function();
      
	}

     public function cs_add_meta_box() {
               add_meta_box('cs-meta',
               'Add Chargebee Field',
               array($this, 'cs_meta_box_function'),
               'chargebee',
               'normal',
               'high');
     }

     public function cs_meta_box_function($post) {

    wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');
    $meta_box_arrays = $this->lib->get_meta_box_value($post->ID);
    echo $this->tpl->load('view/subscription-metabox-field',array('results'=>$meta_box_arrays));  
             

     }

     public function save($post_id) {

      $this->mdl->insert_meta_box_value($_POST);  
            
     }

     public function mask_section_function(){

      add_action('save_post', array($this, 'mask_save'));
      add_action('add_meta_boxes', array($this, 'mask_add_meta_box'));
     }


      public function mask_add_meta_box(){
      add_meta_box('mask-meta',
               'Mask Chargebee Field',
               array($this, 'mask_meta_box_function'),
               'chargebee',
               'normal',
               'high');

     }

    public function mask_meta_box_function($post) {

    //wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');
    $meta_box_arrays = $this->lib->get_mask_box_value($post->ID);
    echo $this->tpl->load('view/subscription-metabox-mask',array('results'=>$meta_box_arrays));  
             

     }
     
     public function mask_save($post_id) {

       $this->mdl->insert_mask_box_value($_POST);

            
     }

}
  

AdminSetting.php 

<?php

/**
 * 
 */
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Chargebee.php');

class AdminSetting
{            
	        protected $charge_b;
			function __construct()
			{   
				
				include_once(SUSCRIPTION_CHARGEBEE_DIR. 'controller/Addmetabox.php');
				$this->charge_b =  new ChargeBeePlugin();
				add_action('admin_menu', array($this,'chargebee_create_menu'));
				$this->custom_posts_init();
                
				
			}
	
		    public function chargebee_create_menu() {

            add_menu_page('Chargebee', //page title
			'Chargebee', //menu title
			'manage_options', //capabilities
			'subscription_chargebee_setting_api', //menu slug
			array($this,'subscription_chargebee_setting_api') //function
			);

			//this is a submenu
			add_submenu_page('subscription_chargebee_setting_api', //parent slug
			'Setting', //page title
			'Setting', //menu title
			'manage_options', //capability
			'subscription_chargebee_setting_api', //menu slug
			array($this,'subscription_chargebee_setting_api')); //function

			
			add_submenu_page('subscription_chargebee_setting_api', //parent slug
			'Products', //page title
			'Products', //menu title
			'manage_options', //capability
			'subscription_chargebee_product', //menu slug
			array($this,'subscription_chargebee_product')); //function

            
    
        }


        public function subscription_chargebee_setting_api() {

		$this->charge_b->apisetting();
		

        }



        public function subscription_chargebee_product() {
        include_once(SUSCRIPTION_CHARGEBEE_DIR.'files/chargebee_api/chargebee-php-master/lib/ChargeBee.php');  
		$this->charge_b->productlist();	 
        }

        function custom_posts_init() {
		    // set up product labels
		    $labels = array(
		        'name' => 'Chargebee Subscription',
		        'singular_name' => 'Chargebee Subscription',
		        'add_new' => 'Add New Chargebee Subscription',
		        'add_new_item' => 'Add New Chargebee Subscription',
		        'edit_item' => 'Edit Chargebee Subscription',
		        'new_item' => 'New Chargebee Subscription',
		        'all_items' => 'All Chargebee Subscription',
		        'view_item' => 'View Chargebee Subscription',
		        'search_items' => 'Search Chargebee Subscription',
		        'not_found' =>  'No Chargebee Subscription Found',
		        'not_found_in_trash' => 'No Chargebee Subscription found in Trash', 
		        'parent_item_colon' => '',
		        'menu_name' => 'Chargebee Subscription',

		    );
		    
		    // register post type
		    $args = array(
		        'labels' => $labels,
		        'public' => true,
		        'has_archive' => true,
		        'show_ui' => true,
		        'capability_type' => 'post',
		        'hierarchical' => false,
		        'rewrite' => array('slug' => 'chargebee'),
		        'query_var' => true,
		        'menu_icon' => 'dashicons-randomize',

		        'supports' => array(
		            'title',
		            'editor',
		            'excerpt',
		            
		            'comments',
		            'revisions',
		            'thumbnail',
		            
		            
		        ),
		        'taxonomies' => array('post_tag')
		    );
		    register_post_type( 'chargebee', $args );
		    
		    // register taxonomy
		    register_taxonomy('chargebee_category', 'chargebee', array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array( 'slug' => 'chargebee-category' )));

          $amb = new AddmetaboxController();
            
		}
}

chargebee.php

<?php 
include_once(SUSCRIPTION_CHARGEBEE_DIR. 'model/Setting.php');  
class ChargeBeePlugin {  
     public $setting;
     protected $template;
     public function __construct()    
     {    
          $this->setting  = new Setting();
          $this->lib      = new ChargebeeLibrary();
          $this->template = new Template(); 
     }   
      
     public function apisetting()  
     {  
               
          $setting = $this->setting->insertapi();
          $setdata = $this->setting->setdata();
          echo $this->template->load('view/subscription_chargebee-view_list',array('result'=>$setdata));  
                
     }  

     public function productlist()

     {    
          $product =  $this->setting->insertchargebeeproduct();
          $result  =  $this->setting->getproductlist();
          echo $this->template->load('view/subscription_chargebee-product',array('result'=>$result));
     }
     

}


ChargebeeShorcode.php

<?php 
class ChargebeeShorcode {  
     private $shortcode_tag = 'product_subscription';
     private $shortcode;
     private $tpl;
     private $lib;
     private $setting;

      public function __construct()    
      {    
         
          include_once(SUSCRIPTION_CHARGEBEE_DIR. 'model/Setting.php');
          include_once(SUSCRIPTION_CHARGEBEE_DIR. 'model/Shortcode.php');
          include_once(SUSCRIPTION_CHARGEBEE_DIR.'files/chargebee_api/chargebee-php-master/lib/ChargeBee.php');
          add_shortcode( 'product_subscription', array($this, 'showshortcode' ) );
          add_shortcode( 'single_post', array($this, 'show_single_shortcode' ) );
          $this->lib = new ChargebeeLibrary();
          $this->shortcode = new Shortcode();
          $this->tpl = new Template();
          $this->setting = new Setting();
      }
   
      public  function showshortcode($atts) {
 
          if($atts==NULL){

               $plan_slug = 'chargebee';      // all plan show 

               $atts=NULL;
               $plan_result  =  $this->shortcode->singleplan($atts,$plan_slug);
               echo $this->tpl->load('view/subscription_chargebee_plan', array('results'=>$plan_result),$type=$plan_slug);
                        
          }

          else if($atts['product_code']) {
                $plan_slug = $atts['product_code'];      //  all custom plan  show 
                $atts='product_code';
                $plan_result  =  $this->shortcode->singleplan($atts,$plan_slug);
                echo $this->tpl->load('view/subscription_chargebee_plan', array('results'=>$plan_result),$type=$atts);  
          }

          else if($atts['category']) {
                $plan_slug = $atts['category'];           //  all custom category wise plan  show 
                $atts='category';                
                $plan_result  =  $this->shortcode->singleplan($atts,$plan_slug);
                echo $this->tpl->load('view/subscription_chargebee_plan', array('results'=>$plan_result),$type=$plan_slug);
               
          }
      }

      public function show_single_shortcode()
      {         
        
          // $content = get_post_field('post_content', get_the_ID());
          // echo do_shortcode( $content );                
                $plan_slug = get_the_ID();
                $atts='single_post';                
                $plan_result  =  $this->shortcode->singleplan($atts,$plan_slug);                
                echo $this->tpl->load('view/subscription_chargebee_single_plan', array('results'=>$plan_result),$type=$plan_slug);
                
                $setting = $this->setting->insert_subscription();
                
      }


}
$obj_short = new ChargebeeShorcode();

 
model folder all file 
1. Shortcode.php
2. Addmetabox.php
3. setting.php

<?php  
class Shortcode {

    
public function __construct(){
}
    
public function singleplan($attr, $plan_slug){
            

    if($attr=='') {

        $args = array(
        'post_type'   => 'chargebee',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        );

        $results = get_posts($args);
        return $results;
    }


    else if($attr=='product_code') { 

        $args = array(
        'name'        => $plan_slug,
        'post_type'   => 'chargebee',
        'post_status' => 'publish',
        'numberposts' => 1
        );

        $results = get_posts($args);
        return $results;
    }

    else if(trim($attr)=='category') {

        $args = array(
        'post_type' => 'chargebee',
        'posts_per_page' => -1,
        'tax_query' => array(array(
        'taxonomy' => 'chargebee_category',
        'field' => 'term_id',
        'terms' => explode(',', $plan_slug)
        ))

        );

        $results = get_posts($args);
        return array('results' =>$results,'category_id'=>$plan_slug);       
    }  

    else if($attr=='single_post'){

        $results = get_post($plan_slug);
        return $results;


    }

}
   


}

    // public function categoryplan($cat_term){

    //     $args = array(
    //     'post_type' => 'chargebee',
    //     'posts_per_page' => -1,
    //     'tax_query' => array(array(
    //     'taxonomy' => 'chargebee_category',
    //     'field' => 'term_id',
    //     'terms' => explode(',', $cat_term)
    //     ))

    //     );

    //     $results = get_posts($args);

    //     return array('category_id'=>$cat_term,'results' =>$results);  

    // }

    // foreach ($results  as $res) {
        //  return $res->ID;
        // }

<?php  
class Addmetabox {

    public function __construct()
    {    
         //require_once(SUSCRIPTION_CHARGEBEE_DIR.'files/library.php');
         $this->lib = new ChargebeeLibrary();
    }

    // public function get_meta_box_value($id){
    //       $metabox_title      = $this->lib->chargebee_get_post_meta($id, 'metabox_title', true);
    //       $metabox_saving     = $this->lib->chargebee_get_post_meta($id, 'metabox_saving', true);
    //       $metabox_separately = $this->lib->chargebee_get_post_meta($id, 'metabox_separately', true);
    //       $metabox_include    = $this->lib->chargebee_get_post_meta($id, 'metabox_include', true);
    //       $metabox_masks      = $this->lib->chargebee_get_post_meta($id, 'metabox_masks', true);
    //       $metabox_cushions   = $this->lib->chargebee_get_post_meta($id, 'metabox_cushions', true);
    //       $metabox_tub        = $this->lib->chargebee_get_post_meta($id, 'metabox_tub', true);
    //       $metabox_filters    = $this->lib->chargebee_get_post_meta($id, 'metabox_filters', true);
    //       $metabox_tubings    = $this->lib->chargebee_get_post_meta($id, 'metabox_tubings', true);
          
    //       return array('content' => $id ,'metabox_title' => $metabox_title ,'metabox_saving' => $metabox_saving , 'metabox_separately' => $metabox_separately , 'metabox_include' => $metabox_include , 'metabox_masks' => $metabox_masks , 'metabox_cushions' => $metabox_cushions , 'metabox_tub' => $metabox_tub , 'metabox_filters' => $metabox_filters , 'metabox_tubings' => $metabox_tubings );
    // }


    public function  insert_meta_box_value($postdata){
          $data_title = sanitize_text_field($postdata['metabox_title']);
          $data_saving = sanitize_text_field($postdata['metabox_saving']);
          $data_separately = sanitize_text_field($postdata['metabox_separately']);
          $data_include = sanitize_text_field($postdata['metabox_include']);
          $data_masks = sanitize_text_field($postdata['metabox_masks']);
          $data_cushions = sanitize_text_field($postdata['metabox_cushions']);
          $data_tub = sanitize_text_field($postdata['metabox_tub']);
          $data_filters = sanitize_text_field($postdata['metabox_filters']);
          $data_tubings = sanitize_text_field($postdata['metabox_tubings']);
          
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_title', $data_title);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_saving', $data_saving);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_separately', $data_separately);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_include', $data_include);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_masks', $data_masks);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_cushions', $data_cushions);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_tub', $data_tub);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_filters', $data_filters);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'metabox_tubings', $data_tubings);



    }

    public function  insert_mask_box_value($postdata){
      
          $mask_1 = sanitize_text_field($postdata['mask_1']);
          $mask_2 = sanitize_text_field($postdata['mask_2']);
          $mask_3 = sanitize_text_field($postdata['mask_3']);
          $mask_4 = sanitize_text_field($postdata['mask_4']);
         
          
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'mask_1', $mask_1);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'mask_2', $mask_2);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'mask_3', $mask_3);
          $this->lib->chargebee_update_post_meta($postdata['ID'], 'mask_4', $mask_4);
          



    }




   }

<?php  
class Setting {

    private $lib;
    public function __construct(){
    require_once(SUSCRIPTION_CHARGEBEE_DIR.'files/library.php');
    $this->lib = new ChargebeeLibrary(); 

    

    }

    public function insertapi(){  
        
        if (isset($_POST['submit']) && $_POST['action']== 'chargebee_action_setting')
        {
        $mode    = $_POST['test_mode'];
        $api_key = $_POST['api_key'];
        $domain  = $_POST['domain'];
        $test_api_key = $_POST['test_api_key'];
        $test_domain = $_POST['test_domain']; 
        
        $this->lib->chargebee_update_option('test_mode',$mode);
        $this->lib->chargebee_update_option('api_key',$api_key);
        $this->lib->chargebee_update_option('domain',$domain);
        $this->lib->chargebee_update_option('test_api_key',$test_api_key);
        $this->lib->chargebee_update_option('test_domain',$test_domain);
       
        $this->lib->chargebee_sample_admin_notice__success('Setting Saved Sucessfully');
        
        }
        
    }

    public function insert_subscription(){  
        
        if (isset($_POST['submit']) && $_POST['action']== 'chargebee_subscription_form_action')
        {
        
        $firstname    = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email  = $_POST['email'];
        $ph_number = $_POST['ph_number'];
        $adr1 = $_POST['adr1'];
        $adr2    = $_POST['adr2'];
        $city = $_POST['city'];
        $state  = $_POST['state'];
        $country = $_POST['country'];
        $zip = $_POST['zip'];
        $cardnumber    = $_POST['cardnumber'];
        $expmonth = $_POST['expmonth'];
        $expyear  = $_POST['expyear'];
        $card_cvv = $_POST['card_cvv'];
        $bill_adr1 = $_POST['bill_adr1'];
        $bill_adr2    = $_POST['bill_adr2'];
        $bill_city = $_POST['bill_city'];
        $bill_state  = $_POST['bill_state'];
        $bill_country = $_POST['bill_country'];
        $bzip = $_POST['bzip'];
        $current_user_id = $_POST['current_user_id'];
        $subscription_product_id  = $_POST['subscription_product_id'];
        $subscription_product_handle = $_POST['subscription_product_handle'];
        $cmd = $_POST['cmd'];
        $chargebee_cid = $_POST['chargebee_cid'];

        $setting = $this->checkmodeapi();  
        $api_key =  $setting['api_key'];
        $domain  =  $setting['domain'];

        $this->lib->chargebee_library($domain,$api_key);

        ChargeBee_Environment::configure($domain,$api_key);
        
        $result = ChargeBee_Subscription::create(array(

        
        "planId" => $subscription_product_id,
        "autoCollection" => "off",
        "billingAddress" => array(
        "firstName" => $firstname,
        "lastName" => $lastname,
        "email"    => $email,
        "ph_number"    => $ph_number,
        "cardnumber" => $cardnumber,
        "expmonth" => $expmonth,
        "expyear"    => $expyear,
        "card_cvv"    => $card_cvv,
        "line1" => $bill_adr1,
        "line2" => $bill_adr2,
        "city" =>  $bill_city,
        "state" => $bill_state,
        "zip" =>   $bzip,
        "country" => $bill_country,
        "cmd"    => $cmd,
        "chargebee_cid" => $chargebee_cid
        ),
        "customer" => array(
        "user_id" => $current_user_id,
        "firstName" => $firstname,
        "lastName" => $lastname,
        "email" => $email,
        "ph_number"    => $ph_number,
        )
        ));
       
        
        return $result;
                 
        
        }
        
    }



    public function  checkmodeapi(){
        $test_mode_check = $this->lib->chargebee_get_option('test_mode');
        if ($test_mode_check=='Yes') {
        $api_key = $this->lib->chargebee_get_option('test_api_key');
        $api_domain = $this->lib->chargebee_get_option('test_domain');
        }else{
        $api_key = $this->lib->chargebee_get_option('api_key');
        $api_domain = $this->lib->chargebee_get_option('domain');
        }

        if (!empty($api_key) && !empty($api_domain)) {
        return array('api_key' => $api_key,'domain'=> $api_domain);

        }
        else
        {
        return array('msg' => 'Please put domain or api');
        }
    }

    public function getproductlist(){

        $setting = $this->checkmodeapi();  
        $api_key =  $setting['api_key'];
        $domain  =  $setting['domain'];

        $this->lib->chargebee_library($domain,$api_key);

        ChargeBee_Environment::configure($domain,$api_key);
        
        $result = ChargeBee_Plan::all(array("status[is]" => "active"));
        
        return $result;
    }

    
    public function insertchargebeeproduct(){

       $getproductlist = $this->getproductlist();

        foreach($getproductlist as $entry) {

        $plan = $entry->plan();

        $title = $plan->name;
        $price = $plan->price/100;
        $contents =  '[single_post]';
        $post_name = $plan->id;   
        $description = $plan->description;    
        $check  =  $this->checkduplicateentry($post_name); 
        if($check && !empty($check))
        {
             $post = array(
                   'ID'            => $check,
                  'post_content'   => $contents,// The full text of the post.
                  'post_name'      => $post_name ,// The name (slug) for your post
                  'post_title'     => $title ,
                 
                  'post_status'    => 'publish' , // Default 'draft'.
                  'post_type'      => 'chargebee', // Default 'post'.
                  'post_author'   =>  1,

                  
                  );
                
                $post_id = wp_update_post($post); 
               
                //$link_edit = $this->lib->chargebee_get_edit_post_link($post_id);    // use function for  get_edit_post_link
                
                $this->lib->chargebee_update_post_meta($post_id, 'title',$title);
                $this->lib->chargebee_update_post_meta($post_id, 'price',$price);
                $this->lib->chargebee_update_post_meta($post_id, 'contents',$contents);
                $this->lib->chargebee_update_post_meta($post_id, 'description',$description);
                $this->lib->chargebee_update_post_meta($post_id, 'post_name',$post_name);

               

                
                


        }
        else
        {
                $post = array(
                  'post_content'   => $contents,// The full text of the post.
                  'post_name'      => $post_name ,// The name (slug) for your post
                  'post_title'     => $title , // The title of your post.

                  'post_status'    => 'publish' , // Default 'draft'.
                  'post_type'      => 'chargebee', // Default 'post'.
                  'post_author'   =>  1,
                  
                  );
                
                $post_id = wp_insert_post($post); 
                //$link_edit = $this->lib->chargebee_get_edit_post_link($post_id);    // use function for  get_edit_post_link
                //$this->lib->chargebee_update_post_meta($post_id, 'title',$title);
                $this->lib->chargebee_update_post_meta($post_id, 'title',$title);
                $this->lib->chargebee_update_post_meta($post_id, 'price',$price);
                $this->lib->chargebee_update_post_meta($post_id, 'contents',$contents);
                $this->lib->chargebee_update_post_meta($post_id, 'description',$description);
                $this->lib->chargebee_update_post_meta($post_id, 'post_name',$post_name);

                
               
        }

        }                
        
        }   
    
    public function setdata(){

         $mode         =      $this->lib->chargebee_get_option('test_mode');
         $api_key      =      $this->lib->chargebee_get_option('api_key');
         $domain       =      $this->lib->chargebee_get_option('domain');
         $test_api_key =      $this->lib->chargebee_get_option('test_api_key');
         $test_domain  =      $this->lib->chargebee_get_option('test_domain');

         return array('test_mode' => $mode ,'api_key'=> $api_key ,'domain'=> $domain ,'test_api_key'=> $test_api_key ,'test_domain'=> $test_domain);
        

    }

    public function checkduplicateentry($title){

        global $wpdb;
        $result = $wpdb->get_row( "SELECT ID FROM wp_posts WHERE post_name = '" . $title . "' && post_status = 'publish' && post_type = 'chargebee' ", OBJECT);

        if($result) {
        return $result->ID;
        } else {
        return $result->ID;
        }

    }

    

      
} 



view/subscription_chargee_plan.php

<div class="container">
        <div class="tab_sec">

<?php 
global $categories;
if($type=='chargebee'){
$count = 1;

echo '<ul class="nav nav-tabs" role="tablist">';
$args = array(
    'post_type' => 'chargebee',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty'=>0,
    'taxonomy'=>'chargebee_category',
    'exclude'=>array(1)

);
$categories = get_categories($args);   

foreach($categories as $category) { 

   $class = ($count==1) ? 'active' : '';
    echo 
        '<li>
            <a class="'.$class.'" href="#'.$category->slug.'" role="tab" data-toggle="tab">    
                '.$category->name.'
            </a>
        </li>';
;
$count++;

}

echo '</ul>'; 

}

else if($type=='product_code'){
$count = 1;

echo '<ul class="nav nav-tabs" role="tablist">';
  
$categories = get_the_terms($results[0]->ID, 'chargebee_category' ); // category get name from post id of post  
foreach($categories as $single_plan){

$class = ($count==1) ? 'active' : '';   
echo 
        '<li>
            <a class="'.$class.'" href="#'.$single_plan->slug.'" role="tab" data-toggle="tab">    
                '.$single_plan->name.'
            </a>
        </li>';
;
$count++;
}

echo '</ul>'  ; 

}

else if($type==$results['category_id']){
$count = 1;
echo '<ul class="nav nav-tabs" role="tablist">';
$categories = explode(',',$results['category_id']);

foreach($categories as $cat_id) { 

    $class = ($count==1) ? 'active' : '';
    $term = get_term_by('id',$cat_id, 'chargebee_category');        // category get id from category id of post

    echo 
        '<li>
            <a class="'.$class.'" href="#'.$term->slug.'" role="tab" data-toggle="tab">    
                '.$term->name.'
            </a>
        </li>';
;
$count++;

}

echo '</ul>'  ; 

}




?>


           
            <div class="tab-content">

                <?php 

               
                foreach($categories as $category) {

                if($type=='chargebee'){?>
                <div id="<?php echo $category->slug;?>" class="tab-pane fade in <?php echo $class;?> ">

                <?php } else if($type==$results['category_id']) {



$term = get_term_by('id',$category, 'chargebee_category');?>


<div id="<?php $term->slug;?>" class="tab-pane fade in <?php echo $class;?> ">

<?php  } else if($type=='product_code'){?>
        <div id="<?php echo $category->slug;?>" class="tab-pane fade in <?php echo $class;?>">

 <?php } ?>
                    <div class="container">


                        <div class="row">

   <?php  

        if($type=='chargebee'){
        $the_query = new WP_Query(array(
        'post_type' => 'chargebee',
        'posts_per_page' => -1,
        'tax_query' => array(array(
        'taxonomy' => 'chargebee_category',
        'field' => 'slug',
        'terms' =>  $category->slug
        ))

        ));
        
        //echo  $num = $the_query->post_count.'<br/>';
        //echo  $category->slug.'<br/>'; 


        } 

        if($type=='product_code'){
        $the_query = new WP_Query(array(    
        'name'        => $results[0]->post_name,
        'post_type'   => 'chargebee',
        'post_status' => 'publish',
        'numberposts' => 1
         )); 
        // /print_r($the_query);
        //echo  $num = $the_query->post_count.'<br/>';
        
        }



        else if($type==$results['category_id'])

        {
         
        $the_query = new WP_Query(array(
        'post_type' => 'chargebee',
        'posts_per_page' => -1,
        'tax_query' => array(array(
        'taxonomy' => 'chargebee_category',
        'field' => 'term_id',
        'terms' => explode(',', $results['category_id'])
        ))
        ));
            

        //echo  $num = $the_query->post_count.'<br/>'; 
        
        //print_r($the_query);

        }
        
        if ($the_query->have_posts()) : ?>
        <?php  $n= 1; while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php 
        $lib        =  new ChargebeeLibrary();
        $results =  $lib->get_meta_box_value(get_the_ID());
        
        ?>
          
                            
                            <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2">
                                <div class="left_card card_border">
                                        <div class="product_btn"><?php echo $results['metabox_title'];?></div>
                                        <h2 class="price_text"><?php  echo $results['post_content'];?></h2>
                                        <p class="per_shipment"><span class="text_bold">per shipment</span> or 6 installments of $45</p>
                                        <p class="savings_text">Savings: <?php  echo $results['metabox_saving'];?></p>
                                        <p class="sold_seperately">If sold separately: <?php  echo $results['metabox_separately'];?></p>
                                        <div class="includes_box">
                                            Includes:
                                            <ul>
                                                <li><?php echo $results['metabox_include'];?></li>
                                            </ul>
                                        </div>
                                        <div class="every_year_receive">
                                            Every year you will receive:
                                            <ul>
                                                <li><?php echo $results['metabox_masks'];?></li>
                                                
                                                <li>
                                                <?php if(!empty($results['metabox_cushions'])){
                                                 echo $results['metabox_cushions'];
                                             }
                                                ?>

                                                    
                                                </li>
                                                
                                                <li><?php echo $results['metabox_tub'];?></li>
                                                <li><?php echo $results['metabox_filters'];?></li>
                                                 <li><?php echo $results['metabox_tubings'];?></li>
                                            </ul>
                                        </div>
                                    <?php  
                                    $id =  $results[0]->ID;
                                    $src = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
                                    $url = $src[0];
                                    ?>


                                    <img class="product_img" src="<?php  echo $url;?>" >
                                    <div class="bottom_sec">
                                        <div class="form-group select_mask">
                                            <select class="form-control" id="sel1">
                                                <option>Select your mask</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                        <button class="btn">ADD TO CART</button>
                                    </div>
                                </div>
                            </div>
                          
                      
                       <?php $n++; endwhile; ?>

            <?php wp_reset_query();  ?>

        <?php else : ?>
            <p><?php __('No News'); ?></p>
        <?php endif; ?>

                            
                        </div>
                    </div>
                </div>

            <?php }  ?>
                
            </div>

        </div>
        </div>



view/product_list.php

<div class="wrap">
        <h2>Products List </h2>

        <table style="margin-top: 2%;" id="example" style="width:100%" class="table table-striped table-bordered">
         <thead>
            <tr>
                <th>ID.</th>
                <th>Plan Name</th>
                <th>Handle</th>
                <th>Accounting Code</th>
                <th>Price In USD</th>
                <th>Shortcode</th>
              
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
					<?php $n=1; 
					foreach($result as $entry) {

					$plan = $entry->plan(); 

					$set_obj =  new Setting();
					$post_id = $set_obj->checkduplicateentry($plan->id);

					
					if ($post_id) {

					?>
	                <tr id="row<?php echo $n;?>">
	                    <td class="manage-column ss-list-width"><?php echo $plan->id;?></td>

						<td class="manage-column ss-list-width"><?php echo $plan->name;?></td>
						<td class="manage-column ss-list-width"><?php echo $plan->id;?></td>
						<td class="manage-column ss-list-width"><?php echo $plan->accountingCode;?></td>
						<td class="manage-column ss-list-width"><?php echo $plan->price/100;?></td>
                        
						<td class="manage-column ss-list-width"><?php echo do_shortcode('[product_subscription product_code="'.$plan->id.'"]');?></td>
						
			  	        
						<td class="manage-column ss-list-width" id="post_url">
	                    	<a href="<?php echo get_edit_post_link($post_id);?>">
	                        Add More
	                    </a>

	    
	            </tr> <?php $n++; } 

			    }
	            ?>
         </tbody>
    </table>
            
    </div>

view/form.php

<div class="chargebee_container-fluid">

  <div  class="chargebee_row notice">
    
    <div class="chargebee_col-sm-6">

        <h2> Chargify Setting </h2>
         
        <form name="setting_form" id="setting_form" method="post">
          <div id="form">
           <div class="chargebee_checkbox">
            <label><input type="checkbox" name="test_mode" value="Yes" id="checkbox_checked" <?php if ($result['test_mode'] == 'Yes'){?> checked="checked" <?php } ?> > Test Mode </label>
            

           </div>
          
          <div class="chargebee_form-group">
            <label for="api_key">Api Key</label>
            <input type="text" class="chargebee_form-control" name="api_key" id="api_key" placeholder="Api Key" value="<?php  if(!empty($result['api_key'])) { echo $result['api_key'] ; } ?>"> <p1 class="serror"></p1>
          </div>

          <div class="chargebee_form-group">
            <label for="domain">Domain</label>
            <input type="text" class="chargebee_form-control" name="domain" id="domain" value="<?php  if(!empty($result['domain'])) { echo $result['domain'] ; } ?>" placeholder="Enter Domain"><p1 class="serror"></p1>
          </div>

          <div class="chargebee_form-group">
            <label for="test_api_key">Test Api Key</label>
            <input type="text" class="chargebee_form-control" name="test_api_key" id="test_api_key" value="<?php  if(!empty($result['test_api_key'])) { echo $result['test_api_key'] ; } ?>" placeholder="Enter Test Api Key"><p1 class="serror"></p1>
          </div>

           <div class="chargebee_form-group">
            <label for="test_domain">Test Domain</label>
            <input type="text" class="chargebee_form-control" name="test_domain" id="test_domain" value="<?php  if(!empty($result['test_domain'])) { echo $result['test_domain'] ; } ?>" placeholder="Enter Test Domain"><p1 class="serror"></p1>
          </div>
          <hr>
          <div class="chargebee_form-group">
            <label for="test_domain"><strong>Shortcode</strong></label>
            
          </div>
          <div class="chargebee_form-group">
            <label for="test_domain"><strong>[product_subscription]</strong></label>
            <div class="chargebee_form-group">
           <p>Show All product plan from chargebee Account Create with tab format</p>
            
          </div>
          </div>
          <hr>
           <div class="chargebee_form-group">
            <label for="test_domain"><strong>[product_subscription category="5,6"]</strong></label>
            <div class="chargebee_form-group">
           <p>Show All product plan from specific multiple or single category you want to display. </p>
            
          </div>
          </div>
          <hr>

           <div class="chargebee_form-group">
            <label for="test_domain"><strong>[product_subscription product_code="basic-airfit"]</strong></label>
            <div class="chargebee_form-group">
           <p>Show Single  product plan information from chargebee Account Create with tab format.</p>
            
          </div>
          </div>
          <hr>


          <input type="hidden" name="action" value="chargebee_action_setting">
          <input type="submit" style="margin-bottom: 2%;" name="submit" class="chargebee_btn btn-primary" value="Submit">
        
          </div>
        </form>

      </div>
   </div>
</div>






  



