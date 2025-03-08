<h1 class="title">Registration Page</h1>

<?php
if (isset($error)) {
	echo "<span class='has-text-danger'>$error</span>";
}
if (isset($message)) {
	echo "<span class='has-text-success'>$message</span>";
}
?>

<form action="/register" method="POST">
	<div class="field">
		<label class="label" for="email">Email</label>
		<input class="input" id="email" type="email" name="email" required value=<?= $_POST["email"] ?? $email ?? ""; ?>>
	</div>
	<div class="field">
		<label class="label" for="password">Password</label>
		<input class="input" id="password" type="password" name="password" required>
	</div>

	<div class="control">
		<button class="button is-link" type="submit">Register</button>
	</div>
</form>

<p>
	Already have an account? Log in <span><a href="/login">here</a></span>
</p>
