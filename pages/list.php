<?php$list_id = $_GET['id'];//Instantiate Database object$database = new Database;//Query$database->query('SELECT * FROM lists WHERE id = :id');$database->bind(':id',$list_id);$row = $database->single();echo '<h1>'.$row['list_name'].'</h1>';echo '<p>'.$row['list_body'].'</p>';echo '<a class="btn btn-secondary" href="?page=edit_list&id='.$row['id'].'">Edit List</a> | ';echo '<a class="btn btn-danger" href="?page=delete_list&id='.$row['id'].'">Delete List</a>';//Instantiate Database object$database = new Database;//Query$database->query('SELECT * FROM tasks WHERE list_id = :list_id AND is_complete = :is_complete');$database->bind(':list_id',$list_id);$database->bind(':is_complete',0);$rows = $database->resultset();echo '<h3>Tasks</h3>';if($rows){echo '<table class="table table-hover table-bordered">';foreach($rows as $task){	echo '<tr>	<td><h4><a href="?page=task&id='.$task['id'].'">'.$task['task_name'].'</a></h4></td>	</tr>';}echo '</table>';} else {	echo '<h3>No tasks for this list..</h3> <a class="btn btn-primary" href="index.php?page=new_task&listid='.$_GET['id'].'">Add Task</a>';}