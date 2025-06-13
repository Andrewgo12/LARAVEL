export const ControlButton = (props) => {
	return `
      <li class="list-inline-item">
        <a title="${props.title}" href="#"
          class="${props.classes}"
          data-toggle="modal"
          data-target="${props.target}"
          onclick="${props.onclick}">
        </a>
      </li>
  `;
};
