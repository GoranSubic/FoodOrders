<?php

global $wpdb;
$connection = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
//require_once('..\..\..\wp-config.php');
//require_once($_SERVER['DOCUMENT_ROOT']."/".get_option('foodor_site_dir')."/wp-config.php");
//require_once('C:\xampp\htdocs\olala\wp-config.php');
require_once(ABSPATH."wp-config.php");
$table_name = get_option('foodor_dbtable_prefix').get_option('foodor_dbtable_name');
$uri = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);

//echo dirname(__FILE__);

/*******    Radi insert ako nije izabran id za izmenu    ***********/
if(($_POST['foodor_hidden'] == 'Y')&&($_POST['foodor_item_id'] == null)){

    //$postid = $_POST['foodor_item_id'];
    $title = $_POST['foodor_item_title'];
    $description = $_POST['foodor_item_description'];
    $price = $_POST['foodor_item_price'];
    $itemurl = $_POST['foodor_item_itemurl'];

    if(isset($_POST['foodor_item_menu'])){ $itemmenu = 1; }else{ $itemmenu = 0; }
    if(isset($_POST['foodor_item_today_menu'])){ $todaymenu = 1; }else{ $todaymenu = 0; }

    $wpdb->insert( $table_name, array( 'title' => $title, 'description' => $description, 'price' => $price, 'image_url' => $itemurl, 'menu' => $itemmenu, 'today_menu' => $todaymenu ) );

}

/**** Radi update ako je odabran pre submit-a       *****/
if(($_POST['foodor_hidden'] == 'Y')&&($_POST['foodor_item_id'] != null)){

    $postid = stripslashes($_POST['foodor_item_id']);

    $title = stripslashes($_POST['foodor_item_title']);
    $description = stripslashes($_POST['foodor_item_description']);
    $price = stripslashes($_POST['foodor_item_price']);
    $itemurl = stripslashes($_POST['foodor_item_itemurl']);

    if(isset($_POST['foodor_item_menu'])){ $itemmenu = 1; }else{ $itemmenu = 0; }
    if(isset($_POST['foodor_item_today_menu'])){ $todaymenu = 1; }else{ $todaymenu = 0; }

    $checkupd = $wpdb->update(
        $table_name,
        array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'image_url' => $itemurl,
            'menu' => $itemmenu,
            'today_menu' => $todaymenu
        ),
        array('id' => $postid)/*,
        array(
            '$s',
            '$s',
            '$f',
            '$s',
            '$d',
            '$d'
        ),
        array('%d')*/
    );

    //exit( var_dump( $wpdb->last_query ) );

    $uri = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);

    $getid = '';
    $postid = '';

}

if(isset($_GET['id'])){
    $getid = $_GET['id'];

    /*
    $sqlid = "SELECT * FROM $table_name WHERE id=$getid; ";

    if (!$resultsid = $connection->get_results($sqlid)){
        die('Ne mogu da izvrsim upit zbog ['. $connection->error
            . "]");
    }

    foreach($resultsid as $rowid){
        $test = $rowid->title;
        print_r("<br />Test iznosi: $test");
    }
    */

    $rowid = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$getid" );

    if(isset($rowid->menu)){ $itemmenuid = 1; }else{ $itemmenuid = 0; }
    if(isset($rowid->today_menu)){ $todaymenuid = 1; }else{ $todaymenuid = 0; }

    $shortcode = do_shortcode("$uri");
    $shortcodepart = explode("&", $shortcode);
    $shortcodepart0 = $shortcodepart[0];
    print_r("<br />shortcodepart0 when id is set: $shortcodepart0");
    $shortcode = $shortcodepart0;
    print_r("<br />Shortcode 1 when id is set: $shortcode");

}else{
    $shortcode = do_shortcode("$uri");
    print_r("<br />Shortcode 2 when id is set: $shortcode");
}

if(isset($_GET['del'])){
    $getdel = $_GET['del'];

    $wpdb->delete( $table_name, array( 'id' => $getdel )/*, array( '%d' )*/ );
}

