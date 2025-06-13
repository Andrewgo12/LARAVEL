import { ajax } from './helpers/ajax.js';

const SelectManuals = async (id) => {
	const app = new BaseComponent({
		el: id,
		data: {
			state: [],
		},
		template: function (props) {
			if (props.state.length < 1) {
				return `<p><em>Empty Data.</em></p>`;
			}
			let content = props.state
				.map((element) => `<option>${element.descripcion}</option>`)
				.join('');
			return content;
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

export default SelectManuals;
