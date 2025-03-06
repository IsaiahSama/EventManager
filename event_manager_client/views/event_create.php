<h1 class="title">Create An Event</h1>

<?php
if (isset($error)) {
	echo "<span style='color:red;'>$error</span>";
}
?>

<form action="/event/create" method="POST">

	<div class="field">
		<label class="label" for="name">Event Name</label>
		<input class="input" id="name" type="text" name="name" required>
	</div>

	<div class="field">
		<label class="label" for="startDate">Start Date</label>
		<input class="input" id="startDate" type="date" name="startDate" required>
	</div>

	<div class="field">
		<label class="label" for="endDate">End Date</label>
		<input class="input" id="endDate" type="date" name="endDate" required>
	</div>

	<div class="field">
		<label class="label" for="location">Location</label>
		<input class="input" id="location" type="text" name="location" required>
	</div>

	<div class="field">
		<label class="label" for="price">Price</label>
		<input class="input" id="price" type="number" name="price" min="0" value="0" step=".01" required>
	</div>

	<div class="control"><button class="button is-info">Create Event</button></div>
</form>
