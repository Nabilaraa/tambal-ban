<!DOCTYPE html>
<html>

<head>
	<title>Change Password</title>
	<link rel="stylesheet" href="<?= BASE_URL . '/css/style.css' ?>">
</head>

<body>
	<div style="max-width: 700px; margin: auto;">
		<a href="<?= BASE_URL . "/account/edit" ?>">Ubah Profil</a> |
		<a href="<?= BASE_URL . "/account/change-password" ?>">Ubah Password</a> |
		<a href="<?= BASE_URL . "/logout" ?>">Log out</a>

		<h1>Change Password</h1>

		<?php if ($success) : ?>
			<div class="alert success">
				<?= $success ?>
			</div>
		<?php endif ?>

		<?php if ($error) : ?>
			<div class="alert danger">
				<?= $error ?>
			</div>
		<?php endif ?>

		<form action="" method="POST">
			<input type="password" name="oldPassword" placeholder="Old Password"> <br>
			<input type="password" name="newPassword" placeholder="New Password"> <br>
			<input type="password" name="passwordConfirmation" placeholder="Password Confirmation"> <br>
			<button type="submit" class="btn success">Simpan</button>
			<a href="<?= BASE_URL . "/tire-patches" ?>" class="btn default">Back</a>
		</form>
	</div>
</body>

</html>