<div class="container">
	<div>
		<h1>Welcome to TaskBox!</h1>

<?php
if($_SESSION['logged_in']){
//Instantiate Database object

$database = new Database;

//Get logged in user
$list_user = $_SESSION['username'];

//Query
$database->query('SELECT * FROM lists WHERE list_user=:list_user');
$database->bind(':list_user',$list_user);
$rows = $database->resultset();

echo '<h4>Here are your current lists</h4><br />';
if($rows){
echo '<table class="table table-hover table-bordered">';
foreach($rows as $list){
	echo '<tr>
	<td><h4><a href="?page=list&id='.$list['id'].'">'.$list['list_name'].'</a></h4></td>
	</tr>';
}
	echo '</table>';
} else {
	echo '<h3>There are no lists available...</h3> 
			<a href="index.php?page=new_list" class=" btn btn-primary">
			Create New List
			</a>';
}	
} else {
	echo "
		<p>myTasks is a small but helpful application where you can create and manage tasks to make your life easier. 
		Just register and login and you can start adding tasks</p>";
}
?>

</div>

		
	</div>
	