<?php

    if($_POST['foodor_hidden'] == 'Y') {
        //Form data sent
        $site_dir = $_POST['foodor_site_dir'];
        update_option('foodor_site_dir', $site_dir);

        $slash = '';
        if($_POST['foodor_dbtable_prefix'] <> ''){ $slash = '_'; }
        $dbtable_prefix = $_POST['foodor_dbtable_prefix'].$slash;
        update_option('foodor_dbtable_prefix', $dbtable_prefix);

        $dbtable_name = $_POST['foodor_dbtable_name'];
        update_option('foodor_dbtable_name', $dbtable_name);


        $table_name = $dbtable_prefix.$dbtable_name;
        /*
        -- Table structure for table item
        */
        
        $sqlcreate = "CREATE TABLE IF NOT EXISTS $table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
          title varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
          description varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
          image_url varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
          price decimal(10,2) NOT NULL,
          today_menu tinyint(1) NOT NULL,
          menu tinyint(1) NOT NULL,
          staff_id int(11) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        //var_dump($sqlcreate);
        //print_r($sqlcreate);

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sqlcreate);

        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display
        $site_dir = get_option('foodor_site_dir');
        $dbtable_prefix = get_option('foodor_dbtable_prefix');
        $dbtable_name = get_option('foodor_dbtable_name');


    }

?>

<!--- Form for import settings -->
<div class="wrap">
    <?php    echo "<h2>" . __( 'FoodOrders Product Display Options', 'foodor_trdom' ) . "</h2>"; ?>

<form name="foodor_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="foodor_hidden" value="Y">
    <?php    echo "<h4>" . __( 'FoodOrders Database Settings', 'foodor_trdom' ) . "</h4>"; ?>
    <p><?php _e("Root Site DIR: " ); ?><input type="text" name="foodor_site_dir" value="<?php echo $site_dir; ?>" size="20"><?php _e(" ex: SiteDIR, SiteName or something..." ); ?></p>
    <p><?php _e("DB Table Prefix: " ); ?><input type="text" name="foodor_dbtable_prefix" value="foodor" size="20"><?php _e(" ex: foodor or something..." ); ?></p>
    <p><?php _e("DB Table Name: " ); ?><input type="text" name="foodor_dbtable_name" value="item" size="20"><?php _e(" ex: item or something..." ); ?></p>

    <br />
    <hr />
    <!--?php    echo "<h4>" . __( 'FoodOrders Store Settings', 'foodor_trdom' ) . "</h4>"; ?>
    <p><!--?php _e("Store URL: " ); ?><input type="text" name="foodor_store_url" value="<!--?php echo $store_url; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/" ); ?></p>
    <p><!--?php _e("Product image folder: " ); ?><input type="text" name="foodor_prod_img_folder" value="<!--?php echo $prod_img_folder; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/images/" ); ?></p-->


    <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'foodor_trdom' ) ?>" />
    </p>
</form>
</div>