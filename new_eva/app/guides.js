const d = document;

/**
 * It makes an ajax request to the server, gets the data, and renders it to the DOM
 */
const renderGuides = () => {
	const url = `${base_url}guia/Cguias/getWithQuery`;
	$.ajax({ url, type: 'POST' }).done((data) => {
		const response = JSON.parse(data);
		const tbodyElement = document.querySelector('.tabla_guias tbody');
		let render = '';
		response.map((guide) => {
			if (guide.id != 0) {
				render += `
        <tr>
          <td>${guide.id}</td>
          <td>${guide.name}
            <a class="glyphicon glyphicon-paperclip updateCounter" data-id=${guide.id} target=" __blank" href="${base_url}assets/upload_guias/${guide.file}">
            </a>
          </td>
          <td>${guide.totalQuery}</td>
        </tr>
      `;
			}
		});
		tbodyElement.innerHTML = '';
		tbodyElement.innerHTML = render;
	});
};

/**
 * It takes an id, and sends it to the server to update the quantity of queries for that guide
 * @param id - The id of the guide
 */
const updateQueryQuantity = (id) => {
	const url = `${base_url}guia/Cguias/updateGuideQueryQuantity`;
	const data = { guia_id: id };
	$.ajax({ url, type: 'POST', data }).done((data) => {
		console.log(data);
	});
};

/**
 * It listens for a click on the updateCounter class, then it grabs the id from the dataset, then it
 * calls the updateQueryQuantity function, then it calls the renderGuides function
 */
const setUpdateCounter = () => {
	d.addEventListener('click', (e) => {
		if (e.target.matches('.updateCounter')) {
			const { id } = e.target.dataset;
			updateQueryQuantity(id);
			renderGuides();
		}
	});
};

export { setUpdateCounter, renderGuides };
