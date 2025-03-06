<h1 class="title">Update Event</h1>
<h2 class="subtitle">Updating the event</h2>

<?php
if (isset($error)) {
	echo "<span style='color:red;'>$error</span>";
}
?>

<form action="/event/update">

	<div class="field">
		<label class="label" for="name">Event Name</label>
		<input class="input" id="name" type="text" name="name" value="" required>
	</div>

	<div class="field">
		<label class="label" for="startDate">Start Date</label>
		<input class="input" id="startDate" type="date" name="startDate" value="" required>
	</div>

	<div class="field">
		<label class="label" for="endDate">End Date</label>
		<input class="input" id="endDate" type="date" name="endDate" value="" required>
	</div>

	<div class="field">
		<label class="label" for="location">Location</label>
		<input class="input" id="location" type="text" name="location" value="" required>
	</div>

	<div class="field">
		<label class="label" for="price">Price</label>
		<input class="input" id="price" type="number" name="price" min="0" value="0" step=".01" value="" required>
	</div>

	<div class="control"><button class="button is-info">Update Event</button></div>
</form>
