<h1 class="title">Create An Event</h1>

<?php
if (isset($error)) {
	echo "<span class='has-text-danger'>$error</span>";
}

if (isset($message)) {
	echo "<span class='has-text-info'>$message</span>";
}
?>

<form action="/event/create" method="POST">

	<div class="field">
		<label class="label" for="eventName">Event Name</label>
		<input class="input" id="eventName" type="text" name="eventName" required value=<?= $_POST["eventName"] ?? "" ?>>
		<span class="has-text-danger"> <?= $eventName ?? "" ?></span>
	</div>

	<div class="field">
		<label class="label" for="startDate">Start Date</label>
		<input class="input" id="startDate" type="date" name="startDate" required value=<?= $_POST["startDate"] ?? "" ?>>
		<span class="has-text-danger"><?= $startDate ?? "" ?></span>
	</div>

	<div class="field">
		<label class="label" for="endDate">End Date</label>
		<input class="input" id="endDate" type="date" name="endDate" required value=<?= $_POST["endDate"] ?? "" ?>>
		<span class="has-text-danger"><?= $endDate ?? "" ?></span>
	</div>

	<div class="field">
		<label class="label" for="location">Location</label>
		<input class="input" id="location" type="text" name="location" required value=<?= $_POST["location"] ?? "" ?>>
		<span class="has-text-danger"><?= $location ?? "" ?></span>
	</div>

	<div class="field">
		<label class="label" for="price">Price</label>
		<input class="input" id="price" type="number" name="price" min="1" step=".01" required value=<?= $_POST["price"] ?? 1.00 ?>>
		<span class="has-text-danger"><?= $price ?? "" ?></span>
	</div>

	<div class="control"><button class="button is-info">Create Event</button></div>
</form>
