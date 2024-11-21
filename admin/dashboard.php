<?php
session_name("administrative"); 
session_start();
if (!isset($_SESSION['email'])) {
  $redirect_url = 'login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
  header("Location: $redirect_url");
  exit();
}
include("includes/db_connect.php");
$data = [];
if($_SESSION['email']){
  $user_email = $_SESSION['email'];
}
else{
  $user_email = "GUEST";
}
// Fetch counts from each table
$sqlAlumni = "SELECT COUNT(*) as alumni_count FROM alumni_registration";
$sqlStudent = "SELECT COUNT(*) as student_count FROM student_registration";
$sqlPosts = "SELECT COUNT(*) as posts_count FROM posts";
$sqlQueries = "SELECT COUNT(*) as queries_count FROM queries";

$data['alumni'] = $conn->query($sqlAlumni)->fetch_assoc()['alumni_count'] ?? 0;
$data['student'] = $conn->query($sqlStudent)->fetch_assoc()['student_count'] ?? 0;
$data['posts'] = $conn->query($sqlPosts)->fetch_assoc()['posts_count'] ?? 0;
$data['queries'] = $conn->query($sqlQueries)->fetch_assoc()['queries_count'] ?? 0;

// Return data as JSON
json_encode($data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" >

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            sidebar: "#ffffff",
            sidebarHover: "#f0f0f0",
            sidebarBorder: "#e0e0e0",
            headerBorder: "#e0e0e0",
            statCard: "#ffffff",
            statCardShadow: "rgba(0, 0, 0, 0.1)",
            tableHeader: "#e0e0e0",
            tableCell: "#e0e0e0",
            badgeActive: "#4CAF50",
            badgeInactive: "#9E9E9E",
          },
          fontFamily: {
            montserrat: ["Montserrat", "sans-serif"],
          },
        },
      },
    };
  </script>
  <style>
    * {
      font-family: montserrat, sans-serif;
    }

    .transition-sidebar {
      transition: width 0.3s ease;
    }

    .transition-content {
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .modal {
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
  </style>
</head>

<body class="bg-gray-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-sidebar border-r border-sidebarBorder transition-sidebar w-64 overflow-hidden">
      <div class="w-64 h-full flex flex-col p-5">
        <h2 class="text-2xl font-bold mb-8">Pharma Society</h2>
        <nav class="flex flex-col flex-1">
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded"
            data-nav="Dashboard">
            <i class="fas fa-home mr-2"></i> Dashboard
          </button>
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded" data-nav="Alumni">
            <i class="fas fa-user-graduate mr-2"></i> Alumni
          </button>
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded" data-nav="Students">
            <i class="fas fa-user-friends mr-2"></i> Students
          </button>
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded" data-nav="Posts">
            <i class="fas fa-file-alt mr-2"></i> Posts
          </button>
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded" data-nav="Queries">
            <i class="fas fa-question-circle mr-2"></i> Queries
          </button>
          <button class="flex items-center p-2 mb-2 w-full text-left hover:bg-sidebarHover rounded"
            data-nav="Notifications">
            <i class="fas fa-bell mr-2"></i> Notifications
          </button>
        </nav>
        <button class="flex items-center p-2 text-red-600">
          <a href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </button>
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header class="flex justify-between items-center p-4 border-b border-headerBorder">
        <div class="flex items-center">
          <button id="sidebarToggle" class="text-xl mr-4">
            <i class="fas fa-bars"></i>
          </button>
          <input type="search" placeholder="Search..." class="p-2 border border-gray-300 rounded h-10"
            id="searchInput" />
        </div>
        <div class="flex items-center">
          <button class="text-xl mr-4" id="notificationButton">
            <i class="fas fa-bell"></i>
          </button>
          <div class="flex items-center cursor-pointer">
            <img src="https://via.placeholder.com/32" alt="User" class="w-8 h-8 rounded-full mr-2" />
            <span class="mr-2"><?php echo $user_email ?></span>
            <!-- <i class="fas fa-chevron-down"></i> -->
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main id="pageContent" class="flex-1 overflow-y-auto p-6 transition-content">
        <!-- Content will be dynamically inserted here -->
      </main>
    </div>
  </div>

  <!-- Notification Modal -->
  <div id="notificationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-lg w-full max-w-md">
      <h2 id="modalTitle" class="text-2xl font-bold mb-4">
        Create Notification
      </h2>
      <form id="notificationForm" method="POST">
        <input type="hidden" id="notificationId" name="id" />
        <input type="hidden" name="action" value="create" />
        <div class="mb-4">
          <label for="notificationTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input type="text" id="notificationTitle" name="title" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        </div>
        <div class="mb-4">
          <label for="notificationMessage" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
          <textarea id="notificationMessage" name="message" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        <div class="flex justify-end">
          <button type="button" id="cancelNotification"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400 transition-colors">
            Cancel
          </button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
    toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
    // Data
   const datas = <?php echo json_encode($data); ?> ;
      const quickStats = [
        { label: "Alumni", value: datas.alumni },
        { label: "Student", value: datas.student },
        { label: "Posts", value: datas.posts },
        { label: "Queries", value: datas.queries },
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

    let posts = [
      { id: 1, title: "First Blog Post", author: "John Doe", dateCreated: "2023-05-01" },
      { id: 2, title: "Upcoming Events", author: "Jane Smith", dateCreated: "2023-05-05" },
      { id: 3, title: "New Product Announcement", author: "Bob Johnson", dateCreated: "2023-05-10" },
    ];

    let queries = [
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
            </div>
          `).join("")}
        </div>
      `;
    }

    function validateUser(id) {
      fetch('validatealumniuser.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            toastr.success(data.message); // Display success message
            // Optionally, refresh the table or update UI dynamically
          } else {
            toastr.success(data.message); // Display success message
          }
        })
        .catch(error => console.error('Error:', error));
    }

    function validateStu(id) {
      fetch('validatestudentuser.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            toastr.success(data.message); // Display success message
            // Optionally, refresh the table or update UI dynamically
          } else {
            toastr.success(data.message); // Display success message
          }
        })
        .catch(error => console.error('Error:', error));
    }

