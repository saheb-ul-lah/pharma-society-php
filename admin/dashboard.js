// Data
const quickStats = [
    { label: "Active Users", value: 1234, change: 5.6 },
    { label: "New Registrations", value: 567, change: -2.3 },
    { label: "Upcoming Events", value: 12, change: 10.5 },
    { label: "Open Tickets", value: 89, change: -7.8 },
];

// Fetch and manage student data
let students = [];

function fetchStudentData() {
    fetch("fetch_students.php")
        .then(response => response.json())
        .then(data => {
            students = data;
            updateContent();
        })
        .catch(error => console.error("Error fetching student data:", error));
}

function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch("delete_student.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `delete_id=${id}`,
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                students = students.filter(student => student.id !== id);
                updateContent();
            })
            .catch(error => console.error("Error deleting student:", error));
    }
}

fetchStudentData();

const posts = [
    { id: 1, title: "First Blog Post", author: "John Doe", dateCreated: "2023-05-01" },
    { id: 2, title: "Upcoming Events", author: "Jane Smith", dateCreated: "2023-05-05" },
    { id: 3, title: "New Product Announcement", author: "Bob Johnson", dateCreated: "2023-05-10" },
];

const queries = [
    { id: 1, title: "Admission Query", author: "Prospective Student", dateCreated: "2023-05-15" },
    { id: 2, title: "Course Information", author: "Current Student", dateCreated: "2023-05-18" },
    { id: 3, title: "Alumni Event", author: "Alumni Member", dateCreated: "2023-05-20" },
];

let notifications = [];
let alumni = [];

function fetchAlumniData() {
    fetch("fetch_alumni.php")
        .then(response => response.json())
        .then(data => {
            alumni = data;
            updateContent();
        })
        .catch(error => console.error("Error fetching alumni data:", error));
}

function deleteAlumni(id) {
    if (confirm("Are you sure you want to delete this alumni?")) {
        fetch("delete_alumni.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `delete_id=${id}`,
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                alumni = alumni.filter(item => item.id !== id);
                updateContent();
                location.reload();
            })
            .catch(error => console.error("Error deleting alumni:", error));
    }
}

fetchAlumniData();

const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");
const pageContent = document.getElementById("pageContent");
const searchInput = document.getElementById("searchInput");
const navButtons = document.querySelectorAll("[data-nav]");
const notificationButton = document.getElementById("notificationButton");
const notificationModal = document.getElementById("notificationModal");
const notificationForm = document.getElementById("notificationForm");
const modalTitle = document.getElementById("modalTitle");
const notificationId = document.getElementById("notificationId");
const notificationTitle = document.getElementById("notificationTitle");
const notificationMessage = document.getElementById("notificationMessage");
const cancelNotification = document.getElementById("cancelNotification");

let activeNavItem = "Dashboard";
let isSidebarVisible = true;

function toggleSidebar() {
    isSidebarVisible = !isSidebarVisible;
    sidebar.style.width = isSidebarVisible ? "16rem" : "0";
}

function renderDashboard() {
    return `
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        ${quickStats.map(stat => `
        <div class="bg-statCard p-6 rounded-lg shadow-md">
            <h3 class="text-lg text-gray-600 mb-2">${stat.label}</h3>
            <p class="text-3xl font-bold mb-2">${stat.value.toLocaleString()}</p>
            <p class="text-sm ${stat.change >= 0 ? "text-green-500" : "text-red-500"}">
            ${stat.change >= 0 ? "+" : ""}${stat.change}% from last month
            </p>
        </div>
        `).join("")}
    </div>
    `;
}

function renderTable(data, columns, deleteFunction) {
    return `
    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-200">
            ${columns.map(column => `<th class="p-3 text-left">${column.label}</th>`).join("")}
            <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            ${data.map(item => `
            <tr class="border-b border-gray-200">
                ${columns.map(column => `<td class="p-3">${item[column.key]}</td>`).join("")}
                <td class="p-3">
                <button class="text-red-500 hover:text-red-700" onclick="${deleteFunction.name}(${item.id})">
                    <i class="fas fa-trash"></i>
                </button>
                </td>
            </tr>
            `).join("")}
        </tbody>
        </table>
    </div>
    `;
}

function renderNotifications() {
    return `
    <h1 class="text-3xl font-bold mb-6">Notifications</h1>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        ${notifications.map(notification => `
        <div class="p-4 border-b border-gray-200 ${notification.is_read ? "bg-gray-100" : "bg-white"}">
            <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold ${notification.is_read ? "text-gray-600" : "text-black"}">
                ${notification.title}
                </h3>
                <p class="text-sm text-gray-600">${notification.message}</p>
            </div>
            <span class="text-xs text-gray-500">${notification.date}</span>
            </div>
            <div class="mt-2 flex justify-end">
            
            </button>
            <button class="text-sm text-green-500 hover:text-green-700 mr-2" onclick="openNotificationModal(${notification.id})">
                Edit
            </button>
            <button class="text-sm text-red-500 hover:text-red-700" onclick="deleteNotification(${notification.id})">
                Delete
            </button>
            </div>
        </div>
        `).join("")}
    </div>
    <div class="mt-4 flex justify-between items-center">
        <button onclick="openNotificationModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
        Create New Notification
        </button>
    </div>
    `;
}

