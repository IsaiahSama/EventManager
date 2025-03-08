<h1 class="title">Login Page</h1>

<?php
if (isset($error)) {
	echo "<span class='has-text-danger'>$error</span>";
}
if (isset($message)) {
	echo "<span class='has-text-success'>$message</span>";
}
?>

<form action="/login" method="POST">

	<div class="field">
		<label class="label" for="email">Email</label>
		<input class="input" id="email" type="email" name="email" value=<?= $_POST["email"] ?? $email ?? "" ?> required>
	</div>

	<div class="field">
		<label class="label" for="password">Password</label>
		<input class="input" type="password">
	</div>

	<div class="control">
		<button class="button is-info">Login</button>
	</div>

</form>

<p>
	Are you new here? Register an account <span><a href="/register">here</a></span>
</p>
