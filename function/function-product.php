<?php
//----------------------------------------------
//----------register and label product post type
//----------------------------------------------
$products_labels = array(
    'name' => _x('Products', 'post type general name'),
    'singular_name' => _x('Product', 'post type singular name'),
    'add_new' => _x('Add New', 'product'),
    'add_new_item' => __("Add New Product"),
    'edit_item' => __("Edit Product"),
    'new_item' => __("New Product"),
    'view_item' => __("View Product"),
    'search_items' => __("Search Product"),
    'not_found' =>  __('No products found'),
    'not_found_in_trash' => __('No products found in Trash'),
    'parent_item_colon' => ''

);
$products_args = array(
    'labels' => $products_labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'rewrite' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'products'),
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
    'menu_icon' => get_bloginfo('template_directory') . '/images/products.png' //16x16 png if you want an icon
);
register_post_type('products', $products_args);

function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Product Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Product Categories' ),
    'all_items'         => __( 'All Product Categories' ),
    'parent_item'       => __( 'Parent Product Category' ),
    'parent_item_colon' => __( 'Parent Product Category:' ),
    'edit_item'         => __( 'Edit Product Category' ),
    'update_item'       => __( 'Update Product Category' ),
    'add_new_item'      => __( 'Add New Product Category' ),
    'new_item_name'     => __( 'New Product Category' ),
    'menu_name'         => __( 'Product Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );

  register_taxonomy( 'product_category', 'product', $args );

}


add_action( 'init', 'my_taxonomies_product', 0 );




add_action("admin_init", "admin_init");

function admin_init(){
  add_meta_box("price", "Price", "price", "products", "side", "low");
}


function price() {
  global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["price"][0];
  ?>
  <label>Price:</label>
  <input name="price" class="required" value="<?php echo $price; ?>" />
  <?php
}
add_action('save_post', 'save_details');

function save_details(){
  global $post;

  update_post_meta($post->ID, "price", $_POST["price"]);

}

add_action("manage_posts_custom_column",  "product_custom_columns");
add_filter("manage_edit-products_columns", "product_edit_columns");

function product_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" >",
    'jss_post_thumb'    =>        'Thumbnail',
    "title" => "Product",
    "description" => "Description",
    "price" => "Price",
  );

  return $columns;
}

function product_custom_columns($column){
  global $post;

  switch ($column) {

    case "price":
      $custom = get_post_custom();
      echo $custom["price"][0];
      break;

  }
}
?>
