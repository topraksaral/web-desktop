<!DOCTYPE html>
<html>
<head>
	<title>Video Player</title>
	<link href="{{ route('call.extension.static', ['ext' => 'imageviewer', 'type' => 'css', 'all' => 'icons.css']) }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ route('call.extension.static', ['ext' => 'imageviewer', 'type' => 'css', 'all' => 'icons.css']) }}">
</head>
<style type="text/css">
	html, body {
		font: 14px normal Arial, Helvetica, sans-serif;
		margin: 0px;
    	padding: 0px;
	    border: 0px;
	    width: 100%;
    	height: 100%;
    	position: relative;
	}
	a {
		color: #4286f4;
	}
	a:hover {

	}
	.imageviewer-warp {
		width: 100%;
		height: 100%;
	}
	.imageviewer-header {
		text-align: center;
		background-color: #000000;
		font-weight: bold;
		height: 18px;
		color: #FFFFFF;
	}
	.imageviewer-body {
		width: 100%;
		height: calc(100% - 18px);
	}
	.imageviewer-body .image {
		width: 100%;
		height: 100%;
		background-color: #000000;
		line-height: 100%;
	}
	.imageviewer-body .image video {
		display: block;
		max-width: calc(100% - 2px);
		max-height: calc(100% - 2px);
		width: auto;
		height: auto;
	    vertical-align: middle;
		margin: auto;
	}
</style>
<body>
	<div class="imageviewer-warp">
		<div class="imageviewer-header">
			{{ $fileName }}
		</div>
		<div class="imageviewer-body">
			<div class="image">
				<video src="{{ route('file.download') }}?file={{ $current }}" autoplay="yes" controls="yes"></video>
			</div>
		</div>
		<div class="imageviewer-footer">

		</div>
	</div>
    <script src="{{ asset('/js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		var timedelay = 1;
		function delayCheck(){
			if(timedelay == 5){
				$('.back').fadeOut();
				$('.next').fadeOut();
				timedelay = 1;
			}
			timedelay = timedelay+1;
		}
		$(document).ready(function(){
			$(document).mousemove(function() {
				$('.back').fadeIn();
				$('.next').fadeIn();
				timedelay = 1;
				clearInterval(_delay);
				_delay = setInterval(delayCheck, 500);
			});
			// page loads starts delay timer
			_delay = setInterval(delayCheck, 500);			
		});
	</script>
</body>
</html>