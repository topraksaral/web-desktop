/*
* @Author: ToprakSaral
* @Date:   2019-03-08 17:21:17
* @Last Modified by:   topraksaral
* @Last Modified time: 2019-03-14 17:27:26
*/

class Wndow {

	url = "";
	name = "";
	icon = "";
	settings = {};
	id = -1;
	obj = "";
	kernel = -1;
	width = 0;
	height = 0;
	top = 0;
	left = 0;
	fullScreen = false;
	constructor(kernel, url, name, icon, settings) {
		this.kernel = kernel;
		this.url = url;
		this.name = name;
		this.icon = icon;
		this.settings = settings;

		this.width = this.settings.width;
		this.height = this.settings.height;
		this.top = this.settings.x;
		this.left = this.settings.y;

		if(this.settings.fullScreen){
			this.top = 0;
			this.left = 0;

			this.width = kernel.getArea().width()-3;
			this.height = kernel.getArea().height()-3;
			this.fullScreen = true;
		}
	}

	setId(id){
		this.id = id;
		return this.id;
	}

	getHtml(){
		var minimIcon = '<i class="far fa-window-restore"></i>';
		if(!this.fullScreen)
			minimIcon = '<i class="far fa-window-maximize"></i>';
		var obj = '<div class="window" style="width: '+this.width+'px; height: '+this.height+'px; top: '+this.top+'px; left: '+this.left+'px;"><div class="resizes-top"></div><div class="resizes-bottom"></div><div class="resizes-left"></div><div class="resizes-right"></div><div class="resizes-right-bottom"></div><div class="header"><div class="icon"><img src="'+this.icon+'"></div><div class="title">'+this.name+'</div><div class="buttons"><div class="close"><i class="fas fa-times"></i></div><div class="maximize">'+minimIcon+'</div><div class="minimize"><i class="fas fa-window-minimize"></i></div></div></div><div class="body"><div class="body-hidden"></div><iframe src="'+this.url+'" class="content"></iframe></div></div>';
		this.obj = $(obj);

		if(!this.settings.resizable){
			this.obj.find('.resizes-top').css('cursor', 'auto');
			this.obj.find('.resizes-bottom').css('cursor', 'auto');
			this.obj.find('.resizes-left').css('cursor', 'auto');
			this.obj.find('.resizes-right').css('cursor', 'auto');
			this.obj.find('.resizes-right-bottom').css('cursor', 'auto');
			this.obj.find('.maximize').remove();
		}
		if(!this.settings.minimizable){
			this.obj.find('.minimize').remove();
		}

		var that = this;
		this.obj.find('.title').dblclick(function() {
			that.maximizeWindow();			
		});
		this.obj.find('.minimize').on('click', function(event){
			console.log($(this));
		});
		this.obj.find('.maximize').on('click', function(event){
			that.maximizeWindow();
		});
		this.obj.find('.close').on('click', function(event){
			that.remove();
		});
		this.obj.on('mousedown', function(event){
			var target = $(event.target);

			that.setFocus();
			that.clearIndexOthers();
			that.whiteOthers();

			if(target.is('.title') || target.is('.resizes-top') || target.is('.resizes-bottom') || target.is('.resizes-left') || target.is('.resizes-right') || target.is('.resizes-right-bottom')){
				that.setWhite();

				if(target.is('.title'))
					that.moveWindow(event.pageX, event.pageY);
				if(target.is('.resizes-top'))
					that.resizeWindow('top', event.pageX, event.pageY);
				if(target.is('.resizes-bottom'))
					that.resizeWindow('bottom', event.pageX, event.pageY);
				if(target.is('.resizes-left'))
					that.resizeWindow('left', event.pageX, event.pageY);
				if(target.is('.resizes-right'))
					that.resizeWindow('right', event.pageX, event.pageY);
				if(target.is('.resizes-right-bottom'))
					that.resizeWindow('right-bottom', event.pageX, event.pageY);
			}else{
				that.unsetWhite();
			}

				

		});
		return this.obj;
	}

