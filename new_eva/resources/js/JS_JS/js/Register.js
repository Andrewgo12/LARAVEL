$('#modal_reg_usuario #form_register').submit(function (e) {
	e.preventDefault();
	const formulario = new FormData(this);
	$('#modal_reg_usuario .close').click();
	$.blockUI({
		message:
			'<h1><div class="glyphicon glyphicon-refresh"></dv>Procesando</h1><br><p>Espere un momento mientras la información es procesada</p>',
		css: {
			width: '275px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
		},
	});

	$.ajax({
		url: base_url + 'Cauth/reg',
		type: 'post',
		data: formulario,
		dataType: 'html',
		cache: false,
		contentType: false,
		processData: false,
	}).done(function (datos) {
		try {
			console.log(datos);
			$.unblockUI();
			respuesta = JSON.parse(datos);
			if (respuesta.respuesta == 1) {
				var id_usuario = respuesta.valor;
				document.getElementById('form_register').reset();
				notify_register('add');
				$.ajax({
					url: base_url + 'Cauth/email_registro',
					type: 'post',
					data: {
						id: id_usuario,
						password: respuesta.password,
					},
				}).done(function (data2) {
					alert(
						'Se ha enviado un correo electronico con la información de la cuenta'
					);
				});
			} else {
				contenido =
					'<div class=""><div class="panel panel-danger"><div class="panel-heading">Error</div><div class="panel-body">' +
					respuesta.valor +
					'</div></div></div>';
				$.blockUI({ message: contenido });
				setTimeout(function () {
					desbloquear_modal_reg();
				}, 3000);
			}
		} catch (error) {
			console.log({ error });
		}
	});
});
$('.select2').select2({ placeholder: 'Centro de costo' });

function detener_submit(e) {
	e.preventDefault();
}

/*Logica para mostrar mensajes de error al momento de hacerse un registro*/

function desbloquear_modal_reg() {
	$.unblockUI();
	abrir_modal_modal_reg();
}

function abrir_modal_modal_reg() {
	$('.abrir_modal_modal_reg').click();
}

function notify_register(action) {
	//mensajes de alerta
	var msj = '';
	var tipo = '';
	if (action == 'add') {
		msj = 'usuario registrado exitosamente';
		tipo = 'success';
	} else if (action == 'edit') {
		msj = 'usuario editada exitosamente';
		tipo = 'info';
	} else if (action == 'del') {
		msj = 'usuario eliminada exitosamente';
		tipo = 'danger';
	} else if (action == 'notificacion') {
		msj = 'Se ha enviado un correo con la información del Ticket';
		tipo = 'info';
	} else if (action == 'validacion') {
		msj = 'Debe ingresar el nombre de usuario y constraseña';
		tipo = 'warning';
	} else if (action == 'existe') {
		msj = 'Usuario o contraseña incorrectos';
		tipo = 'danger';
	} else if ((action = 'confirmado')) {
		msj = 'El usuario no ha activado la cuenta';
		tipo = 'warning';
	}

	$.notify(
		{
			// icon: 'glyphicon glyphicon-user',
			title: '<strong>MSJ:</strong> ',
			message: msj,
		},
		{
			type: tipo,
		}
	);
}

$('.contenedor-login-eva #form-login').submit(function (e) {
	e.preventDefault();

	if (
		$('.contenedor-login-eva #form-login #username').val().length == 0 ||
		$('.contenedor-login-eva #form-login #password').val().length == 0
	) {
		notify_register('validacion');
	} else {
		var formulario = new FormData(this);

		$.ajax({
			url: base_url + 'Cauth/login',
			type: 'post',
			data: formulario,
			dataType: 'html',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (data) {
			var respuesta = JSON.parse(data);
			if (respuesta.existe == 'no') {
				notify_register('existe');
			} else {
				if (respuesta.confirmo == 'no') {
					notify_register('confirmado');
				} else {
					location.reload();
				}
			}
		});
	}
});
