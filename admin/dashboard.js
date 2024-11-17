// DOM Elements
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

// Data
const quickStats = [
    { label: "Active Users", value: 1234, change: 5.6 },
    { label: "New Registrations", value: 567, change: -2.3 },
    { label: "Upcoming Events", value: 12, change: 10.5 },
    { label: "Open Tickets", value: 89, change: -7.8 },
];

// Fetch and manage student data
let students = [];

// Function to fetch student data
function fetchStudentData() {
    fetch("fetch_students.php") // Replace with the actual path to your PHP file that fetches data
        .then((response) => response.json())
        .then((data) => {
            students = data; // Store the fetched student data
            updateContent(); // Render the content with the fetched data
        })
        .catch((error) =>
            console.error("Error fetching student data:", error)
        );
}

// Function to delete a student entry
function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch("delete_student.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `delete_id=${id}`, // Send the delete id
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data); // Optionally log the response for debugging
                students = students.filter((student) => student.id !== id); // Remove the deleted entry from the client-side data
                updateContent(); // Refresh the content to reflect the deletion
            })
            .catch((error) => console.error("Error deleting student:", error));
    }
}

// Initial call to fetch student data
fetchStudentData();


// State
let activeNavItem = "Dashboard";
let isSidebarVisible = true;

// Functions
function toggleSidebar() {
    isSidebarVisible = !isSidebarVisible;
    sidebar.style.width = isSidebarVisible ? "16rem" : "0";
}

function renderDashboard() {
    return `
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                ${quickStats
            .map(
                (stat) => `
                    <div class="bg-statCard p-6 rounded-lg shadow-md">
                        <h3 class="text-lg text-gray-600 mb-2">${stat.label}</h3>
                        <p class="text-3xl font-bold mb-2">${stat.value.toLocaleString()}</p>
                        <p class="text-sm ${stat.change >= 0
                        ? "text-green-500"
                        : "text-red-500"
                    }">
                            ${stat.change >= 0 ? "+" : ""}${stat.change}% from last month
                        </p>
                    </div>
                `
            )
            .join("")}
            </div>
        `;
}