	resizeWindow(area, x, y){
		var that = this;
		$(document).on('mousemove', function(event){
			if(area == 'top'){
				if(event.pageY < 0){
					event.pageY = 0;
				}
				var lastY = that.obj.offset().top-event.pageY;
				lastY = lastY+that.obj.height();
				if(lastY < 50){
					lastY = 50;
					event.pageY = that.obj.offset().top;
				}
				that.obj.css('top', event.pageY);
				that.obj.css('height', lastY);
				that.updateHeight(lastY);
				that.updateXY(that.obj.offset().left, event.pageY);
			}else if(area == 'bottom'){
				var lastY = event.pageY-that.obj.offset().top;
				if(lastY < 50)
					lastY = 50;
				that.obj.css('height', lastY);
				that.updateHeight(lastY);
			}else if(area == 'left'){
				if(event.pageX < 0){
					event.pageX = 0;
				}
				var lastX = that.obj.offset().left-event.pageX;
				lastX = lastX+that.obj.width();
				if(lastY < 50){
					lastY = 50;
					event.pageX = that.obj.offset().left;
				}
				that.obj.css('left', event.pageX);
				that.obj.css('width', lastX);
				that.updateWidth(lastX);
				that.updateXY(event.pageX, that.obj.offset().top);
			}else if(area == 'right'){
				var lastX = event.pageX-that.obj.offset().left;
				if(lastX < 150)
					lastX = 150;
				that.obj.css('width', lastX);
				that.updateWidth(lastX);
			}else if(area == 'right-bottom'){
				var lastY = event.pageY-that.obj.offset().top;
				var lastX = event.pageX-that.obj.offset().left;
				if(lastY < 50)
					lastY = 50;
				if(lastX < 150)
					lastX = 150;
				that.obj.css('height', lastY);
				that.obj.css('width', lastX);
				that.updateHeight(lastY);
				that.updateWidth(lastX);
			}
		});
	}

	updateHeight(height){
		this.height = height;
		this.settings.height = height;
	}

	updateWidth(width){
		this.width = width;
		this.settings.width = width;
	}

	maximizeWindow(){
		if(this.fullScreen){
			this.width = this.settings.width;
			this.height = this.settings.height;
			this.left = this.settings.x;
			this.top = this.settings.y;

			this.obj.find('.resizes-top').css('cursor', 'ns-resize');
			this.obj.find('.resizes-bottom').css('cursor', 'ns-resize');
			this.obj.find('.resizes-left').css('cursor', 'ew-resize');
			this.obj.find('.resizes-right').css('cursor', 'ew-resize');
			this.obj.find('.resizes-right-bottom').css('cursor', 'nwse-resize');

			this.obj.animate({
				width: this.width,
				height: this.height,
				top: this.top,
				left: this.left
			}, 300, function(){

			});

			this.obj.find('.maximize').html('<i class="far fa-window-maximize"></i>');
			this.fullScreen = false;

			return;
		}

		this.top = 0;
		this.left = 0;

		this.width = kernel.getArea().width()-3;
		this.height = kernel.getArea().height()-3;

		this.obj.find('.resizes-top').css('cursor', 'auto');
		this.obj.find('.resizes-bottom').css('cursor', 'auto');
		this.obj.find('.resizes-left').css('cursor', 'auto');
		this.obj.find('.resizes-right').css('cursor', 'auto');
		this.obj.find('.resizes-right-bottom').css('cursor', 'auto');

		this.obj.animate({
			width: this.width,
			height: this.height,
			top: this.top,
			left: this.left
		}, 300, function(){

		});

		this.obj.find('.maximize').html('<i class="far fa-window-restore"></i>');
		this.fullScreen = true;

	}

	moveWindow(x, y){
		if(this.fullScreen){
			return;
		}
		x = x-this.obj.offset().left;
		y = y-this.obj.offset().top;
		var that = this;
		$(document).on('mousemove', function(event){

			var lastX = event.pageX-x;
			var lastY = event.pageY-y;
			if(lastX < 0){
				lastX = 0;
			}
			if(lastY < 0){
				lastY = 0;
			}
			that.obj.css('left', lastX);
			that.obj.css('top', lastY);

			that.updateXY(lastX, lastY);
		});
	}

	updateXY(x, y){
		this.settings.x = x;
		this.settings.y = y;
	}
	checkYourself(){
		if(this.obj.css('z-index') == 1){
			this.unsetWhite();
		}else{
			this.setWhite();
		}

		if(this.fullScreen){
			this.width = kernel.getArea().width()-3;
			this.height = kernel.getArea().height()-3;

			this.obj.css({
				width: this.width,
				height: this.height,
			}, 300, function(){

			});

		}else{

		}
	}

	setFocus(){
		this.obj.css('z-index', 1);
	}

	setWhite(){
		this.obj.find('.body-hidden').css('display', 'block');

	}
	unsetWhite(){
		this.obj.find('.body-hidden').css('display', 'none');

	}
	setTitle(title){
		this.name = title;
		this.obj.find('.title').html(title);
	}

	remove(){
		this.obj.remove();
		if(typeof this.settings.opener !== 'undefined'){
			this.kernel.setFocus(this.settings.opener);
		}
		this.kernel.removeWindow(this.id);
	}

	clearIndex(){
		this.obj.css('z-index', 0);
	}

	clearIndexOthers(){
		this.kernel.clearIndexOthers(this.id);
	}

	whiteOthers(){
		this.kernel.whiteOthers(this.id);		
	}
}