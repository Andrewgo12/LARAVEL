import { ControlButton } from './ControlButton.js';

export const controlSection = (data) => {
	const { id } = data;
	const showBtn = ControlButton({
		id,
		title: 'Visualizar hoja de vida',
		classes: 'btn btn-info glyphicon glyphicon-search',
		target: '#modal_show_equipo',
		onclick: `show_equipo(${id})`,
	});
	const editBtn = ControlButton({
		id,
		title: '"Editar la información del equipo',
		classes: 'btn btn-primary glyphicon glyphicon-pencil',
		target: '#temp',
		onclick: `recover_modal_edit(${id},event,function(){abrir_modal_update_equipo();})`,
	});
	const fileAddBtn = ControlButton({
		id,
		title: 'Adicionar archivos',
		classes: 'btn btn-warning glyphicon glyphicon-paperclip',
		target: '#modal_add_archivo',
		onclick: `show_equipo_archivos(${id})`,
	});
	const btnFileTraining = ControlButton({
		id,
		title: 'Consolidado de capacitaciones',
		classes: 'btn btn-success glyphicon glyphicon-list-alt',
		target: '#modal_show_archivos',
		onclick: `show_capacitaciones(${id})`,
	});

	const btnTrash = ControlButton({
		id,
		title: 'Asociar baja del equipo',
		classes: 'btn btn-danger glyphicon glyphicon-remove-sign',
		target: '#modal_consulta_baja',
		onclick: `show_consulta_baja(event,${id})`,
	});
	const fileShowBtn = ControlButton({
		id,
		title: 'Asociar baja del equipo',
		classes: 'btn btn-default glyphicon glyphicon-file',
		target: '#modal_show_archivos',
		onclick: `show_archivos(${id})`,
	});

	return `
    <section class="table-section">
      <ul class="list-inline">
        ${showBtn}
        ${editar_equipo ? editBtn : ''}
        ${editar_equipo && insertar_equipo_archivo ? fileAddBtn : ''}
        ${
					leer_equipo_archivo && data.cuenta_archivos_capacitaciones > 0
						? btnFileTraining
						: ''
				}
        ${insertar_baja ? btnTrash : ''}
        ${editar_equipo && insertar_equipo_archivo ? fileShowBtn : ''}
        <ul>
          <li><span class="glyphicon glyphicon-ok"></span></li>
        </ul>
      </ul>
    </section>
  `;
};