function renderTable(data, columns, deleteFunction) {
    return `
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-200">
                            ${columns
            .map(
                (column) =>
                    `<th class="p-3 text-left">${column.label}</th>`
            )
            .join("")}
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data
            .map(
                (item) => `
                            <tr class="border-b border-gray-200">
                                ${columns
                        .map(
                            (column) => `
                                    <td class="p-3">
                                        ${item[column.key]}
                                    </td>
                                `
                        )
                        .join("")}
                                <td class="p-3">
                                    <button class="text-red-500 hover:text-red-700" onclick="${deleteFunction.name}(${item.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `
            )
            .join("")}
                    </tbody>
                </table>
            </div>
        `;
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
                    <h1 class="text-3xl font-bold mb-6">Posts Management</h1>
                    ${renderTable(posts, [
                { key: "title", label: "Title" },
                { key: "author", label: "Author" },
                { key: "dateCreated", label: "Date Created" },
            ], deleteItem)}
                `;
            break;
        case "Queries":
            content = `
                    <h1 class="text-3xl font-bold mb-6">Queries Management</h1>
                    ${renderTable(queries, [
                { key: "title", label: "Title" },
                { key: "author", label: "Author" },
                { key: "dateCreated", label: "Date Created" },
            ], deleteItem)}
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
    const filteredAlumni = alumni.filter((item) =>
        Object.values(item).some((val) =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredStudents = students.filter((item) =>
        Object.values(item).some((val) =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredPosts = posts.filter((item) =>
        Object.values(item).some((val) =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
    const filteredQueries = queries.filter((item) =>
        Object.values(item).some((val) =>
            val.toString().toLowerCase().includes(searchTerm.toLowerCase())
        )
    );

    // Update the data
    alumni.splice(0, alumni.length, ...filteredAlumni);
    students.splice(0, students.length, ...filteredStudents);
    posts.splice(0, posts.length, ...filteredPosts);
    queries.splice(0, queries.length, ...filteredQueries);

    // Re-render the content
    updateContent();
}



// Fetch and manage alumni data
let alumni = [];

// Function to fetch alumni data
function fetchAlumniData() {
    fetch("fetch_alumni.php") // Replace with the actual path to your PHP file that fetches data
        .then((response) => response.json())
        .then((data) => {
            alumni = data; // Store the fetched alumni data
            updateContent(); // Render the content with the fetched data
        })
        .catch((error) =>
            console.error("Error fetching alumni data:", error)
        );
}

// Function to delete an alumni entry
function deleteAlumni(id) {
    if (confirm("Are you sure you want to delete this alumni?")) {
        fetch("delete_alumni.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `delete_id=${id}`, // Send the delete id
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data); // Optionally log the response for debugging
                alumni = alumni.filter((item) => item.id !== id); // Remove the deleted entry from the client-side data
                updateContent(); // Refresh the content to reflect the deletion
                location.reload();
            })
            .catch((error) => console.error("Error deleting alumni:", error));
    }
}

// Initial call to fetch alumni data
fetchAlumniData();



function deleteItem(id) {
    if (activeNavItem === "Posts") {
        posts = posts.filter((post) => post.id !== id);
    } else if (activeNavItem === "Queries") {
        queries = queries.filter((query) => query.id !== id);
    }
    updateContent();
}

// Event Listeners
sidebarToggle.addEventListener("click", toggleSidebar);

navButtons.forEach((button) => {
    button.addEventListener("click", () => {
        activeNavItem = button.getAttribute("data-nav");
        updateContent();
    });
});

searchInput.addEventListener("input", (e) => {
    filterData(e.target.value);
});



// Posts and queries part

const posts = [
    {
        id: 1,
        title: "First Blog Post",
        author: "John Doe",
        dateCreated: "2023-05-01",
    },
    {
        id: 2,
        title: "Upcoming Events",
        author: "Jane Smith",
        dateCreated: "2023-05-05",
    },
    {
        id: 3,
        title: "New Product Announcement",
        author: "Bob Johnson",
        dateCreated: "2023-05-10",
    },
];

const queries = [
    {
        id: 1,
        title: "Admission Query",
        author: "Prospective Student",
        dateCreated: "2023-05-15",
    },
    {
        id: 2,
        title: "Course Information",
        author: "Current Student",
        dateCreated: "2023-05-18",
    },
    {
        id: 3,
        title: "Alumni Event",
        author: "Alumni Member",
        dateCreated: "2023-05-20",
    },
];



$(document).ready(function () {
    // Load notifications when the page loads
    loadNotifications();

    // Event listener for the "Create Notification" button
    $('#createNotificationBtn').click(function () {
        openModal();
    });

    // Event listener for the "Cancel" button inside the modal
    $('#cancelButton').click(function () {
        closeModal();
    });

    // Event listener for the notification form submission
    $('#notificationForm').submit(function (e) {
        e.preventDefault();
        saveNotification();
    });
});

// Function to load notifications from the server
function loadNotifications() {
    $.ajax({
        url: 'manage_notifications.php',
        method: 'GET',
        data: { action: 'fetch' },
        dataType: 'json',
        success: function (notifications) {
            renderNotifications(notifications);
        },
        error: function (xhr, status, error) {
            console.error("Error loading notifications:", error);
        }
    });
}

// Function to render the notifications inside the HTML
function renderNotifications(notifications) {
    let html = `
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Notifications</h2>
    `;

    // Loop through the notifications and create HTML for each one
    notifications.forEach(notification => {
        html += `
            <div class="border-b py-3 flex justify-between items-center">
                <div>
                    <h3 class="font-semibold">${notification.title}</h3>
                    <p class="text-gray-600">${notification.message}</p>
                    <small class="text-gray-500">${notification.date}</small>
                </div>
                <div class="space-x-2">
                    <button onclick="editNotification(${notification.id})"
                            class="bg-blue-500 text-white px-3 py-1 rounded">Edit</button>
                    <button onclick="deleteNotification(${notification.id})"
                            class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </div>
            </div>
        `;
    });

    html += `</div>`;

    // Insert the generated HTML into the DOM
    $('#pageContent').html(html);
}

// Function to open the modal for creating or editing notifications
function openModal(notification = null) {
    $('#notificationModal').removeClass('hidden');

    if (notification) {
        // If notification data is passed in, populate the modal with that data (for editing)
        $('#notificationId').val(notification.id);
        $('#notificationTitle').val(notification.title);
        $('#notificationMessage').val(notification.message);
        $('#modalTitle').text('Edit Notification');
    } else {
        // If no notification data is passed in, clear the modal for creating a new notification
        $('#notificationId').val('');
        $('#notificationTitle').val('');
        $('#notificationMessage').val('');
        $('#modalTitle').text('Create Notification');
    }
}

// Function to close the modal
function closeModal() {
    $('#notificationModal').addClass('hidden');
}

// Function to save a notification (either create new or update existing)
function saveNotification() {
    const id = $('#notificationId').val();
    const title = $('#notificationTitle').val();
    const message = $('#notificationMessage').val();

    $.ajax({
        url: 'manage_notifications.php',
        method: 'POST',
        data: {
            action: id ? 'update' : 'create', // If an ID is present, update, otherwise create.
            id: id,
            title: title,
            message: message
        },
        dataType: 'json',
        success: function (response) {
            loadNotifications(); // Reload notifications after saving
            closeModal(); // Close the modal after saving
        },
        error: function (xhr, status, error) {
            console.error("Error saving notification:", error);
        }
    });
}

// Function to edit an existing notification
function editNotification(id) {
    $.ajax({
        url: 'manage_notifications.php',
        method: 'GET',
        data: { action: 'fetch', id: id },
        dataType: 'json',
        success: function (notifications) {
            const notification = notifications.find(n => n.id == id);
            openModal(notification); // Open the modal with the notification data for editing
        },
        error: function (xhr, status, error) {
            console.error("Error fetching notification for editing:", error);
        }
    });
}

// Function to delete a notification
function deleteNotification(id) {
    if (confirm('Are you sure you want to delete this notification?')) {
        $.ajax({
            url: 'manage_notifications.php',
            method: 'POST',
            data: { action: 'delete', id: id },
            dataType: 'json',
            success: function (response) {
                loadNotifications(); // Reload notifications after deletion
            },
            error: function (xhr, status, error) {
                console.error("Error deleting notification:", error);
            }
        });
    }
}