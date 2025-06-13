$('.btn-print').click(function () {
	// Codigo para realizar impresion
	$('.impresion-ticket').print({
		title: 'Información detallada del Ticket',
	});
});

$(document).on('hidden.bs.modal', '.modal', function () {
	$('.modal:visible').length && $(document.body).addClass('modal-open');
});
