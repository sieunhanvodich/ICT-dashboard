<!DOCTYPE html>
<html>
<head>
	<title>Calendar</title>
	<style type="text/css">
		.calendar{
			font-family: Arial;
			font-size: 12px;
		}
		table.calendar{
			margin:auto;
			border-collapse: collapse;
			width: 100%;
		}
		.calendar .days td {
			width: 80px;
			height: 80px;
			padding: 25px;
			border: 1px solid #999;
			vertical-align: top;
			background-color: #DEF;
		}
		.calendar .days td:hover{
			background-color: #FFF;
		}
		.calendar .highlight{
			font-weight: bold;
			color: #00F;
		}
	</style>
	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top:20px;">
		<div class="panel panel-default" style="margin-top:30px;">
			<div class="panel-heading">
				<center><h3 class="panel-title" style="font-size:1.5em;">Meeting Calendar</h3></center>	
			</div>
			<?php echo $calendar; ?>
		</div>
	</div>
	<?php if ($this->session->userdata('is_admin') == 1) : ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.calendar .day').click(function() {
					day_num = $(this).find('.day_num').html();
					day_data = prompt('Enter calendar event', $(this).find('.content').html());
					if(day_data != null) {
						$.ajax({
							url: window.location,
							type: 'POST',
							data: {
								day: day_num,
								data: day_data
							},
							success: function(msg){
								location.reload();
							}
						});
					}
				});
			});
		</script>
	<?php endif; ?>
</body>
</html>