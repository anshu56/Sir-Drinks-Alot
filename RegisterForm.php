<div id='registerForm' style="display: none; width: 600px;">
<h1> Register </h1>
<br/>
<form action="process.php" method="post" enctype="multipart/form-data">
	<table>
	<tr>
	<td>Username:</td>
	<td><input type="text" maxlength="25" name="user" /></td>
	</tr>
	<tr>
	<td>Password:</td>
	<td><input type="password" maxlength="25" name="pass" /></td>
	</tr>
	<tr>
	<td>Name:</td>
	<td><input type="text" maxlength="32" name="name" /></td>
	</tr>
	<tr>
	<td>Age:</td>
	<td><input type="text" maxlength="3" name="age" /></td>
	</tr>
	<tr>
	<td>Gender:</td>
	<td><input type="text" maxlength="6" name="gender" /></td>
	</tr>
	<tr>
	<td>Location:</td>
	<td><input type="text" maxlength="6" name="location" /></td>
	</tr>
	<tr>
	<td>E-mail:</td>
	<td><input type="text" maxlength="32" name="email" /></td>
	</tr>

	</table>
	<input type="hidden" name="subjoin" value="1" />
	<input type="submit" name="submit" value="Create Account" />
</form>
</div>