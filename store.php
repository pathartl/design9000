<?php
/**
 * Template Name: Store Template
 * Description: If you'd rather have a specific homepage rather than your blog posts. View readme.txt file for instructions.
 *
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
get_header();

$store_table = 'wp_store';

// Make a connection with the database using info defined in wp_config.php
$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$connection) {
	die("Could not connect: " . mysql_error());
}

$items = "";

// Select the database
mysql_select_db(DB_NAME, $connection);

$side = "item-left";

$query = "SELECT DISTINCT(category) FROM `wp_store`";
$result = mysql_query($query);

$category;

while($row = mysql_fetch_array($result)) {
	$category[] = $row['category'];
}

if ($_GET['category']) {
	$query = "SELECT * FROM " . $store_table . " WHERE category = '" . $_GET['category'] . "'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		$items = $items . '<div class="simpleCart_shelfItem store-item ' . $side . '" id="' . $row['id'] . '">' .
				'<a class="fancybox" title="' . $row['description'] . '" href="' . get_bloginfo('url') . '/uploads/' . $row['id'] . '.jpg">' .
				'<img class="thumb" alt="' . $row['id'] . '" src="' . get_bloginfo('url') . '/uploads/thumbnails/' . $row['id'] . '_store.jpg" />' .
				'</a><br><div class="item_name item-id">' . $row['id'] . '</div>' .
				'<div class="item_price item-price">$' . $row['price'] . '</div>';
		if ($row['stock'] == 0) $items = $items . '<div class="item_add">Out of Stock</div>';
		else $items = $items . '<div class="item_add"><a href="javascript:;" >Add to Cart</a></div>' .
				'<div class="item-stock">In Stock</div>';
		if ($row['sizes']) {
			$items = $items . '<div class="item-size">Size: <select class="item_size">';
			$sizes = explode("-", $row['sizes']);
			$i = $sizes[0];
			for ($i; $i <= $sizes[1]; $i++) {
				$items = $items . '<option value="' . $i . '">' . $i . '</option>';
			}
			$items = $items . '</select></div>';
		}
		$items = $items . '<input type="hidden" class="item_quantity" value="1">' .
				'</div>';
		if ($side == "item-left") {
			$side == "item-right";
		} else {
			$side == "item-left";
		}
	}
} else {
	for ($i = 0; $i < count($category); $i++) {
		$query = "SELECT * FROM " . $store_table . " WHERE category = '" . $category[$i] . "' ORDER BY RAND()";
		$result = mysql_fetch_array(mysql_query($query));
		$items = $items . '<div class="store-item ' . $side . '">' .
			'<a href="?category=' . $category[$i] . '"><img class="thumb" src="' . get_bloginfo('url') . '/uploads/thumbnails/' . $result[0] . '_store.jpg"></a>' .
			'<div style="text-align: center"><a href="?category=' . $category[$i] . '">' . $category[$i] . '</a></div>' .
			'</div>';
		if ($side == "item-left") {
			$side == "item-right";
		} else {
			$side == "item-left";
		}
	}
}

$items = $items . '<div class="clear"></div>';
?>
<div id="store-content">
	<?php echo $items; ?>
	<div id="shopping-cart-title">
		<h2 class="welcome-title">Shopping Cart</h2>
	</div>
	<div class="shopping-cart" id="shopping-cart">
		<div class="simpleCart_items"></div>
		<table id="totals">
			<tr>
				<td class="total-label">Shipping:</td>
				<td class="total-value">$3.00</td>
			</tr>
			<tr>
				<td class="total-label">Final Total:</td>
				<td class="total-value"><span class="simpleCart_finalTotal"></span></td>
			</tr>
			<tr>
				<td colspan="2" id="checkout"><a href="javascript:;" class="simpleCart_checkout">Checkout</a></td>
			</tr>
		</table>
	</div>
</div>
<div id="store-sidebar">
	<h3>Pages</h3>
	<ul>
		<?php wp_list_pages( array( 'title_li' => '', 'categorize' => 0 ) ); ?>
		<?php
			if(is_user_logged_in()) {
				echo '<li><a href="' . get_bloginfo('url') . '/inventory">Inventory</a></li>';
			}
		?>
	</ul>
	<h3>Categories</h3>
	<ul>
	<?php
		for ($i = 0; $i < count($category); $i++) {
			echo '<li><a href="?category=' . $category[$i] . '">' . $category[$i] . '</a></li>';
		}
	?>
	</ul>
</div>

<?php

get_footer();

?>