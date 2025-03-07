<h1 class="title">Login Page</h1>

<?php
if (isset($error)) {
	echo "<span style='color:red;'>$error</span>";
}
?>

<form action="/login" method="POST">

	<div class="field">
		<label class="label" for="email">Email</label>
		<input class="input" type="email">
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
