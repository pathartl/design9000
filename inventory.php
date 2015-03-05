<?php
/**
 * Template Name: Inventory
 * Description: If you'd rather have a specific homepage rather than your blog posts. View readme.txt file for instructions.
 *
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
get_header(); ?>

<?php

include('inc/SimpleImage.php');

$store_table = 'wp_store';
$image_path = "uploads/";

// Make a connection with the database using info defined in wp_config.php
$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$connection) {
	die("Could not connect: " . mysql_error());
}

// Select the database
mysql_select_db(DB_NAME, $connection);

// Check if data was POSTed
if (($_POST['remove'] != "Remove") && $_POST["id"]) {

	// If we have data for a new row
	if ($_POST["old_id"] == "newrow") {
		// Set the data to be written from POST
		$data = "'" . $_POST['id'] . "', '" . $_POST['description'] . "', '" . $_POST['price'] . "', '" . $_POST['stock'] . "', '" . $_POST["category"] . "', '" . $_POST["sizes"] . "'";
		echo $data . "<br>";
		// Insert into database
		$query = "INSERT INTO " . $store_table . " (id, description, price, stock, category, sizes) " .
		"VALUES (" . $data . ")";

		mysql_query($query);
	} else { // If we're updating a row
		$query = "UPDATE " . $store_table . " SET id = '" . $_POST['id'] .
			"', description = '" . $_POST['description'] .
			"', price = '" . $_POST['price'] .
			"', stock = '" . $_POST['stock'] .
			"', category = '" . $_POST['category'] .
			"', sizes = '" . $_POST['sizes'] .
			"' WHERE id = '" . $_POST['old_id'] . "'";
		mysql_query($query);
		rename($image_path . $_POST['old_id'], $image_path . $_POST['id']);
	}
}

// Check if we're uploading a file
if (($_POST['remove'] != "Remove") && ($_FILES["image"]["type"] == "image/jpeg") && ($_FILES["file"]["size"] < 2000000)) {
	if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path . $_POST['id'] . ".jpg")) {
		// Generate store thumbnail
		$storeThumb = new SimpleImage();
		$storeThumb->load($image_path . $_POST['id'] . ".jpg");
		$storeThumb->resizeToWidth(250);
		$storeThumb->save($image_path . "thumbnails/" . $_POST['id'] . "_store.jpg");
		// Generate cart thumbnail
		$storeThumb = new SimpleImage();
		$storeThumb->load($image_path . $_POST['id'] . ".jpg");
		$storeThumb->resizeToWidth(100);
		$storeThumb->save($image_path . "thumbnails/" . $_POST['id'] . "_cart.jpg");

		echo "<script type='text/javascript'>alert('The file " . basename($FILES['image']['name']) . " has been uploaded')</script>";
	} else {
		echo "There was an error uploading the file.";
	}
}

// Check if we're going to remove a row
if (($_POST['remove'] == "Remove")) {
	$query = "DELETE FROM " . $store_table . " WHERE id = '" . $_POST['old_id'] . "'";
	mysql_query($query);
	if (file_exists($image_path . $_POST['old_id'] . ".jpg")) {
		unlink($image_path . $_POST['old_id'] . ".jpg");
		unlink($image_path . "thumbnails/" . $_POST['id'] . "_store.jpg");
		unlink($image_path . "thumbnails/" . $_POST['id'] . "_cart.jpg");
	}
}

// Check if the table $store_table exists
if (!mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $store_table . "'"))) {
	echo "Table does not exist, creating!";
	// Create the table
	mysql_query("CREATE TABLE " . $store_table . " (
		id CHAR(8), description LONGTEXT, price VARCHAR(6), stock INT(3), category VARCHAR(100))");
}

$result = mysql_query("SELECT * FROM " . $store_table . " ORDER BY category,description ASC");

?>
<table width="100%" id="inventory">
<form enctype="multipart/form-data" action="<?php echo get_bloginfo('url') . '/inventory'; ?>" method="post"><tr>
	<input type="hidden" name="old_id" value="newrow" />
	<td><input type="file" name="image" /></td>
	<td><input type="text" name="id" /></td>
	<td><input type="text" name="description" /></td>
	<td><input type="text" name="sizes" /></td>
	<td><input type="text" name="price" /></td>
	<td><input type="text" name="stock" /></td>
	<td><input type="text" name="category" /></td>
	<td> <input type="submit" value="Add" /></td>
	<td></td>
</tr></form>
	<tr>
		<td>Image</id>
		<td>Stock ID</id>
		<td>Description</td>
		<td>Sizes</td>
		<td>Price</td>
		<td>Stock</td>
		<td>Category</td>
		<td></td>
		<td></td>
	</tr>
<?php
	while($row = mysql_fetch_array($result)) {
		echo '<form enctype="multipart/form-data" action="' . get_bloginfo('url') . '/inventory" method="post"><input type="hidden" name="old_id"' . 
			' value="' . $row['id'] . '" /><tr>';
		echo '<td>';
		if (file_exists($image_path . $row['id'] . '.jpg')) {
			echo '<a class="fancybox" href="' . get_bloginfo('url') . '/' . $image_path . $row['id'] . '.jpg" target="_blank">Preview</a>';
		}
		echo '<input type="file" name="image" /></td>';
		echo '<td><input type="text" value="' . $row['id'] . '" name="id" /></td>';
		echo '<td><input type="text" value="' . $row['description'] . '" name="description" /></td>';
		echo '<td><input type="text" value="' . $row['sizes'] . '" name="sizes" /></td>';
		echo '<td><input type="text" value="' . $row['price'] . '" name="price" /></td>';
		echo '<td><input type="text" value="' . $row['stock'] . '" name="stock" /></td>';
		echo '<td><input type="text" value="' . $row['category'] . '" name="category" /></td>';
		echo '<td><input type="submit" id="save" value="Save" name="save" /></td>';
		echo '<td><input type="submit" id="remove" value="Remove" name="remove" /></td>';
		echo '</tr></form>';
	}
?>


<?php
echo '</table>';

?>

<?php get_footer(); ?>
