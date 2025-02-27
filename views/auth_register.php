<h1>Registration Page</h1>

<form action="/register" method="POST">
	<div>
		<label for="email">Email</label>
		<input id="email" type="email" name="email" required>
	</div>
	<div>
		<label for="password">Password</label>
		<input id="password" type="password" name="password" required>
	</div>

	<div>
		<button type="submit">Register</button>
	</div>
</form>

<p>
	Already have an account? Log in <span><a href="/login">here</a></span>
</p>
