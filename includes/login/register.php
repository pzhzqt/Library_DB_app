<font size="6">Register</font>
<form action="register.php"
	  class="search-form"
	  method="post">
	First Name<br>
	<input type="text" placeholder="First Name" name="FName"><br>
	Last Name<br>
	<input type="text" placeholder="Last Name" name="LName"><br>
	ID<br>
	<input type="text" placeholder="Id" name="id"><br>
	Usertype<br>
	<select name="usertype">
		<option value="student">Student</option>
		<option value="teacher">Teacher</option>
		<option value="admin">Admin</option>
	</select><br>
	Username<br>
	<input type="text" placeholder="Username" name="username"><br>
	Password<br>
	<input type="password" placeholder="Password" name="password"><br>
	Confirm Password<br>
	<input type="password" placeholder="Confirm Password" name="repassword">
	<br><input type="submit" value="Register">
</form>
