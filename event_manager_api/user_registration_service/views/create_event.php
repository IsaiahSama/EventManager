<h1>Create An Event</h1>

<form action="/event/create" method="POST">
	
	<div>
		<label for="name">Event Name</label>
		<input id="name" type="text" name="name" required>
	</div>

	<div>
		<label for="startDate">Start Date</label>
		<input id="startDate" type="date" name="startDate" required>
	</div>

	<div>
		<label for="endDate">End Date</label>
		<input id="endDate" type="date" name="endDate" required>
	</div>

	<div>
		<label for="location">Location</label>
		<input id="location" type="text" name="location" required>
	</div>

	<div>
		<label for="price">Price</label>
		<input id="price" type="number" name="price" min="0" value="0" step=".01" required>
	</div>
</form>
