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
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
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
            <span class="mr-2">John Doe</span>
            <i class="fas fa-chevron-down"></i>
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

  <script>
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
          ], deleteAlumni)}
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
          ], deleteStudent)}
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

this is the php code fetch_posts_and_queries.php

<?php
header('Content-Type: application/json');
require_once 'db_config.php'; // Adjust this to your database configuration file.

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($method === 'GET') {
        // Fetch posts and queries
        $stmt = $pdo->query("SELECT id, title, author, timestamp, content, is_validated, 'post' AS type FROM posts
        UNION ALL
        SELECT id, title, author, timestamp, content, is_validated, 'query' AS type FROM queries
        ORDER BY timestamp DESC");

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } elseif ($method === 'POST') {
        // Delete functionality
        $input = file_get_contents('php://input');
        parse_str($input, $parsed_input);

        if (isset($parsed_input['id']) && isset($parsed_input['type']) && isset($parsed_input['action']) && $parsed_input['action'] === 'toggle_validate') {
            $id = (int)$parsed_input['id'];
            $type = $parsed_input['type'] === 'post' ? 'posts' : 'queries';

            // Fetch the current validation status
            $stmt = $pdo->prepare("SELECT is_validated FROM $type WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $currentStatus = $stmt->fetchColumn();

            // Toggle the validation status
            $newStatus = $currentStatus == 1 ? 0 : 1;

            $stmt = $pdo->prepare("UPDATE $type SET is_validated = :newStatus WHERE id = :id");
            $stmt->execute(['newStatus' => $newStatus, 'id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Validation status updated.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No rows updated.']);
            }
            exit;
        }
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}



i want that the validate button should also work in the alumni and the student table in the admin dashboard, just like the posts and queries validation with that button in the action column

currently the validate button is not in the alumni and student sql table, but it is there in the posts sql table and queries sql table as (is_verified   it has 0 or 1 as boolean values) 

tell me the updates to make in the sql table for alumni_registration, alumni_degrees

alumni_registration has the following column names 
id
full_name
dob
gender
email
phone
address
job_title
company
company_location
linkedin
twitter
facebook
profile_picture
created_at

alumni_degrees table has following columns,
id
alumni_id
degree
year


posts, queries table has following columns

id
author
timestamp
title
content
is_validated


student_registration table has following columns

id
full_name
email
phone
course
submitted_at
profile_pic
dob
year_of_admission

