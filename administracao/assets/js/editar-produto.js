$(document).ready(function() {
	$('.gridly').gridly('draggable', 'off');
});

$('.gridly').gridly({
  	base: 17,
  	gutter: 17,
  	columns: 5,
  	'responsive': true
});

function toggleModal(id) {
    $('#' + id).modal('show');
}

function hideModal() {
    $('.modal').modal('hide');
}

function baixoPreco() {
	if ($('#preco').val()=='0,00' || $('#preco').val()=='0.00') {
		$('#preco').val('');
	}
}

function saiPreco() {
	var preco = $('#preco').val();
	if (preco.length>0) {
		var preco_decimal = parseFloat(preco).toFixed(2);
		$('#preco').val(preco_decimal);
	} else {
		$('#preco').val('0,00');
	}
}

function apagarImagem(imagem) {
	$('#id-eliminar-imagem').val(imagem);
	$('#modal-eliminar-imagem').modal('show');
}

function eliminarImagem() {
	$('#modal-eliminar-imagem').modal('hide');
	var imagem = $('#id-eliminar-imagem').val();
	var produto = $('#id-produto').val();
	$this = $('#img-e-' + imagem);
	$this.closest('.brick').remove();
	$.ajax({
        type: 'POST',
        url: 'php/eliminar/eliminar-imagem-produto.php',
        data: {'produto': produto, 'imagem': imagem, 'editar': '1'},
        success: function(response) {}
	});
}

function adicionarProduto() {
	var produto = $('#produto').val();
	$.ajax({
        type: 'POST',
        url: 'php/int/produtos-por-associar.php',
        data: {'produto': produto, 'editar': '1'},
        success: function(response) {
        	$('#btn-associar-produto').css('display', 'none');
        	$('#selecionar-produto').html(response);
			$('#dados-produtos #conteudo').html('Selecione um produto para associar.');
			$('#modal-associar-produto').modal('show');
        }
	});
}

function mudarProduto() {
	var produto = $('#selecionar-produto').val();
	if (produto=='0') {
		$('#btn-associar-produto').css('display', 'none');
		$('#dados-produtos #conteudo').html('Selecione um produto para associar.');
	} else {
		$.ajax({
			type: 'POST',
			url: 'php/int/carregar-produto.php',
			data: {'produto': produto},
			success: function(response) {
				if (response!='') {
					$('#dados-produtos #conteudo').html(response);
					$('#btn-associar-produto').attr('onclick', 'associarProduto(' + $('#selecionar-produto').val() + ')');
					$('#btn-associar-produto').css('display', 'inline-block');
				} else {
					$('#btn-associar-produto').css('display', 'none');
					$('#dados-produtos #conteudo').html('Não foi possível carregar o produto selecionado. Por favor tente novamente.');
				}
			}
		});
	}
}

function associarProduto(produto_associado) {
	var produto = $('#produto').val();
	var produto_associado = produto_associado;
	$.ajax({
		type: 'POST',
		url: 'php/associar-produto.php',
		data: {'produto': produto, 'produto_associado': produto_associado, 'editar': '1'},
		success: function(response) {
			$('#modal-associar-produto').modal('hide');
			$('#grid2').load('php/int/int-associados.php?produto=' + produto + '&editar=1').fadeIn('slow');
		}
	});
}

function eliminarProdutoAssociado(produto_associado) {
	var produto = $('#produto').val();
	var produto_associado = produto_associado;
	$.ajax({
		type: 'POST',
		url: 'php/desassociar-produto.php',
		data: {'produto': produto, 'produto_associado': produto_associado, 'editar': '1'},
		success: function(response) {
			$('#grid2').load('php/int/int-associados.php?produto=' + produto + 'editar=1').fadeIn('slow');
		}
	});
}