function fetchNotifications() {
    fetch('manage_notifications.php', { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            notifications = data;
            updateContent();
        })
        .catch(error => console.error("Error fetching notifications:", error));
}

function toggleReadStatus(id) {
    fetch('manage_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=mark_read&id=${id}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') fetchNotifications();
        })
        .catch(error => console.error("Error updating read status:", error));
}

function markAllAsRead() {
    fetch('manage_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=mark_all_read',
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') fetchNotifications();
        })
        .catch(error => console.error("Error marking all as read:", error));
}

function deleteNotification(id) {
    if (confirm("Are you sure you want to delete this notification?")) {
        fetch('manage_notifications.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&id=${id}`,
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') fetchNotifications();
            })
            .catch(error => console.error("Error deleting notification:", error));
    }
}

function openNotificationModal(id = null) {
    modalTitle.textContent = id ? "Edit Notification" : "Create Notification";
    notificationId.value = id || "";
    if (id) {
        const notification = notifications.find(n => n.id == id);
        if (notification) {
            notificationTitle.value = notification.title;
            notificationMessage.value = notification.message;
        }
    } else {
        notificationTitle.value = "";
        notificationMessage.value = "";
    }
    notificationModal.classList.remove("hidden");
}

function closeNotificationModal() {
    notificationModal.classList.add("hidden");
}

function saveNotification(e) {
    e.preventDefault();

    const id = notificationId.value;
    const title = notificationTitle.value;
    const message = notificationMessage.value;

    const formData = new URLSearchParams();
    formData.append('title', title);
    formData.append('message', message);

    const action = id ? 'update' : 'create';
    formData.append('action', action);

    if (id) {
        formData.append('id', id);
    }

    fetch('manage_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                closeNotificationModal();
                fetchNotifications();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderContent() {
    let content = "";
    switch (activeNavItem) {
        case "Dashboard":
            content = renderDashboard();
            break;
        case "Alumni":
            content = `
        <h1 class="text-3xl font-bold mb-6">Alumni Management</h1>
        ${renderTable(alumni, [
                { key: "full_name", label: "Full Name" },
                { key: "dob", label: "D.O.B" },
                { key: "gender", label: "Gender" },
                { key: "email", label: "Email" },
                { key: "phone", label: "Phone" },
                { key: "address", label: "Address" },
                { key: "job_title", label: "Current Job Title" },
                { key: "company", label: "Company" },
                { key: "company_location", label: "Company Location" },
                { key: "degrees", label: "Degrees" },
                { key: "linkedin", label: "LinkedIn" },
                { key: "twitter", label: "Twitter" },
                { key: "facebook", label: "Facebook" },
            ], deleteAlumni)}
        `;
            break;
        case "Students":
            content = `
        <h1 class="text-3xl font-bold mb-6">Student Management</h1>
        ${renderTable(students, [
                { key: "full_name", label: "Full Name" },
                { key: "email", label: "Email" },
                { key: "phone", label: "Phone" },
                { key: "course", label: "Course" },
                { key: "dob", label: "Date of Birth" },
                { key: "year_of_admission", label: "Year of Admission" },
            ], deleteStudent)}
        `;
            break;
    case "Posts":
            content = `
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Posts Management</h1>
        <div class="bg-white shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Author</th>
                        <th class="p-3 text-left">Date Created</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="postsTableBody">
                    <!-- Posts will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <button id="addPostBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Post
            </button>
        </div>
    </div>
`;
            break;

        case "Queries":
            content = `
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Queries Management</h1>
        <div class="bg-white shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Author</th>
                        <th class="p-3 text-left">Date Created</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="queriesTableBody">
                    <!-- Queries will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <button id="addQueryBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Query
            </button>
        </div>
    </div>
`;
            break;
        case "Notifications":
            content = renderNotifications();
            break;
        default:
            content = renderDashboard();
    }
    return content;
}

function updateContent() {
    pageContent.style.opacity = "0";
    pageContent.style.transform = "translateY(20px)";
    setTimeout(() => {
        pageContent.innerHTML = renderContent();
        pageContent.style.opacity = "1";
        pageContent.style.transform = "translateY(0)";
    }, 300);
}

function filterData(searchTerm) {
    const filteredAlumni = alumni.filter(item =>
        Object.values(item).some(val =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredStudents = students.filter(item =>
        Object.values(item).some(val =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredPosts = posts.filter(item =>
        Object.values(item).some(val =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredQueries = queries.filter(item =>
        Object.values(item).some(val =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );

    alumni.splice(0, alumni.length, ...filteredAlumni);
    students.splice(0, students.length, ...filteredStudents);
    posts.splice(0, posts.length, ...filteredPosts);
    queries.splice(0, queries.length, ...filteredQueries);

    updateContent();
}

function initNotificationEventListeners() {
    cancelNotification.addEventListener('click', closeNotificationModal);
    notificationForm.addEventListener('submit', saveNotification);
}

document.addEventListener('DOMContentLoaded', () => {
    initNotificationEventListeners();
    fetchNotifications();
});

sidebarToggle.addEventListener("click", toggleSidebar);

navButtons.forEach(button => {
    button.addEventListener("click", () => {
        activeNavItem = button.getAttribute("data-nav");
        updateContent();
    });
});

searchInput.addEventListener("input", e => {
    filterData(e.target.value);
});

notificationButton.addEventListener("click", () => {
    activeNavItem = "Notifications";
    updateContent();
});

updateContent();