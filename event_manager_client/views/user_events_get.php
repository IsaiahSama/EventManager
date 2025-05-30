<h1 class="title">User Events</h1>
<h2 class="subtitle">Viewing Events for user of ID <?= $userID ?></h2>

<table class="table">
	<thead>
		<tr>
			<th>Event Owner</th>
			<th>Event Name</th>
			<th>Event Location</th>
			<th>Event Price</th>
			<th>Event Start Date</th>
			<th>Event End Date</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (!isset($events)) {
			echo "No Events";
		} else {
			foreach ($events as $event) {
				echo "<tr>";
				echo "<td>" . $event["hostEmail"] . "</td>";
				echo "<td>" . $event["eventName"] . "</td>";
				echo "<td>" . $event["location"] . "</td>";
				echo "<td>" . $event["price"] . "</td>";
				echo "<td>" . $event["startDate"] . "</td>";
				echo "<td>" . $event["endDate"] . "</td>";
				echo "</tr>";
			}
		}

		?>
	</tbody>
</table>
