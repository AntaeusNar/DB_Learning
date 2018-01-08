<?php
/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
 

if (isset($_POST['submit']))
{
	
	require "../config.php";
	require "../common.php";
	try 
	{
		$connection = new PDO($dsn, $username, $password, $options);
		
		$new_user_name = array(
			"first_name" => $_POST['firstname'],
			"last_name"  => $_POST['lastname'],
		);
		
		//first add names to name table and get the id number out
		$sql = sprintf("INSERT INTO %s (%s) values (%s);", "names", implode(", ", array_keys($new_user_name)),":" . implode(", :", array_keys($new_user_name)));
		$sql .= "SELECT LAST_INSERT_ID() INTO @name_id;";
		
		$statement = $connection->prepare($sql);
		$last_insert_id = $statement->execute($new_user_name);
		//build array for next insert
		$new_user_info = array(
			"name_id"	=> $last_insert_id,
			"email"     => $_POST['email'],
			"age"       => $_POST['age'],
			"location"  => $_POST['location']
		);
		
		$sql = sprintf("INSERT INTO %s (%s) values (%s);", "users", implode(", ", array_keys($new_user_info)),":" . implode(", :", array_keys($new_user_info)));
				
		$statement = $connection->prepare($sql);
		$statement->execute($new_user_info);
	}
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
	
}
?>

<?php require "templates/header.php"; ?>

<?php 
if (isset($_POST['submit']) && $statement) 
{ ?>
	<blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php 
} ?>

<h2>Add a user</h2>

<form method="post">
	<label for="firstname">First Name</label>
	<input type="text" name="firstname" id="firstname">
	<label for="lastname">Last Name</label>
	<input type="text" name="lastname" id="lastname">
	<label for="email">Email Address</label>
	<input type="text" name="email" id="email">
	<label for="age">Age</label>
	<input type="text" name="age" id="age">
	<label for="location">Location</label>
	<input type="text" name="location" id="location">
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>