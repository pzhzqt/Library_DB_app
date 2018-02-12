<?php
if(isset($_POST["lookfor"])){
	$entry_user=$_POST["lookfor"];
	$param="%".$entry_user."%";
	if($_POST["type"]=="title") {
		$sql = $conn->prepare("SELECT * FROM Book_avail WHERE title LIKE ?");
		$sql->bind_param('s',$param);
	}else if($_POST["type"]=="isbn") {
		$sql = $conn->prepare("SELECT * FROM Book_avail WHERE isbn = ?");
		$sql->bind_param('s',$entry_user);
	}else if($_POST["type"]=="course") {
		$sql = $conn->prepare("SELECT * FROM Book_avail b, Textbook t, Class c WHERE b.isbn = t.isbn AND t.classid = c.classid AND c.course_title LIKE ?");
		$sql->bind_param('s',$param);
	}else if($_POST["type"]=="professor") {
		$name = explode(" ",$entry_user);
		$param0="%{$name[0]}%";
		if( isset($name[0]) && !isset($name[1]) ) {
			$sql = $conn->prepare("SELECT b.isbn,title,price,total_avail,concat(FName,' ',LName) as Instructor FROM Book_avail b, Textbook t, Teaching v, Teacher p WHERE b.isbn = t.isbn AND t.classid = v.classid AND v.teacherid = p.teacherid AND (p.fname LIKE ? OR p.lname LIKE ?)");
			$sql->bind_param('ss',$param0,$param0);
		}else if( isset($name[0]) && isset($name[1]) ) {
			$param1="%{$name[1]}%";
			$sql = $conn->prepare("SELECT b.isbn,title,price,total_avail,concat(FName,' ',LName) FROM Book_avail b, Textbook t, Teaching v, Teacher p WHERE b.isbn = t.isbn AND t.classid = v.classid AND v.teacherid = p.teacherid AND (p.fname LIKE ? AND p.lname LIKE ?)");
			$sql->bind_param('ss',$param0,$param1);
		}
	}
}
if(isset($_POST["info"])){
	$info=$_POST["info"];
	if($info=="User Information"){
		$sql = $conn->prepare("SELECT * from access_level order by access_level");
	}else if($info=="Student Information"){
		$sql = $conn->prepare("SELECT * from student_complete_info");
	}else if($info=="Book Information"){
		$sql = $conn->prepare("SELECT * from storage natural join book");
	}else if($info=="Course Information"){
		$sql = $conn->prepare("SELECT * from teaching_info");
	}else if($info=="Checkout Information"){
		$sql = $conn->prepare("SELECT * from checkout_info");
	}
}
if(isset($_POST["checkout"])){
	$admin_id = get_admin_id($username,$conn);
	$student_id = $_POST["studentid"];
	$book_id = $_POST["bookid"];
	$sql = $conn->prepare("INSERT INTO Book_Checkout VALUES(curdate(),curdate()+interval 30 day,?,?,?)");
	$sql->bind_param('iii',$student_id,$admin_id,$book_id);
}
if(isset($_POST["return"])){
	$book_id = $_POST["bookid"];
	$sql = $conn->prepare("Delete from book_checkout where bookid=?");
	$sql->bind_param('i',$book_id);
}
if(isset($_POST["lookfor_co"])){
	$entry_user=$_POST["lookfor_co"];
	$param="%".$entry_user."%";
	if($_POST["type"]=="title") {
		$sql = $conn->prepare("SELECT * FROM checkout_info WHERE title LIKE ?");
		$sql->bind_param('s',$param);
	}else if($_POST["type"]=="id") {
		$sql = $conn->prepare("SELECT * FROM checkout_info WHERE bookid = ?");
		$sql->bind_param('i',$entry_user);
	}else if($_POST["type"]=="course") {
		$sql = $conn->prepare("SELECT * FROM checkout_info WHERE course_title LIKE ?");
		$sql->bind_param('s',$param);
	}
}

	$sql->execute();
	$result = $sql->get_result();	
?>
