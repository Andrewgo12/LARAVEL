export const ajax = async (props) => {
	let { url, cbSuccess } = props;

	await fetch(url)
		.then((response) =>
			response.ok ? response.json() : Promise.reject(response)
		)
		.then((json) => cbSuccess(json))
		.catch((err) => {
			let message = err.statusText || 'Error accessing to the API';

			document.getElementById('main').innerHTML = `
      <div class='error'>
        <p>Error ${err.status}: ${message}</p>
      </div>
    `;
			document.querySelector('.loader').style.display = 'none';
			console.log(err);
		});
};
