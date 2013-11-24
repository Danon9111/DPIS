<?php
	function top()
	{
?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="style.css" />
		<title>PHP with DB</title>
	</head>
	<body>
<?php
	}

	function bottom()
	{
?>
	</body>
	</html>
<?php
	}
	
	function form()
{
?>
	<section>
		Add new record to database!
		<table>
		<form action="insert.php" method="post">
			<tr>
				<td>
					Name:<input type="text" name="name">
				</td>
			</tr>
			<tr>
				<td>
					Surname:<input type="text" name="surname">
				</td>
			</tr>
			<tr>
				<td>
				<input type="submit" name="ok" value="Insert" />
				</td>
			</tr>
		</form>
		</table>
	</section>
	<section>
		<article>
			To edit some records click <a href="select.php">here.</a>
		</article>
	</section>
<?php
}
	
	function connect_db()
	{    
		$connection = @mysql_connect('localhost', 'root', '')
			or die('No connection with MySQL server.<br />Error: '.mysql_error());
			echo "We connect to server!<br />";
			
		$db = @mysql_select_db('pracownicy', $connection)
			or die('Database is unavailable<br />Error: '.mysql_error());
			echo "Database is available! <br />"; 
	}
	
	function display_db()
	{
		$result=mysql_query("SELECT * FROM persons") 
			or die('Incorrect query'); 
			
		if(mysql_num_rows($result) > 0) 
		{ 
			echo "<table cellpadding=\"2\" border=1>"; 
			while($r = mysql_fetch_assoc($result))
			{ 
				echo "<tr>"; 
					echo "<td>".$r['name']."</td>"; 
					echo "<td>".$r['surname']."</td>"; 
					echo "<td> 
							<a href=\"select.php?a=del&amp;id={$r['id']}\">DEL</a>
							<a href=\"select.php?a=edit&amp;id={$r['id']}\">EDIT</a>
						</td>"; 
				echo "</tr>"; 
			} 
    echo "</table>"; 
		} 
	}
	
	function insert()
	{
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		
		$insert = @mysql_query("INSERT INTO `persons` SET name='$name', surname='$surname'"); 
		if($insert) 
			echo "Record was added to table! <br />"; 
		else 
			echo "Houston we have a problem"; 
	}
	
	function edit()
	{
		$a = trim($_REQUEST['a']); 
		$id = trim($_GET['id']); 

		if($a == 'edit' and !empty($id)) {
			$result1 = mysql_query("SELECT * FROM persons WHERE id='$id'") 
				or die('Query error');
			if(mysql_num_rows($result1) > 0) {
				$result2 = mysql_fetch_assoc($result1);
				echo '<form action="select.php" method="post"> 
						<input type="hidden" name="a" value="save" /> 
						<input type="hidden" name="id" value="'.$id.'" />
						name:<br /> 
						<input type="text" name="name" 
						value="'.$result2['name'].'" /><br />
						surname:<br /> 
						<input type="text" name="surname" 
						value="'.$result2['surname'].'" /><br />
						<input type="submit" value="Edit" /> 
					</form>'; 
			} 
		} 
		elseif($a == 'save') { 
			$id = $_POST['id']; 
			$name = trim($_POST['name']); 
			$surname = trim($_POST['surname']); 
			
			mysql_query("UPDATE persons SET name='$name', surname='$surname' WHERE id='$id'") 
				or die('Query error'); 
				echo 'Good job my boy :D <br />And now refresh page!';
		} 
	}
	
	function delete()
	{
		$a = trim($_GET['a']); 
		$id = trim($_GET['id']); 

		if($a == 'del' and !empty($id)) {
			mysql_query("DELETE FROM persons WHERE id='$id'") 
				or die('Query error: '.mysql_error()); 
				echo "Good job! You delete record: $id. Refresh page!"; 
		} 
	}
?>