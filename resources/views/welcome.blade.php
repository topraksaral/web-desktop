<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/plugins/vegas/vegas.min.css') }}">
    </head>
    <style type="text/css">
        html, body, #warp {
            position: relative;
            width: 100%;
            height: calc(100% - 13px);
            margin: 0;
            padding: 0;
            overflow: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .window {
            position: absolute;
            padding: 2px;
            background-color: #FFFFFF;
        }
        .window .header {
            width: 100%;
            height: 30px;
            position: relative;
            background-color: #f7d16a;
            border-bottom: 1px solid #FF0000;
        }

        .window .header .icon {
            width: 24px;
            height: 24px;
            margin: 3px 4px;
            float: left;
        }

        .window .header .icon img {
            width: 24px;
            height: 24px;
        }

        .window .header .title {
            font: 14px normal Arial, Helvetica, sans-serif;
            width: calc(100% - 108px);
            height: 20px;
            float: left;
            padding-top: 7px;
            padding-bottom: 3px;
            font-size: 16px;
            cursor: move;
        }

        .window .header .buttons {
            width: 75px;
            height: 18px;
            float: left;
            text-align: center;
            margin-top: 1px;
            margin-right: 1px;
        }
        .window .header .buttons div {
            width: 24px;
            height: 18px;
            float: right;
            cursor: pointer;
            margin-left: 1px;
            color: #FFFFFF;
            font-size: 16px;
        }
        .window .header .buttons .minimize {
            background-color: #92bfef;
        }

        .window .header .buttons .maximize {
            background-color: #92bfef;
        }

        .window .header .buttons .close {
            background-color: #f76a6a;
        }

        .window .body {
            width: 100%;
            height: calc(100% - 31px);
        }
        .window .body iframe.content {
            width: 100%;
            height: 100%;
            border: none;
        }
        .body-hidden {
            display: none;
            background-color: #FFFFFF;
            opacity: 0.5;
            position: absolute;
            top: 33px;
            left: 3px;
            z-index: 5;
            width: calc(100% - 6px);
            height: calc(100% - 36px);
        }
        .resizes-top {
            width: calc(100% - 4px);
            height: 2px;
            position: absolute;
            top: 0;
            left: 4;
            border-bottom: 1px solid #FF0000;
            z-index: 800;
            cursor: ns-resize;
        }
        .resizes-bottom {
            width: calc(100% - 4px);
            height: 2px;
            position: absolute;
            bottom: 0;
            left: 2;
            border-top: 1px solid #FF0000;
            z-index: 800;
            cursor: ns-resize;
        }
        .resizes-left {
            height: calc(100% - 4px);
            width: 2px;
            position: absolute;
            top: 2;
            left: 0;
            border-right: 1px solid #FF0000;
            z-index: 800;
            cursor: ew-resize;
        }
        .resizes-right {
            height: calc(100% - 4px);
            width: 2px;
            position: absolute;
            top: 2;
            right: 0;
            border-left: 1px solid #FF0000;
            z-index: 800;
            cursor: ew-resize;
        }
        .resizes-right-bottom {
            width: 4px;
            height: 4px;
            position: absolute;
            right: 0px;
            bottom: 0px;
            z-index: 900;
            cursor: nwse-resize;
        }
        .task-bar {
            width: 100%;
            height: 40px;
            position: fixed;
            bottom: 0;
            background-color: #f4bc42;
            z-index: 1200;
        }
    </style>
    <body>

        <div id="warp">


        </div>
        <div class="task-bar">

        </div>
        <script src="{{ asset('/js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/plugins/vegas/vegas.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/js/wndow.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/js/kernel.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                $.get('{{ route('system.background') }}', function(response){
                    console.log(response);

                    var slides = [];
                    for(var i = 0; i < response.length; i++){
                        slides.push({
                            src: response[i]
                        });
                    }

                    $('body').vegas({
                        delay: 99000,
                        transition: 'fade2',
                        overlay: '{{ asset('/plugins/vegas/overlays/02.png') }}',
                        slides: slides
                    });

                });
            });


            var extensionCheckCaller = "{{ route('call.extension.check.n') }}";
            var extensionCaller = "{{ route('call.extension.n') }}";
            var extensionFinder = "{{ route('call.extension.find') }}";
            var fileDownloader = "{{ route('file.download') }}";
            var kernel = new Kernel(extensionCheckCaller, extensionCaller, extensionFinder, fileDownloader, $('#warp'));


            var openWithApp = function(winId, file){
                kernel.openWithApp(winId, file);

            }
            var changeWindowTitle = function(winId, title){
                kernel.changeWindowTitle(winId, title);
            }

            openWithApp(-1, '/');
        </script>
    </body>
</html>
