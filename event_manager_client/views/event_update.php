<h1 class="title">Update Event</h1>
<h2 class="subtitle">Updating the event <?= $event['eventName'] ?? '' ?> </h2>

<?php
if (isset($error)) {
	echo "<span class='has-text-danger'>$error</span>";
}
if (isset($message)) {
	echo "<span class='has-text-success'>$message</span>";
}
?>

<form action="/event/<?= $event['eventID'] ?>/update" method="POST">

	<div class="field">
		<label class="label" for="eventName">Event Name</label>
		<input class="input" id="eventName" type="text" name="eventName" value="<?= $event['eventName'] ?? '' ?>" required>
	</div>

	<div class="field">
		<label class="label" for="startDate">Start Date</label>
		<input class="input" id="startDate" type="date" name="startDate" value="<?= $event['startDate'] ?? '' ?>" required>
	</div>

	<div class="field">
		<label class="label" for="endDate">End Date</label>
		<input class="input" id="endDate" type="date" name="endDate" value="<?= $event['endDate'] ?? '' ?>" required>
	</div>

	<div class="field">
		<label class="label" for="location">Location</label>
		<input class="input" id="location" type="text" name="location" value="<?= $event['location'] ?? '' ?>" required>
	</div>

	<div class="field">
		<label class="label" for="price">Price</label>
		<input class="input" id="price" type="number" name="price" value="<?= $event['price'] ?? '1.00' ?>" min="1" step=".01" required>
	</div>

	<div class="control"><button class="button is-info">Update Event</button></div>
</form>
