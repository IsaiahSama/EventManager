<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Event Management System</title>
	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>

<body>
	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item" href="/">Event Management System</a>
		</div>

		<div id="navbarBasicExample" class="navbar-menu is-active">
			<div class="navbar-start">
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						Events
					</a>

					<div class="navbar-dropdown">
						<a class="navbar-item" href="/event/create">
							Create
						</a>
						<a class="navbar-item" href="/event/all">
							View All
						</a>
					</div>
				</div>
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						UserEvents
					</a>

					<div class="navbar-dropdown">
						<a class="navbar-item" href="/user/event/register">
							Register
						</a>
						<a class="navbar-item" href="/user/events">
							View
						</a>
					</div>
				</div>

			</div>
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<?php if (!SessionManager::userLoggedIn()): ?>
							<a class="button is-primary" href="/register">
								<strong>Sign up</strong>
							</a>
							<a class="button is-light" href="/login">
								Log in
							</a>
						<?php else: ?>
							<a class="button is-info" href="/logout">
								Logout
							</a>

						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<section class="section">
