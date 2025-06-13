// User class representing a user object
class User {
	constructor(id, name, email) {
		this.id = id;
		this.name = name;
		this.email = email;
	}
}

// UserService class responsible for handling user-related operations
class UserService {
	constructor() {
		this.userTable = document.getElementById('userTable');
		this.userRows = this.userTable.getElementsByTagName('tbody')[0];
		this.searchInput = document.getElementById('searchInput');
		this.sortSelect = document.getElementById('sortSelect');
		this.currentPage = 1;
		this.usersPerPage = 5;
		this.totalPages = 0;
		this.users = [];

		this.searchInput.addEventListener('input', () => this.searchUsers());
		this.sortSelect.addEventListener('change', () => this.sortUsers());
		this.fetchUsers();
	}

	fetchUsers() {
		fetch('/api/users') // Replace '/api/users' with your actual API endpoint for fetching users
			.then((response) => response.json())
			.then((users) => {
				this.users = users.map(
					(user) => new User(user.id, user.name, user.email)
				);
				this.totalPages = Math.ceil(this.users.length / this.usersPerPage);
				this.renderUsers();
			})
			.catch((error) => {
				console.error('Error fetching users:', error);
			});
	}

	searchUsers() {
		const searchTerm = this.searchInput.value.toLowerCase();
		const filteredUsers = this.users.filter(
			(user) =>
				user.id.toString().toLowerCase().includes(searchTerm) ||
				user.name.toLowerCase().includes(searchTerm) ||
				user.email.toLowerCase().includes(searchTerm)
		);
		this.totalPages = Math.ceil(filteredUsers.length / this.usersPerPage);
		this.currentPage = 1;
		this.renderUsers(filteredUsers);
	}

	sortUsers() {
		const sortBy = this.sortSelect.value;
		const sortedUsers = [...this.users].sort((a, b) => {
			if (sortBy === 'name') {
				return a.name.localeCompare(b.name);
			} else if (sortBy === 'email') {
				return a.email.localeCompare(b.email);
			} else {
				return a.id - b.id;
			}
		});
		this.renderUsers(sortedUsers);
	}

	renderUsers(users = this.users) {
		this.userRows.innerHTML = '';

		const startIndex = (this.currentPage - 1) * this.usersPerPage;
		const endIndex = startIndex + this.usersPerPage;
		const paginatedUsers = users.slice(startIndex, endIndex);

		for (const user of paginatedUsers) {
			this.addUserRow(user);
		}

		this.renderPagination();
	}

	addUserRow(user) {
		const row = document.createElement('tr');
		row.innerHTML = `
      <td>${user.id}</td>
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>
        <button class="editBtn">Edit</button>
        <button class="deleteBtn">Delete</button>
      </td>
    `;

		const editButton = row.querySelector('.editBtn');
		editButton.addEventListener('click', () => this.editUser(user));

		const deleteButton = row.querySelector('.deleteBtn');
		deleteButton.addEventListener('click', () => this.deleteUser(user));

		this.userRows.appendChild(row);
	}

	editUser(user) {
		// Perform necessary actions for editing the user
		// For example, show a modal or navigate to an edit page
		console.log('Editing user:', user);
	}

	deleteUser(user) {
		// Perform necessary actions for deleting the user
		console.log('Deleting user:', user);
	}

	renderPagination() {
		const paginationContainer = document.getElementById('paginationContainer');
		paginationContainer.innerHTML = '';

		const previousButton = this.createPaginationButton('Previous', () => {
			if (this.currentPage > 1) {
				this.currentPage--;
				this.renderUsers();
			}
		});

		const nextButton = this.createPaginationButton('Next', () => {
			if (this.currentPage < this.totalPages) {
				this.currentPage++;
				this.renderUsers();
			}
		});

		paginationContainer.appendChild(previousButton);

		for (let i = 1; i <= this.totalPages; i++) {
			const pageButton = this.createPaginationButton(i, () => {
				this.currentPage = i;
				this.renderUsers();
			});

			if (i === this.currentPage) {
				pageButton.classList.add('active');
			}

			paginationContainer.appendChild(pageButton);
		}

		paginationContainer.appendChild(nextButton);
	}

	createPaginationButton(label, onClick) {
		const button = document.createElement('button');
		button.innerText = label;
		button.addEventListener('click', onClick);
		return button;
	}
}

// Create an instance of the UserService class
export const userService = new UserService();
