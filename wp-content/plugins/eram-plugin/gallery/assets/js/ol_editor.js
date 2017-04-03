(function($, window, document, wp) {

	'use strict';
	var inputsHandler={
		init:function(){
			this.bindUIActions();
		},
		bindUIActions:function(){
			var self=this;

			$.og.$body.on('change','input[name*=eg_],select[name*=eg_],textarea[name*=eg_]',function(){
				var $this=$(this);
				var $name=$this.attr('name');
				if ($name){
					iframeReload.init($this.serialize());
				}
			})

			var $gallerInput=$('#eg_photos');
			MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

			var observer = new MutationObserver(function(mutations, observer) {
				iframeReload.init($gallerInput.attr('name')+'='+$gallerInput.val());
				uploaderHandler.update();
			});

			observer.observe($gallerInput[0], {
			  subtree: false,
			  attributes: true
			});
		}
	};

	var iframeReload = {
		init:function(param) {
			this.param=param;
			this.reload();
		},
		reload:function(){
			var self = this;
			var $iframe=$('#ol-editor-iframe'),
				url=$iframe.attr('src'),
				newUrl = '';


			var paramParts = self.param.split('=');

			if ( url.indexOf(paramParts[0])  !== -1 )
			{
				// try to update url
				var current_value = getParameterByName(paramParts[0],url);
				newUrl = url.split(paramParts[0]+"="+current_value).join(paramParts[0]+"="+paramParts[1]);
				// console.log(current_value,paramParts[1]);
			}
			else
			{
				// append
				newUrl = url+"&"+self.param;
			}

			$iframe.attr('src',newUrl);

		}
	};

	var uploaderHandler = {
		init:function(){

			this.$uploadTrigger=$("#eg-uploader-trigger");

			this.bindUIActions();
			this.updateClass();

		},
		bindUIActions:function(){
			var self=this;
			self.$uploadTrigger.on('click',function(e){
				e.preventDefault();
				$(".ot-gallery-edit").trigger('click');
			});
		},
		updateClass:function(){

			var $gallerInput=$('#eg_photos');
			var $elemWrapper=$('#ol-editor-wrapper');

			if ( $gallerInput.val() == '' ){
				$elemWrapper.addClass('eg-has-no-image');
			}else{
				$elemWrapper.removeClass('eg-has-no-image');
			}
		},
		update:function(){
			this.updateClass();
		}
	};

	var saveHandler = {
		init:function () {
			var self = this;

			self.$form = $('form#eg-customize-form');
			self.$saveButton=$("#eg-customize-save");
			self.$notificationElem=$(".eg-notification");

			self.bindUIActions();
		},
		bindUIActions:function () {
			var self = this;

			$(document).on('submit',self.$form,function(){

				// gather all inputs from metabox
				//var metaData=$(".ot-metabox-wrapper input, .ot-metabox-wrapper select, .ot-metabox-wrapper textarea").serialize().replace(/%2C/g,",");
				var metaData=self.serialize($(".ot-metabox-wrapper"));

				// send to be saved
				self.$saveButton.addClass('disabled');

				$.ajax({
					url: wp.ajax.settings.url,
					type:'POST',
					data: {
						'action' : "eram_gallery_save_customizer",
						'post_id' : self.$form.data('post_id'),
						'meta_data' : metaData,
						'save_nounce' : Eg_Ajax.saveNonce
					},
					success: function(html){
						self.$saveButton.removeClass('disabled');
						self.$notificationElem.removeClass('error').addClass('success');
						self.showNotification();
					},
					error: function (request, status, error) {
					  self.$notificationElem.removeClass('success').addClass('error').find('.error-message').html(request.responseText);
					  self.showNotification();
					}
				});
				return false;
			});
		},
		showNotification:function(){
			var self=this;

			self.$notificationElem.slideDown();
			setTimeout(function(){
				self.$notificationElem.slideUp();
			},3000);
		},
        serialize: function($el) {
            var serialized = $el.serialize();
            if (!serialized) // not a form
                serialized = $el.find('input[name],select[name],textarea[name]').serialize();
            return serialized;
        }
	};

	var sidebarHandler={
		init:function(){
			this.$elem=$('#ol-editor-wrapper');
			this.$togglePreview=$('.eg-preview-toggle');
			this.$toggleSidebar=$('.eg-collapse');
			this.$previewFrame=$('#eg-preview-device');

			this.bindUIActions();
		},
		bindUIActions:function(){
			var self=this;
			self.$togglePreview.on('click',function(e){
				e.preventDefault();
				self.$elem.toggleClass('collapsed');
			});

			self.$toggleSidebar.on('click',function(e){
				e.preventDefault();
				self.$elem.toggleClass('hide-sidebar');
			});

			$('.responsive-control').on('click','a',function(e){
				e.preventDefault();
				var device=$(this).attr('class');
				self.$previewFrame.removeAttr('class').addClass('eg-device-'+device);
			});
		}
	};

	//*********** Init Handler for all Functions *******//
	var initRequired={
		init:function(){
			$.og={
				$body:$('body'),
				$header:$('#header'),
				$window:$(window)
			};

			this.runMethods();
			this.runInlines();
		},
		runMethods:function(){
			inputsHandler.init();
			saveHandler.init();
			sidebarHandler.init();
			uploaderHandler.init();
		},
		runInlines:function(){
			$('#adminmenumain,#wpadminbar,#wpfooter,#screen-options-link-wrap').remove();
		}
	};
	//*********** Init Handler for all Functions *******//

	//Run methods on DOM Ready
	$(document).ready(function(){
		initRequired.init();
	});

	//Run methods on Window load
	$(window).on('load',function(){

	});

	/* Create Object Instance
	----------------------------------------------*/
	function createObjInstance(selector,objName,options){
		$(selector).each(function(){
			var obj = Object.create( objName );
			obj.init($(this),options);

		});
	}

})(jQuery,window, document, wp);


function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
