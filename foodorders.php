<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name: FoodOrders
// Plugin URI: http://www.olala.co.rs/foodorders.html
// Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Creating orders of food that is listed
Version:     1.00
Author:      Goran Subić
// Author URI:  http://URI_Of_The_Plugin_Author
// License URI: https://www.gnu.org/licenses/gpl-2.0.html
// Domain Path: /languages
// Text Domain: my-toolset
License:     GPL2
FoodOrders is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

FoodOrders is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with FoodOrders. If not, see {License URI}.
*/

function foodor_admin(){
    include('foodor_import_admin.php');
}

function foodor_admin_actions(){
    /* add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position ); */
    add_menu_page("FoodOrders Admin Page", "FoodOrders", 10, "FoodOrders", "foodor_admin", "http://www.olala.co.rs/wp-content/uploads/2015/06/logoOlala.png");
}

add_action('admin_menu', 'foodor_admin_actions');

function foodor_additems(){
    include('foodor_add_items.php');
}

function foodor_admin_additems(){
    /* add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function); */
    add_submenu_page("FoodOrders", "Add Items FoodOrders Admin Page", "Add Items", 10, "AddItemsFoodOrders", "foodor_additems");
}

add_action('admin_menu', 'foodor_admin_additems');








function foodor_getproducts($product_cnt=1) {

    //Connect to the olalaco_websajt database
    $connection = new wpdb(get_option('foodor_db_username'),get_option('foodor_db_password'), get_option('foodor_db_database'), get_option('foodor_db_server'));


    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sqlget = "SELECT * FROM item WHERE id = ".$id;

        if (!$results = $connection->get_results($sqlget)){
            die('Ne mogu da izvrsim upit zbog ['. $connection->error
                . "]");
        }
        //print_r("Results iznosi: $results");
        //var_dump($results);

        $writeget = "";
        $writeget .= "<div class='main container-fluid'>";
        $writeget .= "<div class='sectionShow'>";
        foreach($results as $rowget){

            //print_r("Rowget iznosi: $rowget");
            //var_dump($rowget);

            $writeget .= "<div class='secimg''>";
            $writeget .= "<img src='{$rowget->image_url}' alt='Item Photo' style='width:200px;height:200px'>";
            $writeget .= "</div>";
            $writeget .= "<div class='secol'>";
            $writeget .= "<ul class='ulindex''>";
            $writeget .= "<li><h1>Naziv artikla: {$rowget->title}</h1></li>";
            $writeget .= "<li><h4>Opis: {$rowget->description}</h4></li>";
            $writeget .= "<li><h3>Cena: {$rowget->price} din</h3></li>";
            $writeget .= "<br />";
            $writeget .= "<br />";
            $writeget .= "<li><a href='foodorder'>Vrati se na ponudu.</a></li>";

            $writeget .= "</ul>";
            $writeget .= "</div>";

        }
        $writeget .= "</div>";
        $writeget .= "</div>";

        return $writeget;
    }


    /* If is posted form then create and return table
        with variable $tablepost
     */
