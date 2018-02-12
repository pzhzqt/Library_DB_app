<script>
function goBack() {
    window.history.back();
} 
</script>
<?php
function output($result){
	if (!$result){
		echo "Succesful";
	}else if ($result && $result->num_rows > 0) {
		// output data of each row
		$data = array();
		while($row = $result->fetch_assoc())
		{
			$data[] = $row;
		}
		$colNames = array_keys(reset($data));

		echo "<table class=\"table table-bordered\">";
		echo "<tr>";
		//print the header
		foreach($colNames as $colName)
		{
		  echo "<th>$colName</th>";
		}
		echo "</tr>";
	    //print the rows
	    foreach($data as $row)
		{
			echo "<tr>";
			foreach($colNames as $colName)
			{
				echo "<td>".$row[$colName]."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}else {
		echo "<b>0 results</b><br>";
	}
}

function user_exist($username,$mysqli) {
	if($query=$mysqli->prepare('SELECT user FROM mysql.user WHERE user=?')){
		$query->bind_param('s',$username);
		$query->execute();
		$query->store_result();
		return ($query->num_rows>0) ? true : false;
	}else{
		return false;
	}
}

function info_match($id,$FName,$LName,$usertype,$mysqli){
	$user_id=$usertype."id";
	if ($query=$mysqli->prepare('select * from '.$usertype.' where '.$user_id.'=? and FName=? and LName=?')){
		$query->bind_param('iss',$id,$FName,$LName);
		$query->execute();
		$query->store_result();
		return ($query->num_rows>0) ? true : false;
	}else{
		return false;
	}
}

function account_created($id,$usertype,$mysqli){
	if($query=$mysqli->prepare('SELECT count(username) FROM '.$usertype.' WHERE '.$usertype.'id=?')){
		$query->bind_param('i',$id);
		$query->execute();
		$result=$query->get_result();
		$out=$result->fetch_assoc();
		return ($out['count(username)']>0) ? true : false;
	}else{
		return false;
	}
}

function create_user($id,$username,$password,$usertype,$mysqli){
	$sql = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'";
	$result = $mysqli->query($sql);
	if($result==true){
		$result = $mysqli->query("Grant select on * to '$username'@'localhost'");
		if($result==true){
			if($usertype=='teacher'){
				$result = $mysqli->query("Grant insert,delete,update on textbook to '$username'@'localhost'");
			}else if($usertype=='admin'){
				$result = $mysqli->query("Grant insert,delete,update on book_checkout to '$username'@'localhost'");
			}
		}
	}
	if($query=$mysqli->prepare('update '.$usertype.' set username=? where '.$usertype.'id=?')){
		$query->bind_param('si',$username,$id);
		$query->execute();
	}
	return $result;
}

function get_user_type($username,$mysqli){
	if($query=$mysqli->prepare('SELECT * FROM student WHERE username=?')){
		$query->bind_param('s',$username);
		$query->execute();
		$query->store_result();
		if($query->num_rows>0){
			return 'student';
		}else{ 
			if($query=$mysqli->prepare('SELECT * FROM teacher WHERE username=?')){
				$query->bind_param('s',$username);
				$query->execute();
				$query->store_result();
				if($query->num_rows>0){
					return 'teacher';
				}else{
					return 'admin';
				}
			}else{
				return 'nothing';
			}
		}
	}else{
		return 'nothing';
	}
}

function get_admin_id($username,$mysqli){
	if($query=$mysqli->prepare('SELECT adminid FROM admin WHERE username=?')){
		$query->bind_param('s',$username);
		$query->execute();
		$result=$query->get_result();
		$out=$result->fetch_assoc();
		return $out['adminid'];
	}else{
		return false;
	}
}

function get_teacher_id($username,$mysqli){
	if($query=$mysqli->prepare('SELECT teacherid FROM teacher WHERE username=?')){
		$query->bind_param('s',$username);
		$query->execute();
		$result=$query->get_result();
		$out=$result->fetch_assoc();
		return $out['teacherid'];
	}else{
		return false;
	}
}

function get_student_id($username,$mysqli){
	if($query=$mysqli->prepare('SELECT studentid FROM student WHERE username=?')){
		$query->bind_param('s',$username);
		$query->execute();
		$result=$query->get_result();
		$out=$result->fetch_assoc();
		return $out['studentid'];
	}else{
		return false;
	}
}

function logout(){
	if(!empty($_SESSION) && is_array($_SESSION)) {
		foreach($_SESSION as $sessionKey => $sessionValue)
			session_unset($_SESSION[$sessionKey]);
	}
}
?>