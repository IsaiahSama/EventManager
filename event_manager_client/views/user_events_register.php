<h1 class="title">Event Registration</h1>

<form action="/user/event/register">

	<div class="field">
		<label class="label" for="event">Select Event</label>
		<select id="event" class="select" name="event">

			<option value="---">---</option>
			<?php
			foreach ($events as $event) {

				echo "<option value=" . $event["eventID"] . ">" . $event["eventName"] . "</option>";
			}
			?>

		</select>
	</div>


</form>