if(isset($_POST['submit'])){
    $item_arr = array();

    for($i=1; $i<100; $i++){
        $ordered_id = "id".$i;
        $price = "price".$i;
        $col = "col".$i;
        $title = "title".$i;

        if((isset($_POST[$ordered_id])) && ($_POST[$ordered_id] == $i)){
            $item_arr[$i][$ordered_id] = $_POST[$ordered_id];
            $item_arr[$i][$price] = $_POST[$price];
            $item_arr[$i][$col] = $_POST[$col];
            $item_arr[$i][$title] = $_POST[$title];
        }
    }
    //print_r($item_arr);
    //$lenght = count($item_arr);
    //echo "Ukupno ima {$lenght} zapisa u porudzbini";



if (isset($ordered_id)) {
    $n=0;
    foreach($item_arr as $item_arr_key=>$one_array){
        $i=0;
        foreach($one_array as $key=>$value) {
            //echo "<br />Brojac iznosi {$i} - Key je: {$key} - upisana vrednost {$value}";
            $new_array[$n][$i] = $value;
            $i++;
        }
        $n++;
    }
}

if((isset($new_array)) && (!empty($new_array))) {

    $tablepost = '';
    $tablepost .= '<table class="table datagrid">';
    $tablepost .= '<tr style="background-color: chocolate">';
    $tablepost .= '<th>ID</th>';
    $tablepost .= '<th>Artikal</th>';
    $tablepost .= '<th>Cena</th>';
    $tablepost .= '<th>Kolicina</th>';
    $tablepost .= '<th>Vrednost</th>';
    $tablepost .= '</tr>';

        foreach ($new_array as $new_array_row) {
            $tablepost .= "<tr>";
            if ($new_array_row[2] <> 0) {
                $tablepost .= "<td>";
                $tablepost .= $new_array_row[0];
                $tablepost .= "</td><td>";
                $tablepost .= $new_array_row[3];
                $tablepost .= "</td><td>";
                $tablepost .= $new_array_row[1];
                $tablepost .= "</td><td>";
                $tablepost .= $new_array_row[2];
                $tablepost .= "</td><td>";
                $tablepost .= $valu_one = $new_array_row[1] * $new_array_row[2];
                $tablepost .= "</td>";
                $tablepost .= "</tr>";
                if(isset($valu_one)) {
                    $value_all = $value_all + $valu_one;
                }
            }
        }
    $tablepost .= "</table>";
}

return $tablepost;

}


    /********** Example from tutorial **************/
    $retval = '';
    for ($i=0; $i<$product_cnt; $i++) {
        //Get a random product
        $product_count = 0;
        while ($product_count == 0) {
            $product_id = rand(0,30);
            $product_count = $connection->get_var("SELECT COUNT(*) FROM item WHERE id=$product_id AND today_menu=1");
        }

        //Get product image, name and URL
        $product_image = $connection->get_var("SELECT image_url FROM item WHERE id=$product_id");
        $product_name = $connection->get_var("SELECT title FROM item WHERE id=$product_id");
        //$store_url = get_option('oscimp_store_url');
        //$image_folder = get_option('oscimp_prod_img_folder');

        //Build the HTML code
        $retval .= '<div class="foodor_product">';
        $retval .= '<img src="' . $product_image . '" style="width:100px; heigth:100px;" /><br />';
        $retval .= '<a href=orders/showItem.php?id=' . $product_id . '>' . $product_name . '</a>';
        $retval .= '</div>';

    }
    //return $retval;
    /*********** End of Example from tutorial **********/

    $sql = "SELECT * FROM item WHERE menu = 1 ORDER BY id ASC ";

    if (!$results = $connection->get_results($sql)){
        die('Ne mogu da izvrsim upit zbog ['. $connection->error
            . "]");
    }


    //$uri = trim($_SERVER['REQUEST_URI'], '/');
    $uri = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
    $uri = trim($uri, '/');

    $writeout = "";
    $writeout .= "<form method='post' action='{$_SERVER['REQUEST_URI']}'>";
    $writeout .= "<input type='submit' name='submit' value='Odaberite količine i potvrdite porudžbinu ovde' class='btn btn-default btn-lg btn-block'>";
    $writeout .= "<div class='main container-fluid' style='margin-top: 10px'>";

    //WHILE ($row = $results->fetch_assoc()){
    foreach ($results as $rowobj){

        $writeout .= "<div class='secolPhoto' style='border-color: #d2691e;'>";
        $writeout .= "<table class='table datagrid' style='width: 30%; float: left;'>";
        $writeout .= "<tr style='background-color: chocolate'>";
        $writeout .= "<th style='width: 40%'>ID: <a style='color:darkred' href='{$uri}?id={$rowobj->id}'>{$rowobj->id}</a></th>";
        $writeout .= "<th style='width: 130px'><input type='text' name='title{$rowobj->id}' value='{$rowobj->title}' style='background-color: #d2691e; width: 130px; border: none;' readonly></th>";
        $writeout .= "</tr>";
        $writeout .= "<tr>";
        $writeout .= "<td style='width: 40%'>{$rowobj->description}</td>";
        $writeout .= "<td style='width: 130px'><a href='{$uri}?id={$rowobj->id}' ><img src={$rowobj->image_url} style='width:100px; height:100px;'></a></td>";
        $writeout .= "</tr>";
        $writeout .= "<tfoot>";
        $writeout .= "<td style='width: 40%'><input style='width: 100px' type='money' name='price{$rowobj->id}' value='{$rowobj->price}' readonly></td>";
        $writeout .= "<td style='width: 130px' colspan = '2'>";
        $writeout .= "<input type='hidden' name='id{$rowobj->id}' value='{$rowobj->id}' style='border: none'>";
        $writeout .= "<span style='color:#8b0000'>Količina: <input style='width: 50px' type='number' name='col{$rowobj->id}' min='0' max='10' value='0'></span>";
        $writeout .= "</td>";
        $writeout .= "</table>";

        $writeout .= "</div>";
    }

    $writeout .= "</div>";
    $writeout .= "</form>";

    return $writeout;
}

?>
