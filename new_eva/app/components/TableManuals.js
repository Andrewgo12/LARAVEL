import { ajax } from './helpers/ajax.js';

const TableManuals = async (id) => {
	const app = new BaseComponent({
		el: id,
		data: {
			state: [],
		},
		template: function (props) {
			if (props.state.length < 1) return `<p><em>Empty Data.</em></p>`;

			let table = `
      <thead>
        <tr>
          <th>Id</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody></tbody>
      `;
			let content = props.state
				.map(
					(element) => `
          <tr>
            <td>${element.id}</td>
            <td>${element.descripcion}</td>
          </tr>
        `
				)
				.join('');
			table = table.replace('<tbody></tbody>', `<tbody>${content}</tbody>`);
			return table;
		},
	});

	await ajax({
		url: 'http://eva.huv.gov.co/manual/Cmanuales/getAll',
		cbSuccess: (json) => {
			json.map((element) => {
				console.log(element);
				app.setState({
					state: [...app.getState().state, element],
				});
			});
		},
	});

	return app;
};

export default TableManuals;
