<?php

    if($_POST['foodor_hidden'] == 'Y') {
        //Form data sent
        $site_dir = $_POST['foodor_site_dir'];
        update_option('foodor_site_dir', $site_dir);



        $db_server = $_POST['foodor_db_server'];
        update_option('foodor_db_server', $db_server);

        $db_database = $_POST['foodor_db_database'];
        update_option('foodor_db_database', $db_database);

        $db_username = $_POST['foodor_db_username'];
        update_option('foodor_db_username', $db_username);

        $db_password = $_POST['foodor_db_password'];
        update_option('foodor_db_password', $db_password);

        //$prod_img_folder = $_POST['foodor_prod_img_folder'];
        //update_option('foodor_prod_img_folder', $prod_img_folder);

        //$store_url = $_POST['foodor_store_url'];
        //update_option('foodor_store_url', $store_url);
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display
        $site_dir = get_option('foodor_site_dir');

        $db_server = get_option('foodor_db_server');
        $db_database = get_option('foodor_db_database');
        $db_username = get_option('foodor_db_username');
        $db_password = get_option('foodor_db_password');
        //$prod_img_folder = get_option('foodor_prod_img_folder');
        //$store_url = get_option('foodor_store_url');
    }

?>

<!--- Form for import settings -->
<div class="wrap">
    <?php    echo "<h2>" . __( 'FoodOrders Product Display Options', 'foodor_trdom' ) . "</h2>"; ?>

<form name="foodor_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="foodor_hidden" value="Y">
    <?php    echo "<h4>" . __( 'FoodOrders Database Settings', 'foodor_trdom' ) . "</h4>"; ?>
    <p><?php _e("Root Site DIR: " ); ?><input type="text" name="foodor_site_dir" value="<?php echo $site_dir; ?>" size="20"><?php _e(" ex: SiteDIR, SiteName or something..." ); ?></p>

    <p><?php _e("Database host: " ); ?><input type="text" name="foodor_db_server" value="<?php echo $db_server; ?>" size="20"><?php _e(" ex: localhost" ); ?></p>
    <p><?php _e("Database name: " ); ?><input type="text" name="foodor_db_database" value="<?php echo $db_database; ?>" size="20"><?php _e(" ex: foodorders_shop" ); ?></p>
    <p><?php _e("Database user: " ); ?><input type="text" name="foodor_db_username" value="<?php echo $db_username; ?>" size="20"><?php _e(" ex: root" ); ?></p>
    <p><?php _e("Database password: " ); ?><input type="text" name="foodor_db_password" value="<?php echo $db_password; ?>" size="20"><?php _e(" ex: secretpassword" ); ?></p>
    <hr />
    <hr />
    <!--?php    echo "<h4>" . __( 'FoodOrders Store Settings', 'foodor_trdom' ) . "</h4>"; ?>
    <p><!--?php _e("Store URL: " ); ?><input type="text" name="foodor_store_url" value="<!--?php echo $store_url; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/" ); ?></p>
    <p><!--?php _e("Product image folder: " ); ?><input type="text" name="foodor_prod_img_folder" value="<!--?php echo $prod_img_folder; ?>" size="20"><!--?php _e(" ex: http://www.yourstore.com/images/" ); ?></p-->


    <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'foodor_trdom' ) ?>" />
    </p>
</form>
</div>