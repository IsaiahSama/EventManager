<h1>Registration Page</h1>

<form action="/register" action="POST">
	<div>
		<label for="email">Email</label>
		<input id="email" type="email" name="email" required>
	</div>
	<div>
		<label for="passsword">Passsword</label>
		<input id="passsword" type="passsword" name="passsword" required>
	</div>

	<div>
		<button type="submit">Register</button>
	</div>
</form>

<p>
	Already have an account? Log in <span><a href="/login">here</a></span>
</p>
