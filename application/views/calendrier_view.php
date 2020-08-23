<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<title>Test</title>
	<style>
		table{
			table-layout: fixed;

		}
		td{

			width:33%;
		}
		.today{
			background: yellow;
		}
	</style>
</head>
<?php include "menu_view.php"; ?>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php echo $calendar;?>
			</div>
		</div>
	</div>


</body>
</html>