function renderTable(data, columns, deleteFunction, validateFunction) {
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
              <td class="p-3 flex gap-2">
                ${
                  item.validation
                    ? `<button class="text-green-500 hover:text-green-700" onclick="${validateFunction.name}(${item.id})">
                        <i class="fas fa-check"></i> Validate
                      </button>`
                    : ""
                }
                <button class="text-red-500 hover:text-red-700" onclick="${deleteFunction.name}(${item.id})">
                  <i class="fas fa-trash"></i> Delete
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
        <div class="mb-4 flex justify-end">
            <button id="addQueryBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                Validate all alumni
            </button>
        </div>
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
            { key: "validation", label:"Validation Status"}
          ], deleteAlumni, validateUser)}
      `;
          break;
        case "Students":
          content = `
        <h1 class="text-3xl font-bold mb-6">Student Management</h1>
        <div class="mb-4 flex justify-end">
            <button id="addQueryBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                Validate all students
            </button>
        </div>
        ${renderTable(students, [
            { key: "full_name", label: "Full Name" },
            { key: "email", label: "Email" },
            { key: "phone", label: "Phone" },
            { key: "course", label: "Course" },
            { key: "dob", label: "Date of Birth" },
            { key: "year_of_admission", label: "Year of Admission" },
            { key: "validation", label:"Validation Status"}
          ], deleteStudent, validateStu)}
      `;
          break;

        case "Posts":
          content = `
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Posts Management</h1>
        <div class="mb-4 flex justify-end">
            <button id="addPostBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                Validate all posts
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Author</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Date Created</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="postsTableBody">
                    <!-- Posts will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>
`;
          setTimeout(() => fetchPostsAndQueries(), 0);
          break;

        case "Queries":
          content = `
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Queries Management</h1>
        <div class="mb-4 flex justify-end">
            <button id="addQueryBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                Validate all queries
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Author</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Date Created</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="queriesTableBody">
                    <!-- Queries will be dynamically inserted here -->
                </tbody>
            </table>
        </div>

    </div>
`;
          setTimeout(() => fetchPostsAndQueries(), 0);
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


    // Exp starts

    function fetchPostsAndQueries() {
      console.log("Fetching posts and queries...");
      fetch("fetch_posts_and_queries.php")
        .then((response) => response.json())
        .then((data) => {
          console.log("Received data:", data);
          if (data.status === "success") {
            const postsData = data.data.filter((item) => item.type === "post");
            const queriesData = data.data.filter((item) => item.type === "query");
            console.log("Posts data:", postsData);
            console.log("Queries data:", queriesData);
            renderPosts(postsData);
            renderQueries(queriesData);
          } else {
            console.error("Error fetching posts and queries:", data.message);
          }
        })
        .catch((error) => console.error("Error:", error));
    }

    function renderPosts(posts) {
      const postsTableBody = document.getElementById("postsTableBody");
      if (postsTableBody) {
        postsTableBody.innerHTML = posts.map(post => `
      <tr>
        <td class="p-3">${post.id}</td>
        <td class="p-3">${post.title}</td>
        <td class="p-3">${post.author}</td>
        <td class="p-3">${new Date(post.timestamp).toLocaleDateString()}</td>
        <td class="p-3">
          <button class="text-green-500 hover:text-green-700" onclick="toggleValidation(${post.id}, 'post')">
            ${post.is_validated ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'}
          </button>
          <button class="text-red-500 hover:text-red-700" onclick="deletePostOrQuery(${post.id}, 'post')">
            <i class="fas fa-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
      }
    }

    function renderQueries(queries) {
      const queriesTableBody = document.getElementById("queriesTableBody");
      if (queriesTableBody) {
        queriesTableBody.innerHTML = queries.map(query => `
      <tr>
        <td class="p-3">${query.id}</td>
        <td class="p-3">${query.title}</td>
        <td class="p-3">${query.author}</td>
        <td class="p-3">${new Date(query.timestamp).toLocaleDateString()}</td>
        <td class="p-3">
          <button class="text-green-500 hover:text-green-700" onclick="toggleValidation(${query.id}, 'query')">
            ${query.is_validated ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'}
          </button>
          <button class="text-red-500 hover:text-red-700" onclick="deletePostOrQuery(${query.id}, 'query')">
            <i class="fas fa-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
      }
    }

    function toggleValidation(id, type) {
      fetch('fetch_posts_and_queries.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&type=${type}&action=toggle_validate`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            // Fetch and reload posts and queries after validation update
            fetchPostsAndQueries();
          } else {
            console.error('Error updating validation status:', data.message);
          }
        })
        .catch(error => console.error('Error:', error));
    }

    function deletePostOrQuery(id, type) {
      if (confirm(`Are you sure you want to delete this ${type}?`)) {
        fetch("fetch_posts_and_queries.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `id=${id}&type=${type}`,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "success") {
              alert(`${type.charAt(0).toUpperCase() + type.slice(1)} deleted successfully.`);
              fetchPostsAndQueries();
            } else {
              console.error("Error:", data.message);
            }
          })
          .catch((error) => console.error("Error:", error));
      }
    }


    document.addEventListener("DOMContentLoaded", () => {
      initNotificationEventListeners();
      fetchNotifications();
      fetchPostsAndQueries(); // Call to fetch and render posts and queries
    });


    // Exp ends
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
  </script>
</body>

</html>