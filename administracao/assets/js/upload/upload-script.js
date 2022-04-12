var $filequeue, $filelist;

$(document).ready(function() {
	$filequeue = $('.filelist.queue');
	$filelist = $('.filelist.complete');
	$('.upload').upload({
		maxSize: 1073741824,
		beforeSend: onBeforeSend
	})
	.on('start.upload', onStart)
	.on('complete.upload', onComplete)
	.on('filestart.upload', onFileStart)
	.on('fileprogress.upload', onFileProgress)
	.on('filecomplete.upload', onFileComplete)
	.on('fileerror.upload', onFileError)
	.on('queued.upload', onQueued);
	$filequeue.on('click', '.cancel', onCancel);
	$('.cancel_all').on('click', onCancelAll);
});

function onCancel(e) {
	var index = $(this).parents('li').data('index');
	$('.upload').upload('cancelado', parseInt(index, 10));
}

function onCancelAll(e) {
	$('.upload').upload('cancelado');
}

function onBeforeSend(formData, file) {
	formData.append('test_field', 'test_value');
	return formData;
}

function onQueued(e, files) {
	var html = '';
	for (var i=0; i<files.length; i++) {
		html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span> <a class="link2 cancel">Cancelar</a> <span class="progress">Em Lista de Espera</span></li>';
	}
	$filequeue.append(html);
}

function onStart(e, files) {
	$filequeue.find('li').find('.progress').text('A Carregar');
}

function onComplete(e) {
	if ($('#id-produto-temp').length>0) {
		$('#grid').load('php/carregar-imagens.php?id=' + $('#id-produto-temp').val()).fadeIn('slow');
	} else {
		$('#grid').load('php/carregar-imagens.php?ed=1&id=' + $('#id-produto').val()).fadeIn('slow');
	}
}

function onFileStart(e, file) {
	$filequeue.find('li[data-index=' + file.index + ']').find('.progress').text('0%');
}

function onFileProgress(e, file, percent) {
	$filequeue.find('li[data-index=' + file.index + ']').find('.progress').text(percent + '%');
}

function onFileComplete(e, file, response) {
	$('#nov-img').val(parseInt(parseInt($('#nov-img').val()) + 1));
	var myVar = setInterval(function() {
		setColor();
	}, 500);

	function setColor() {
		if ($('#nov-img').val()>0) {
			clearInterval(myVar);
			$('.ass_img').css('display', 'inline-block');
			$('.cor_ref').addClass('cor_ref2');
		}
	}

	if (response.trim()==='' || response.toLowerCase().indexOf('error')>-1) {
		$filequeue.find('li[data-index=' + file.index + ']').addClass('error').find('.progress').text(response.trim());
	} else {
		var $target = $filequeue.find('li[data-index=' + file.index + ']');
		$target.find('.file').text(file.name);
		$target.find('.progress').remove();
		$target.find('.cancel').remove();
		$target.appendTo($filelist);
	}
}

function onFileError(e, file, error) {
	$filequeue.find('li[data-index=' + file.index + ']').addClass('error').find('.progress').text('Erro: ' + error);
}