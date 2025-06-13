/**
 * The function creates a header element with a title and subtitle and adds it to the DOM.
 */
export function Header({ id, title, subtitle }) {
	const $header = document.getElementById(id);
	$header.classList.add('content-header');
	$header.innerHTML = `
    <section class="content-header">
      <h3>${title}</h3> <small>${subtitle}</small>
    </section>
  `;
}
