window.onload = function(e) {
	/* AWESOMPLETE INICIALIZAÇÃO */
	autores['a1'] = new Awesomplete(document.querySelector("#a1"));
	$("#a1").on('awesomplete-select', function(e) {
		e.preventDefault();
		value = e.originalEvent.text.value;
		label = e.originalEvent.text.label;
		$(this).val(label);
		$(this).attr('data-val', value);
		$('#'+$(this).attr('id')+'id').val(value);
		autores[$(this).attr('id')].close();
	});

	pub = new Awesomplete(document.querySelector("#search"));
	$("#search").on('awesomplete-select', function(e) {
		clear_search();
		e.preventDefault();
		label = e.originalEvent.text.label;
		value = JSON.parse(e.originalEvent.text.value);
		$('input[name=publicacao_id]').val(value.id);
		$(this).val(label);
		$('#titulo').val(label);
		$('#subtitulo').val(value.subtitulo);
		pub.close();
	});
};

$( document ).ready(function() {
	$('.paginas').mask('9?999999999999999999'); // masked-input

	// funcionalidade apenas para gerar novos campos de autor
	$('#more-autores').click(function() {
		var int_id = parseInt($(this).prev().find('input[name^=autores]').attr('id').replace('a', '')) + 1;
		var id = 'a' + int_id.toString();

		var $input = $('<input />');
		$input.attr('type', 'text');
		$input.attr('name', 'autores['+int_id+']');
		$input.attr('id', id);

		var $hidden = $('<input />');;
		$hidden.attr('type', 'hidden');
		$hidden.attr('name', 'autoresid['+int_id+']');
		$hidden.attr('id', id+'id');

		var $div = $('<div></div>');
		$div.append($input);
		$div.append($hidden);

		$div.insertBefore($(this));

		autores[id] = new Awesomplete(document.querySelector("#"+id));
		$("#"+id).on('awesomplete-select', function(e) {
			e.preventDefault();
			value = e.originalEvent.text.value;
			label = e.originalEvent.text.label;
			$(this).val(label);
			$(this).attr('data-val', value);
			$('#'+$(this).attr('id')+'id').val(value);
			autores[$(this).attr('id')].close();
		});
	})

	/* AWESOMPLETE busca via ajax em controllers search route */
	$("#create-livro").on('keypress', 'input[name^=autores]', function() {
		$this = $(this);
		$.ajax({
			headers: {
		        'X-CSRF-Token': $('input[name="_token"]').val()
		    },
			method: "POST",
			url: $('form').attr('data-action'),
			data: {value: $(this).val()},
			dataType: 'json',
		}).done(function( msg ) {
			var lista = new Array();
			$.each(msg, function(key, val) {
				lista.push([val.nome, val.codigo]);
			});
			autores[$this.attr('id')].list = lista;
		});
	});

	$('#titulo').keypress(function() {
		clear_search();
	});

	$("#search").keypress(function() {
		$('#titulo').val('');
		$('#subtitulo').val('');
		$('input[name=publicacao_id]').val('');
		$.ajax({
			headers: {
		        'X-CSRF-Token': $('input[name="_token"]').val()
		    },
			method: "POST",
			url: $(this).attr('data-action'),
			data: {value: $(this).val()},
			dataType: 'json',
		}).done(function( msg ) {
			var lista = new Array();
			$.each(msg, function(key, val) {
				lista.push([val.titulo, val.extras]);
			});
			pub.list = lista;
		});
	});
});

function clear_search() {
	$('#subtitulo').val('');
	$('#search').val('');
	$('input[name=publicacao_id]').val('');
}