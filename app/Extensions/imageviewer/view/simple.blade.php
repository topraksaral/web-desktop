<!DOCTYPE html>
<html>
<head>
	<title>Image Viewer</title>
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
	.imageviewer-body .image img {
		display: block;
		max-width: calc(100% - 2px);
		max-height: calc(100% - 2px);
		width: auto;
		height: auto;
	    vertical-align: middle;
		margin: auto;
	}
	.imageviewer-body .back {
		position: absolute;
		top: calc(50% - 19px);
		left: 10px;
		width: 40px;
		height: 40px;
		opacity: 0.5;
		background-color: #FFFFFF;
		border-radius: 6px;
		background-image:url("{{ route('call.extension.static', ['ext' => 'imageviewer', 'type' => 'image', 'all' => 'arrow.png']) }}");
	    background-repeat: no-repeat;
		background-position: center;
	    background-size: 34px 34px;
	}
	.imageviewer-body .next {
		position: absolute;
		top: calc(50% - 20px);
		right: 10px;
		width: 40px;
		height: 40px;
		opacity: 0.5;
		background-color: #FFFFFF;
		border-radius: 6px;
		background-image:url("{{ route('call.extension.static', ['ext' => 'imageviewer', 'type' => 'image', 'all' => 'arrow.png']) }}");
	    background-repeat: no-repeat;
		background-position: center;
	    background-size: 34px 34px;
		-webkit-transform: rotate(180deg);
		transform: rotate(180deg);
	}
</style>
<body>
	<div class="imageviewer-warp">
		<div class="imageviewer-header">
			{{ $fileName }}
		</div>
		<div class="imageviewer-body">
			<div class="image">
				<img src="{{ route('file.download') }}?file={{ $current }}">
			</div>
			@if($back)
			<a href="{{ route('call.extension', ['ext' => 'imageviewer']).'?file='.$back }}">
				<div class="back"></div>
			</a>
			@endif
			@if($next)
			<a href="{{ route('call.extension', ['ext' => 'imageviewer']).'?file='.$next }}">
				<div class="next"></div>
			</a>
			@endif
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