;(function($, Formstone, undefined) {
	'use strict';

	function construct(data) {
		if (Formstone.support.file) {
			var html = '';
			if (data.label!==false) {
				html += '<div class="' + RawClasses.target + '">' + data.label + '</div>';
			}
			html += '<span class="btn btn-primary btn-file mt-15"><span class="fileinput-new">Selecionar</span><input type="file" name="file" accept=".jpg, .jpeg" class="' + RawClasses.input + '"';
			if (data.multiple) {
				html += ' multiple';
			}
			html += '></span>';
			this.addClass(RawClasses.base).append(html);
			data.$input = this.find(Classes.input);
			data.queue = [];
			data.total = 0;
			data.uploading = false;
			data.disabled = true;
			data.aborting = false;
			this.on(Events.click, Classes.target, data, onClick)
				.on(Events.dragEnter, data, onDragEnter)
				.on(Events.dragOver, data, onDragOver)
				.on(Events.dragLeave, data, onDragOut)
				.on(Events.drop, data, onDrop);
			data.$input.on(Events.change, data, onChange);
			enableUpload.call(this, data);
		}
	}

	function destruct(data) {
		if (Formstone.support.file) {
			data.$input.off(Events.namespace);
			this.off([Events.click, Events.dragEnter, Events.dragOver, Events.dragLeave, Events.drop]
				.join(' ')).removeClass(RawClasses.base).html('');
		}
	}

	function abortUpload(data, index) {
		var file;
		data.aborting = true;
		for (var i in data.queue) {
			if (data.queue.hasOwnProperty(i)) {
				file = data.queue[i];
				if ($.type(index)==='undefined' || (index>=0 && file.index===index)) {
					if (file.started && !file.complete) {
						file.transfer.abort('Cancelado');
					} else {
						abortFile(data, file, 'Cancelado');
					}
				}
			}
		}
		data.aborting = false;
		checkQueue(data);
	}

	function abortFile(data, file, error) {
		file.error = true;
		data.$el.trigger(Events.fileError, [file, error]);
		if (!data.aborting) {
			checkQueue(data);
		}
	}

	function disableUpload(data) {
		if (!data.disabled) {
			this.addClass(RawClasses.disabled);
			data.$input.prop('disabled', true);
			data.disabled = true;
		}
	}

	function enableUpload(data) {
		if (data.disabled) {
			this.removeClass(RawClasses.disabled);
			data.$input.prop('disabled', false);
			data.disabled = false;
		}
	}

	function onClick(e) {
		Functions.killEvent(e);
		var data = e.data;
		if (!data.disabled) {
			data.$input.trigger(Events.click);
		}
	}

	function onChange(e) {
		Functions.killEvent(e);
		var data = e.data,
			files = data.$input[0].files;
		if (!data.disabled && files.length) {
			handleUpload(data, files);
		}
	}

	function onDragEnter(e) {
		Functions.killEvent(e);
		var data = e.data;
		data.$el.addClass(RawClasses.dropping).trigger(Events.fileDragEnter);
	}

	function onDragOver(e) {
		Functions.killEvent(e);
		var data = e.data;
		data.$el.addClass(RawClasses.dropping).trigger(Events.fileDragOver);
	}

	function onDragOut(e) {
		Functions.killEvent(e);
		var data = e.data;
		data.$el.removeClass(RawClasses.dropping).trigger(Events.fileDragLeave);
	}

	function onDrop(e) {
		Functions.killEvent(e);
		var data = e.data, files = e.originalEvent.dataTransfer.files;
		data.$el.removeClass(RawClasses.dropping);
		if (!data.disabled) {
			handleUpload(data, files);
		}
	}

	function handleUpload(data, files) {
		var newFiles = [];
		for (var i=0; i<files.length; i++) {
			var file = {
				index: data.total++,
				file: files[i],
				name: files[i].name,
				size: files[i].size,
				started: false,
				complete: false,
				error: false,
				transfer: null
			};
			newFiles.push(file);
			data.queue.push(file);
		}
		data.$el.trigger(Events.queued, [newFiles]);
		if (data.autoUpload) {
			startUpload(data);
		}
	}

	function startUpload(data) {
		if (!data.uploading) {
			$Window.on(Events.beforeUnload, function() {
				return data.leave;
			});
			data.uploading = true;
			data.$el.trigger(Events.start, [data.queue]);
		}
		checkQueue(data);
	}

	function checkQueue(data) {
		var transfering = 0,
			newQueue = [];
		for (var i in data.queue) {
			if (data.queue.hasOwnProperty(i) && !data.queue[i].complete && !data.queue[i].error) {
				newQueue.push(data.queue[i]);
			}
		}
		data.queue = newQueue;
		for (var j in data.queue) {
			if (data.queue.hasOwnProperty(j)) {
				if (!data.queue[j].started) {
					var formData = new FormData();
					formData.append(data.postKey, data.queue[j].file);
					for (var k in data.postData) {
						if (data.postData.hasOwnProperty(k)) {
							formData.append(k, data.postData[k]);
						}
					}
					uploadFile(data, formData, data.queue[j]);
				}
				transfering++;
				if (transfering>=data.maxQueue) {
					return;
				} else {
					i++;
				}
			}
		}
		if (transfering===0) {
			$Window.off(Events.beforeUnload);
			data.uploading = false;
			data.$el.trigger(Events.complete);
		}
	}

	function uploadFile(data, formData, file) {
		formData = data.beforeSend.call(Window, formData, file);
		var re = /(?:\.([^.]+))?$/;
		var file_format = (re.exec(file.name)[1]);
		if (file.size>=data.maxSize || formData===false || file.error===true) {
			abortFile(data, file, (!formData ? 'Cancelada' : 'Tamanho superior ao permitido'));
		} else if (file_format!='jpg' && file_format!='JPG') {
			abortFile(data, file, ('Por favor insira um ficheiro em jpg.'));
		} else {
			file.started = true;
			file.transfer = $.ajax({
				url: data.action,
				data: formData,
				dataType: data.dataType,
				type: 'POST',
				contentType:false,
				processData: false,
				cache: false,
				xhr: function() {
					var $xhr = $.ajaxSettings.xhr();
					if ($xhr.upload) {
						$xhr.upload.addEventListener('progress', function(e) {
							var percent = 0, position = e.loaded || e.position, total = e.total;
							if (e.lengthComputable) {
								percent = Math.ceil((position / total) * 100);
							}
							data.$el.trigger(Events.fileProgress, [file, percent]);
						}, false);
					}
					return $xhr;
				},
				beforeSend: function(jqXHR, settings) {
					data.$el.trigger(Events.fileStart, [file]);
				},
				success: function(response, status, jqXHR) {
					file.complete = true;
					data.$el.trigger(Events.fileComplete, [file, response]);
					checkQueue(data);
				},
				error: function(jqXHR, status, error) {
					abortFile(data, file, error);
				}
			});
		}
	}

	var Plugin = Formstone.Plugin('upload', {
		widget: true,
		defaults: {
			action: '',
			autoUpload: true,
			beforeSend: function(formdata) {
				return formdata;
			},
			customClass: '',
			dataType: 'html',
			label: 'Arraste as suas imagens em <b>jpg</b> para aqui ou clique para selecionar.<br>(Dimens&atilde;o: 1100px por 1100px; Tamanho M&aacute;ximo: 5MB)',
			leave: 'Tem uploads pendentes, tem a certeza que pretende sair desta página?',
			maxQueue: 2,
			maxSize: 5242880,
			multiple: true,
			postData: {},
			postKey: 'file'
		},
		classes: [
			'input',
			'target',
			'multiple',
			'dropping',
			'disabled'
		],
		methods: {
			_construct: construct,
			_destruct: destruct,
			disable: disableUpload,
			enable: enableUpload,
			cancelado: abortUpload,
			start: startUpload
		}
	}),
	Classes = Plugin.classes,
	RawClasses = Classes.raw,
	Events = Plugin.events,
	Functions = Plugin.functions,
	Window = Formstone.window,
	$Window = Formstone.$window;
	Events.complete = 'complete';
	Events.fileComplete = 'filecomplete';
	Events.fileDragEnter = 'filedragenter';
	Events.fileDragLeave = 'filedragleave';
	Events.fileDragOver = 'filedragover';
	Events.fileError = 'fileerror';
	Events.fileProgress = 'fileprogress';
	Events.fileStart = 'filestart';
	Events.start = 'start';
	Events.queued = 'queued';
})(jQuery, Formstone);