?>
<!--- Form for handle articles -->
<div class="wrap">
    <?php    echo "<h2>" . __( 'FoodOrders Handle Items Page') . "</h2>"; ?>

<form name="foodor_additems_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="foodor_hidden" value="Y">
    <?php    echo "<h4>" . __( 'FoodOrders Add Items') . "</h4>"; ?>
    <p><?php _e("Naziv artikla: " ); ?><input type="text" name="foodor_item_title" value="<?php if($getid <> ''){ echo $rowid->title; }?>" size="20"><?php _e(" ex: Pizza" ); ?></p>
    <p><?php _e("Opis artikla: " ); ?><input type="text" name="foodor_item_description" value="<?php if($getid <> ''){ echo $rowid->description; }?>" size="20"><?php _e(" ex: Velika, mala..." ); ?></p>
    <p><?php _e("Cena artikla: " ); ?><input type="text" name="foodor_item_price" value="<?php if($getid <> ''){ echo $rowid->price; }?>" size="20"><?php _e(" ex: 100.99" ); ?></p>
    <p><?php _e("Photo link: " ); ?><input type="text" name="foodor_item_itemurl" value="<?php if($getid <> ''){ echo $rowid->image_url; }?>" size="20"><?php _e(" ex: http://www.olala.co.rs/..." ); ?></p>
    <p><?php _e("Menu lista: " ); ?><input type="checkbox" name="foodor_item_menu" value="" size="20" <?php if(($rowid->menu)==true){echo 'checked';} ?> ><?php _e(" ex: Da li se prikazuje na spisku?" ); ?></p>
    <p><?php _e("Danasnji menu: " ); ?><input type="checkbox" name="foodor_item_today_menu" value="" size="20" <?php if(($rowid->today_menu)==true){echo 'checked';} ?> ><?php _e(" ex: Da li je na danasnjem meniu?" ); ?></p>

    <input type="hidden" name="foodor_item_id" value="<?php if($getid <> ''){  echo $rowid->id; }?>" size="20">

    <p class="submit">
        <input type="submit" name="Submit" value="<?php if($getid <> ''){_e('Izmeni artikal '.$getid);}else{_e('Dodaj artikal');} ?>" />
    </p>
</form>
</div>


<hr />


<?php

$sqlitemall = "SELECT * FROM $table_name ORDER BY id ASC ";

print_r("<br />Shortcode iznosi: $shortcode");

if (!$results = $connection->get_results($sqlitemall)){
    die('Ne postoje podaci. Nakon unosa podataka o artiklima, bice prikazana tabela svih zapisa.<br />
        Potvrdite podesavanja na prvoj strani (tabele u bazi podataka).');
}

echo "<h1>Ukupno u ponudi imamo ". count($results) ." artikala!</h1>";

?>

<table class="table table-hover datagrid">
    <tr style="background-color: chocolate">
        <th>R B</th>
        <th>Naziv artikla</th>
        <th>Detaljniji opis</th>
        <th>Cena artikla</th>
        <th>Fotka artikla</th>
        <th>Obrisi</th>
    </tr>

    <?php foreach($results as $row){ ?>
        <tr>
            <!--td><!?php echo "<a href='show.php?id=".$row['id']." >". $row['id']."</a>" ?></td-->
            <td><?php echo "<a href='{$shortcode}&id={$row->id}'>{$row->id}</a>"; ?></td>
            <td><?php echo $row->title; ?></td>
            <td style='width: 200px'><?php echo $row->description; ?></td>
            <td><?php echo $row->price; ?></td>
            <!--td><!--?php echo "<a href='picture.php?url=".urlencode($row['image_url'])."' ><img src=".$row['image_url']." style="width=30px;height=30px"></a>" ?></td-->
            <td><?php echo "<a href='{$shortcode}&id={$row->id}' ><img src='{$row->image_url}' style='width:50px;height:50px'></a>"; ?></td>
            <td><?php echo "<a href='{$shortcode}&del={$row->id}' style='color:red'>Obrisi</a>"; ?></td>
        </tr>
    <?php } ?>

</table>

<hr />