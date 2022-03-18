<?php

namespace Leverage\ReactAdmin;

/**
 * React Admin Panels
 */

 class Core
 {

    public function __construct()
    {
        // Load Custom Post Type
        add_action( 'init', [$this, 'create_custom_post_type'] );

        // Create React Meta Box
        add_action( 'add_meta_boxes', [$this, 'create_product_react_meta'] );

        // Load React App
        add_action( 'init', [$this, 'load_react'] );
    }

    /**
     * Run during wordpress init
     */
    public function create_custom_post_type()
    {
        $singular = 'Product';                                                                                                                                     
        $plural = 'Products';                                                                                                                                      
        $slug = 'products';                                                                                                                                        
                                                                                                                                                                   
        register_post_type(                                                                                                                                        
            'react_' . $slug,                                                                                                                                   
            [                                                                                                                                                      
                'labels' => [                                                                                                                                      
                    'name' => __($plural, 'react'),                                                                                                             
                    'singular_name' => __($singular, 'react'),                                                                                                  
                    'add_new' => _x('Add New ' . $singular, 'react', 'react'),                                                                               
                    'edit_item' => __('Edit ' . $singular, 'react'),                                                                                            
                    'new_item' => __('New ' . $singular, 'react'),                                                                                              
                    'view_item' => __('View ' . $singular, 'react'),                                                                                            
                    'search_items' => __('Search ' . $plural, 'react'),                                                                                         
                    'not_found' => __('No ' . $plural . ' found', 'react'),                                                                                     
                    'not_found_in_trash' => __('No ' . $plural . ' found in Trash', 'react')                                                                    
                ],                                                                                                                                                 
                'public' => true,                                                                                                                                  
                'has_archive' => false,                                                                                                                            
                'supports' => ['title', 'thumbnail', 'page-attributes'],                                                                                           
                'menu_icon' => 'dashicons-cart',                                                                                                                   
                'menu_position' => 5,                                                                                                                              
                'show_in_rest' => true,                                                                                                                            
                'taxonomies' => array('post_tag', 'product-categories'),                                                                                           
                'rewrite' => ['slug' => $slug, 'with_front' => false]                                                                                              
            ]                                                                                                                                                      
        ); 
    }

    /**
     * Create Meta Box
     */
    public function create_product_react_meta()
    {
        // Wordpress Function, Add Meta Box
        add_meta_box(
            'react_layout',
            'Layout',
            [$this, 'create_react_entry_point'],
            'react_products',
            'normal',
            'high'
        );
    }

    /**
     * React App, Load
     */
    public function load_react()
    {
        $path = "leverage-react-admin/frontend/build/static";

        wp_register_script("product_react_app_js", plugins_url($path . "/js/main.js"), array(), "1.0", false);
        wp_register_style("product_react_app_css", plugins_url($path . "/css/main.css"), array(), "1.0", "all");
    }

    /**
     *  Entry point
     */
    public function create_react_entry_point($post)
    {
        wp_enqueue_script("product_react_app_js", '1.0', true);
        wp_enqueue_style("product_react_app_css");

        echo "<div id=\"product-app\" datapost-id=\"{{ $post->ID }}\"></div>";
    }
 }