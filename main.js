const apiUrl = "http://localhost/crud_api/index.php/users";
const userForm = document.getElementById("user-form");
const userIdInput = document.getElementById("user-id");
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const userList = document.getElementById("user-list");
let usersList = [];
//  Afficher tous les utilisateurs
function fetchUsers() {
  fetch(apiUrl)
    .then((res) => res.json())
    .then((users) => {
      userList.innerHTML = "";
      users.forEach((user) => {
        const li = document.createElement("li");
        li.innerHTML = `
              <strong>${user.name}</strong> (${user.email})
              <button onclick="editUser(${user.id}, '${user.name}', '${user.email}')">Modifier</button>
              <button onclick="deleteUser(${user.id})">Supprimer</button>
              <button onclick="getUser(${user.id})">show</button>
            `;
        userList.appendChild(li);
      });
    });
}

// 🔹 Ajouter ou modifier un utilisateur
userForm.addEventListener("submit", function (e) {
  e.preventDefault();
  const id = userIdInput.value;
  const name = nameInput.value;
  const email = emailInput.value;

  const method = id ? "PUT" : "POST";
  const url = id ? `${apiUrl}/${id}` : apiUrl;

  fetch(url, {
    method: method,
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, email }),
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message || "Succès !");
      userForm.reset();
      fetchUsers();
    });
});

// 🔹 Pré-remplir le formulaire pour modifier
function editUser(id, name, email) {
  userIdInput.value = id;
  nameInput.value = name;
  emailInput.value = email;
}

// 🔹 Supprimer un utilisateur
function deleteUser(id) {
  if (confirm("Supprimer cet utilisateur ?")) {
    fetch(`${apiUrl}/${id}`, {
      method: "DELETE",
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        fetchUsers();
      });
  }
}

function getUser(id) {
  fetch(`${apiUrl}/${id}`, {
    method: "GET",
  })
    .then((res) => res.json())
    .then((data) => {
      alert(`${data.id} | ${data.name} | ${data.email} `);
    });
}

// Charger les utilisateurs au départ
fetchUsers();
