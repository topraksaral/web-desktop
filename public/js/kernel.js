class Kernel {

	extensionCheckCaller = "";
	extensionCaller = "";
	extensionFinder = "";
	fileDownloader = "";
	wndows = [];
	windowsNextId = 0;
	area = null;
	moveElement = -1;
	moveX = -1;
	moveY = -1;
	constructor(extensionCheckCaller, extensionCaller, extensionFinder, fileDownloader, area) {

		this.extensionCheckCaller = extensionCheckCaller;
		this.extensionCaller = extensionCaller;
		this.extensionFinder = extensionFinder;
		this.fileDownloader = fileDownloader;
		this.area = area;

		var that = this;

		$(document).mouseup(function() {
			that.checkItself();
			$(document).off("mousemove");
		});
		$(window).resize(function(){
			that.checkItself();
		});
		
	}

	checkItself(){
		for (var i = 0; i < this.wndows.length; i++) {
			this.wndows[i].checkYourself();
		}
	}
	removeWindow(id){
		for (var i = 0; i < this.wndows.length; i++) {
			if(this.wndows[i].id == id){
				this.wndows.splice(i, 1);
				break;
			}
		};
		return true;
	}

	getWindow(id){
		for (var i = 0; i < this.wndows.length; i++) {
			if(this.wndows[i].id == id){
				return this.wndows[i];
			}
		};
		return false;
	}

	clearIndexOthers(id){
		for (var i = 0; i < this.wndows.length; i++) {
			if(this.wndows[i].id != id){
				this.wndows[i].clearIndex();
			}
		};
		return true;
	}

	whiteOthers(id){
		for (var i = 0; i < this.wndows.length; i++) {
			if(this.wndows[i].id != id){
				this.wndows[i].setWhite();
			}
		};
		return true;
	}
	openWindow(data){
		var that = this;
		$.post(this.extensionCheckCaller+"/"+data.open, data.params, function(response){
			data.params.winId = that.windowsNextId;
			if(!response.status){
				return that.showAlert(response.message);
			}
			that.pushHtml(data, response);
		}).fail(function(response) {
		    console.log(response.status);
		});
	}

	pushHtml(data, response){
		console.log(data);
		var wndow = new Wndow(this, (this.extensionCaller+"/"+data.open+"?"+$.param(data.params)), data.name, data.icon, data.settings);

		this.addWindow(wndow);

		var html = wndow.getHtml();

		this.area.append(html);
	}

	addWindow(wndow){
		wndow.setId(this.windowsNextId);
		this.clearIndexOthers(this.windowsNextId);
		this.whiteOthers(this.windowsNextId);
		this.wndows.push(wndow);
		this.windowsNextId++;
	}

	setFocus(id){
		var wind = this.getWindow(id);
		if(wind != false){
			wind.setFocus();
			wind.unsetWhite();
		}
	}

	openWithApp(winId, path){
		var that = this;
		var data = {
			file: path
		}
		$.post(this.extensionFinder+"?file="+path, data, function(response){
			if(response.status){
				var data = {
	                name: response.params.title,
	                icon: response.params.icon,
	                open: response.params.ext,
	                params: response.params.params,
	                settings: {
	                    width: response.params.width,
	                    height: response.params.height,
	                    resizable: response.params.resizable,
	                    minimizable: response.params.minimizable,
	                    fullScreen:false,
		                opener: winId,
	                    x: 30,
	                    y: 30
	                }
	            };

	            that.openWindow(data);

			}else{
				var win = window.open(that.fileDownloader+"?file="+path, '_blank');
				win.focus();
			}

		}).fail(function(response) {
		    console.log(response.status);
		});
	}
	
	showAlert(message){
		alert(message);
	}

	changeWindowTitle(winId, title){
		var curWin = this.getWindow(winId);
		if(curWin !== false){
			curWin.setTitle(title);
		}
	}

	getArea(){
		return this.area;
	}
}