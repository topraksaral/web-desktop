<!DOCTYPE html>
<html>
<head>
	<title>File Explorer</title>
	<link rel="stylesheet" type="text/css" href="{{ route('call.extension.static', ['ext' => 'explorer', 'type' => 'css', 'all' => 'icons.css']) }}">
	<link rel="stylesheet" type="text/css" href="{{ route('call.extension.static', ['ext' => 'explorer', 'type' => 'js', 'all' => 'contextMenu.js-master/contextMenu.min.css']) }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<style type="text/css">
	html, body {
		font: 14px normal Arial, Helvetica, sans-serif;
		margin: 0px;
    	padding: 0px;
	    border: 0px;
	    width: 100%;
    	height: 100%;
	}
	a {
		color: #4286f4;
	}
	a:hover {

	}
	.ex-file {
		margin: 2px;
		z-index: -4;
		width: 130px;
		height: 130px;
		float: left;
		text-align: center;
		cursor: pointer;
	}
	.ex-file:hover {
		background-color: #f7faff;
	}
	.ex-name {
		text-overflow: ellipsis;
		white-space: nowrap;
		height: 1.2em; 
		overflow: hidden; 
		margin: 0 auto;
		width: 120px;
		position: relative;
		word-break: break-word;
	}

	.explorer-header {
		width: 100%;
		height: 35px;
		position: fixed;
		top: 0;
		left: 0;
		background-color:#FFFFFF;
		z-index: 10;
		border-bottom: 1px solid #FF0000;
	}
	.explorer-body {
		margin-top: 35px;
	}
	.path-input {
		margin: 5px;
	}
	.path-input a {
		height: 24px;
		border: 1px solid #CCCCCC;
		padding: 0;
		display: inline-block;
		padding-left: 2px;
    	padding-right: 2px;
    	font-size: 22px;
	}
	.path-input input {
		height: 22px;
		width: calc(100% - 4px);
		border: 1px solid #CCCCCC;
	}
	.helper {
		float: left;
	}
	@if(EHelper::getUpFolder($folder) == '#')
	.up {
		color: #cccccc;
		cursor: default;
	}	
	@endif
</style>
<body>
	<div class="explorer-warp">
		<div class="explorer-header">
			<div class="path-input">
				<div class="helper">
					<a class="button back" href="#"><i class="fas fa-caret-square-left"></i></a>
					<a class="button next" href="#"><i class="fas fa-caret-square-right"></i></a>
					<a class="button up" href="{{ EHelper::getUpFolder($folder) }}"><i class="fas fa-caret-square-up"></i></a>
				</div>
				<div class="" style="margin-left: 89px;">
					<input type="text" value="{{ $folder }}">
				</div>
			</div>
		</div>
		<div class="explorer-body">
			<div class="left">
				
			</div>
			<div class="right">
				@foreach($files as $file)
					@if($file['type'] == 'folder')
						<a href="{{ EHelper::openFolder($folder.$file['filename']) }}" title="{{ $file['filename'] }}" onclick="window.top.changeWindowTitle({{ $winId }}, '{{ $file['filename'] }} - Explorer')">
					@else
						<a href="#" title="{{ $file['filename'] }}" onclick="window.top.openWithApp({{ $winId }}, '{{ $folder.$file['filename'] }}'); return false;">
					@endif
						<div class="ex-file">
							<div class="ex-icon">
								@if($file['type'] == 'folder')
									<span class="icon folder full"></span>
								@else
									{!! EHelper::getIcon($folder.$file['filename']) !!}
								@endif
							</div>
							<div class="ex-name">
								{{ $file['filename'] }}
							</div>
						</div>
					</a>
				@endforeach
			</div>
		</div>
		<div class="explorer-footer">

		</div>
	</div>
    <script src="{{ asset('/js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ route('call.extension.static', ['ext' => 'explorer', 'type' => 'js', 'all' => 'contextMenu.js-master/contextMenu.min.js']) }}" type="text/javascript"></script>

	<script type="text/javascript">
		
	</script>
</body>
</html>