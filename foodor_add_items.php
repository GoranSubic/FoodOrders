<?php

global $wpdb;
//require_once('..\..\..\wp-config.php');
require_once($_SERVER['DOCUMENT_ROOT']."/".get_option('foodor_site_dir')."/wp-config.php");
//require_once('C:\xampp\htdocs\olala\wp-config.php');

echo dirname(__FILE__);

if($_POST['foodor_hidden'] == 'Y'){

    $table_name = "item";
    $title = $_POST['foodor_item_title'];
    $description = $_POST['foodor_item_description'];
    $price = $_POST['foodor_item_price'];
    $itemurl = $_POST['foodor_item_itemurl'];
    $itemmenu = $_POST['foodor_item_menu'];
    $todaymenu = $_POST['foodor_item_today_menu'];

    //$table_name = $wpdb->prefix . "imlisteningto";

    $wpdb->insert( $table_name, array( 'title' => $title, 'description' => $description, 'price' => $price, 'image_url' => $itemurl, 'menu' => $itemmenu, 'today_menu' => $todaymenu ) );

}

?>
<!--- Form for import settings -->
<div class="wrap">
    <?php    echo "<h2>" . __( 'FoodOrders Add Items Page') . "</h2>"; ?>

<form name="foodor_additems_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="foodor_hidden" value="Y">
    <?php    echo "<h4>" . __( 'FoodOrders Add Items') . "</h4>"; ?>
    <p><?php _e("Naziv artikla: " ); ?><input type="text" name="foodor_item_title" value="" size="20"><?php _e(" ex: Pizza" ); ?></p>
    <p><?php _e("Opis artikla: " ); ?><input type="text" name="foodor_item_description" value="" size="20"><?php _e(" ex: Velika, mala..." ); ?></p>
    <p><?php _e("Cena artikla: " ); ?><input type="text" name="foodor_item_price" value="" size="20"><?php _e(" ex: 100" ); ?></p>
    <p><?php _e("Photo link: " ); ?><input type="text" name="foodor_item_itemurl" value="" size="20"><?php _e(" ex: http://www.olala.co.rs/..." ); ?></p>
    <p><?php _e("Menu lista: " ); ?><input type="checkbox" name="foodor_item_menu" value="" size="20"><?php _e(" ex: Da li se prikazuje na spisku?" ); ?></p>
    <p><?php _e("Danasnji menu: " ); ?><input type="checkbox" name="foodor_item_today_menu" value="" size="20"><?php _e(" ex: Da li je na danasnjem meniu?" ); ?></p>
    <hr />
    <hr />
    <!--?php    echo "<h4>" . __( 'FoodOrders Store Settings', 'foodor_trdom' ) . "</h4>"; ?>
    <p><!--?php _e("Store URL: " ); ?><input type="text" name="foodor_store_url" value="<!--?php echo $store_url; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/" ); ?></p>
    <p><!--?php _e("Product image folder: " ); ?><input type="text" name="foodor_prod_img_folder" value="<!--?php echo $prod_img_folder; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/images/" ); ?></p-->


    <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Dodaj artikal') ?>" />
    </p>
</form>
</div>