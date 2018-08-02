<?php
// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);


// get ID of the product to be edited and action
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// set the id as product id property
$product->id = $id;
 
// to read single record product
$product->readOne();
 
// set page title
$page_title = $product->name;


echo "<div class='col-md-4' id='product-img'>";
 
    // read all related product image
    $stmt_product_image = $product_image->readByProductId();
    $num_product_image = $stmt_product_image->rowCount();
 
    // if count is more than zero
    if($num_product_image>0){
        // loop through all product images
        $x=0;
        while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
            // image name and source url
            $product_image_name = $row['name'];
            $source="uploads/images/{$product_image_name}";
            $show_product_img=$x==0 ? "display-block" : "display-none";
            echo "<a href='{$source}' target='_blank' id='product-img-{$row['id']}' class='product-img {$show_product_img}'>";
                echo "<img src='{$source}' style='width:100%;' />";
            echo "</a>";
            $x++;
        }
    }else{ echo "No images."; }
echo "</div>";

echo "<div class='col-md-5'>";
 
    echo "<div class='product-detail'>Price:</div>";
    echo "<h4 class='m-b-10px price-description'>&#36;" . number_format($product->price, 2, '.', ',') . "</h4>";
 
    echo "<div class='product-detail'>Product description:</div>";
    echo "<div class='m-b-10px'>";
        // make html
        $page_description = htmlspecialchars_decode(htmlspecialchars_decode($product->description));
 
        // show to user
        echo $page_description;
    echo "</div>";
 
    echo "<div class='product-detail'>Product category:</div>";
    echo "<div class='m-b-10px'>{$product->category_name}</div>";
 
echo "</div>";

echo "<div class='col-md-2'>";
    // cart item settings
    $cart_item->user_id=1; // we default to a user with ID "1" for now
    $cart_item->product_id=$id;
 
    // if product was already added in the cart
    if($cart_item->exists()){
        echo "<div class='m-b-10px'>This product is already in your cart.</div>";
        echo "<a href='cart.php' class='btn btn-success w-100-pct'>";
            echo "Update Cart";
        echo "</a>";
    }
 
    // if product was not added to the cart yet
    else{
 
        echo "<form class='add-to-cart-form'>";
            // product id
            echo "<div class='product-id display-none'>{$id}</div>";
 
            // select quantity
            echo "<div class='m-b-10px f-w-b'>Quantity:</div>";
            echo "<input type='number' class='form-control m-b-10px cart-quantity' value='1' min='1' />";
 
            // enable add to cart button
            echo "<button style='width:100%;' type='submit' class='btn btn-primary add-to-cart m-b-10px'>";
                echo "<span class='glyphicon glyphicon-shopping-cart'></span> Add to cart";
            echo "</button>";
 
        echo "</form>";
    }
echo "</div>";
// get ID of the product to be edited and action
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// set the id as product id property
$product->id = $id;
 
// to read single record product
$product->readOne();
 
// set page title


$cart_item = new CartItem($db);
 
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// set the id as product id property
$product->id = $id;
 
// to read single record product
$product->readOne();
 
// set page title
$page_title = $product->name;
 
// include page header HTML
include_once 'layout_head.php';
 
// content will be here
 
// include page footer HTML
include_once 'layout_foot.php';
?>