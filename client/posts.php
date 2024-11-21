<?php
session_start();
include('includes/db_connect.php');
if(!isset($_SESSION['email'])) {
  $redirect_url = 'login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
  header("Location: $redirect_url");
  exit();
}
$user_name = '';
if(isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT user_name FROM `signup-users` WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        $user_name = $row['user_name'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enhanced Posts</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .fade-in {
      animation: fadeIn 0.3s ease-in-out;
    }
  </style>



  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'button-red': 'rgb(174, 106, 106)',
            'button-red-hover': 'rgb(150, 90, 90)',
            'navy': '#0c133b',
            'button-red': 'rgb(174, 106, 106)',
            'button-red-hover': 'rgb(150, 90, 90)',
            'antique-white': '#FAEBD7'
          },
          fontFamily: {
            montserrat: ['Montserrat', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    * {
      font-family: montserrat;
    }
  </style>
  <style>
    /* Join us / Log Out button styling */
    .auth-button {
      font-family: "Montserrat", sans-serif;
      background-color: rgb(174, 106, 106);
      color: antiquewhite;
      border: none;
      padding: 8px 10px;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .auth-button:hover {
      background-color: rgb(150, 90, 90);
    }
  </style>
</head>

<body class="bg-gray-100">

  <nav class="sticky top-0 z-50 bg-navy py-3 px-6 shadow-lg">
    <div class="container mx-auto flex flex-wrap items-center justify-between">
      <a href="./index.php" class="flex items-center">
        <img src="https://ccsaalumni.in/static/media/du.ac81f37e7c52c0eb3d53.png" alt="DU Logo" class="w-12 h-12 rounded-full mr-3">
        <span class="text-xl text-antique-white font-bold">Pharmaceutical Society</span>
      </a>

      <button id="navbar-toggle" class="lg:hidden text-antique-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>

      <div id="navbar-menu" class="hidden lg:flex lg:items-center w-full lg:w-auto mt-4 lg:mt-0">
        <ul class="flex flex-col lg:flex-row lg:ml-auto space-x-4 items-center">
          <li><a href="./index.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Home</a></li>
          <li><a href="./alumni.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Alumni</a></li>
          <li><a href="./student.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Students</a></li>
          <li><a href="./about.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">About</a></li>
          <li><a href="./news-events.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">News and Events</a></li>
          <?php if (isset($_SESSION['email'])): ?>
            <li><a href="./posts.php" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Posts</a></li>
            <li class="relative group">
              <a href="#" class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Register</a>
              <ul class="absolute hidden group-hover:block bg-navy mt-1 rounded-md shadow-lg">
                <li><a href="./alumni-form.php" class="block px-4 py-2 text-antique-white hover:bg-blue-600 hover:text-yellow-300 transition duration-300 ease-in-out">Alumni Form</a></li>
                <li><a href="./student-form.php" class="block px-4 py-2 text-antique-white hover:bg-blue-600 hover:text-yellow-300 transition duration-300 ease-in-out">Student Form</a></li>
              </ul>
            </li>
            <li><a href="./profile.php" class="nav-link"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ-l3onxJrLVYB8Ak7aKCYcOznSKyaPz1P8Q&s" alt="Profile pic" class="w-10 h-10 rounded-full"></a></li>
            <li><button onclick="window.location.href='logout.php'" class="bg-button-red text-antique-white px-4 py-2 rounded-full hover:bg-button-red-hover transition duration-300">Log Out</button></li>
          <?php else: ?>
            <li><button onclick="window.location.href='login.php'" class="bg-button-red text-antique-white px-4 py-2 rounded-full hover:bg-button-red-hover transition duration-300">Join us</button></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Code -->
  <!-- Updated Main Code -->
  <div id="posts-container" class="m-5 rounded-2xl bg-gray-50 shadow-lg p-5 relative min-h-screen">
    <div id="posts-header" class="flex justify-between mb-5 gap-2">
      <button id="alumni-tab"
        class="flex-1 text-center py-3 cursor-pointer font-medium text-gray-700 transition-all duration-300 ease-in-out rounded-lg bg-aliceblue hover:bg-slate-500 hover:text-antique-white active:scale-95">
        Alumni Posts
      </button>
      <button id="student-tab"
        class="flex-1 text-center py-3 cursor-pointer font-medium text-gray-700 transition-all duration-300 ease-in-out rounded-lg bg-aliceblue hover:bg-slate-500 hover:text-antique-white active:scale-95">
        Student Queries
      </button>
    </div>
    <div id="posts-content" class="p-5">
      <!-- Content dynamically inserted -->
    </div>
    <button id="create-button"
      class="fixed bottom-8 right-8 bg-blue-500 text-white border-none rounded-full px-6 py-3 text-lg cursor-pointer flex items-center justify-center shadow-lg transition-all duration-300 hover:bg-blue-600 active:scale-95">
      <i class="fas fa-pen mr-2"></i>
      <span>Create your post</span>
    </button>
  </div>

  <div id="create-form-overlay"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-2xl w-4/5 max-w-2xl shadow-2xl">
      <h2 id="form-title" class="text-2xl font-bold mb-4">Create a New Post</h2>
      <form id="create-form">
        <input type="text" id="post-title" name="title" placeholder="Title"
          class="w-full p-2 mb-4 rounded border border-gray-300 text-lg" required>
        <textarea id="post-content" name="content" placeholder="Content"
          class="w-full p-2 mb-4 rounded border border-gray-300 text-lg min-h-[150px] resize-vertical"
          required></textarea>
        <div class="flex justify-end gap-2">
          <button type="submit"
            class="bg-blue-500 text-white border-none rounded px-5 py-2 cursor-pointer text-lg transition-colors duration-300 hover:bg-blue-600">Post</button>
          <button type="button" id="cancel-button"
            class="bg-red-500 text-white border-none rounded px-5 py-2 cursor-pointer text-lg transition-colors duration-300 hover:bg-red-600">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const postsContent = document.getElementById('posts-content');
    const alumniTab = document.getElementById('alumni-tab');
    const studentTab = document.getElementById('student-tab');
    const createButton = document.getElementById('create-button');
    const createFormOverlay = document.getElementById('create-form-overlay');
    const createForm = document.getElementById('create-form');
    const cancelButton = document.getElementById('cancel-button');
    const postTitleInput = document.getElementById('post-title');
    const postContentInput = document.getElementById('post-content');
    const formTitle = document.getElementById('form-title');

    let activeTab = 'alumni';

    function fetchPosts() {
      fetch('posts_and_queries_manager.php?action=fetch&tab=' + activeTab)
        .then(response => response.json())
        .then(data => {
          // Sort posts or queries by timestamp (latest to oldest)
          data.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
          renderPosts(data);
        });
    }


    function renderPosts(items) {
  if (items.length === 0) {
    postsContent.innerHTML = `
        <div class="text-center text-gray-500 p-5">
            <p>No ${activeTab === 'alumni' ? 'posts' : 'queries'} available</p>
        </div>
    `;
    return;
  }

  // Embed the PHP variable as a JavaScript string
  const userEmail = "<?php echo addslashes($user_email); ?>"; // Escape quotes if necessary

  postsContent.innerHTML = items.map(item => `
    <div class="bg-white rounded-lg shadow-md p-5 mb-5">
        <div class="flex items-center text-sm text-gray-600">
            <strong>${item.author}&nbsp;</strong>
            <strong>(${item.email})</strong>
            <span class="ml-2 text-gray-400">${new Date(item.timestamp).toLocaleString()}</span>
        </div>
        <h4 class="text-xl font-semibold my-2 text-gray-800">${item.title}</h4>
        <p class="text-gray-700">${item.content}</p>
        
        <div class="flex gap-2 mt-3">
          ${item.email === userEmail ? `
            <button class="edit-button bg-yellow-500 text-white px-4 py-2 rounded text-sm" data-id="${item.id}">Edit</button>
            <button class="delete-button bg-red-500 text-white px-4 py-2 rounded text-sm" data-id="${item.id}">Delete</button>
          ` : ''}
        </div>
    </div>
  `).join('');

  addListeners();
}


    function addListeners() {
      document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', () => handleDelete(button.dataset.id));
      });

      document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => showCreateForm(true, button.dataset.id));
      });
    }

    function setActiveTab(tab) {
      activeTab = tab;
      fetchPosts();

      // Update active tab styles
      if (tab === 'alumni') {
        alumniTab.classList.add('bg-slate-300', 'text-grey', 'font-bold');
        studentTab.classList.remove('bg-slate-300', 'text-grey', 'font-bold');
        createButton.querySelector('span').textContent = 'Create your post';
      } else {
        studentTab.classList.add('bg-slate-300', 'text-grey', 'font-bold');
        alumniTab.classList.remove('bg-slate-300', 'text-grey', 'font-bold');
        createButton.querySelector('span').textContent = 'Create your query';
      }
    }


    function showCreateForm(isEdit = false, id = null) {
      createFormOverlay.classList.remove('hidden');
      if (isEdit) {
        fetch(`posts_and_queries_manager.php?action=get&id=${id}&tab=${activeTab}`)
          .then(response => response.json())
          .then(data => {
            postTitleInput.value = data.title;
            postContentInput.value = data.content;
            formTitle.textContent = 'Edit Post';
            createForm.onsubmit = e => handleEdit(e, id);
          });
      } else {
        formTitle.textContent = 'Create New Post';
        createForm.onsubmit = handleSubmit;
      }
    }

    function hideCreateForm() {
      createFormOverlay.classList.add('hidden');
      postTitleInput.value = '';
      postContentInput.value = '';
    }

    function handleSubmit(e) {
      e.preventDefault();
      const formData = new FormData(createForm);
      formData.append('action', 'create');
      formData.append('tab', activeTab);

      fetch('posts_and_queries_manager.php', {
        method: 'POST',
        body: formData,
      }).then(() => {
        hideCreateForm();
        fetchPosts();
      });
    }

    function handleEdit(e, id) {
      e.preventDefault();
      const formData = new FormData(createForm);
      formData.append('action', 'update');
      formData.append('id', id);
      formData.append('tab', activeTab);

      fetch('posts_and_queries_manager.php', {
        method: 'POST',
        body: formData,
      }).then(() => {
        hideCreateForm();
        fetchPosts();
      });
    }

    function handleDelete(id) {
      fetch(`posts_and_queries_manager.php?action=delete&id=${id}&tab=${activeTab}`)
        .then(() => fetchPosts());
    }

    alumniTab.addEventListener('click', () => setActiveTab('alumni'));
    studentTab.addEventListener('click', () => setActiveTab('student'));
    createButton.addEventListener('click', () => showCreateForm());
    cancelButton.addEventListener('click', hideCreateForm);

    // Initial render
    setActiveTab('alumni');
  </script>



  <!-- Footer -->
  <div class="font-montserrat bg-antiquewhite">
    <footer class="text-center text-lg-start text-muted bg-antiquewhite overflow-hidden">
      <!-- Social Media Links -->
      <section class="flex justify-center items-center p-4 border-b border-gray-300">
        <div class="hidden lg:flex items-center text-lg font-bold text-navy mx-10">
          Get connected with us on social networks:
        </div>
        <div class="flex space-x-4 text-2xl text-gray-700">
          <a href="https://www.facebook.com/ducsjmc/" target="_blank"><i class="fab fa-facebook"></i></a>
          <a href="https://twitter.com/DUCSJMC" target="_blank"><i class="fab fa-twitter"></i></a>
          <a href="https://maps.app.goo.gl/hVm5jknh8hpqxqP88" target="_blank"><i class="fab fa-google"></i></a>
          <a href="https://www.instagram.com/dumasscomm/" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/school/dibrugarh-university-dibrugarh/?originalSubdomain=in"
            target="_blank">
            <i class="fab fa-linkedin"></i>
          </a>
        </div>
      </section>

      <!-- Footer Links -->
      <section class="container mx-auto mt-5 text-center lg:text-left">
        <div class="flex flex-wrap">
          <!-- About Section -->
          <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <h6 class="uppercase font-bold text-navy mb-4 flex items-center text-lg">
              <i class="fas fa-university mr-2"></i> Pharmaceutical Society,
              Dibrugarh University
            </h6>
            <p class="text-base font-medium text-navy">
              &copy; Pharmaceutical Society
            </p>
          </div>

          <!-- Important Links -->
          <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-6 lg:mb-0">
            <h6 class="uppercase font-bold text-navy mb-4 text-lg">
              Important Links
            </h6>
            <ul class="space-y-2">
              <li>
                <a href="https://dibru.ac.in/" target="_blank"
                  class="text-gray-700 font-semibold hover:underline">Dibrugarh University</a>
              </li>
              <li>
                <a href="https://erp.dibru.work/dibru/student/login" target="_blank"
                  class="text-gray-700 font-semibold hover:underline">ERP Portal</a>
              </li>
              <li>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSewaN2-wlaET3fROMTOUrpLsG37Vb5Z-ZY_gy1XPCG7ijENhQ/viewform"
                  target="_blank" class="text-gray-700 font-semibold hover:underline">DUAA Portal</a>
              </li>
            </ul>
          </div>

          <!-- Quick Links -->
          <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-6 lg:mb-0">
            <h6 class="uppercase font-bold text-navy mb-4 text-lg">
              Quick Links
            </h6>
            <ul class="space-y-2">
              <li>
                <a href="/" class="text-gray-700 font-semibold hover:underline">Home</a>
              </li>
              <li>
                <a href="https://scribehow.com/shared/Join_CSJMC_Alumni_Association_and_Update_Profile__iAp2_DMCRyGKgzFFMkeF_A"
                  target="_blank" class="text-gray-700 font-semibold hover:underline">Website Instructions</a>
              </li>
              <li>
                <a href="/alumniform" class="text-gray-700 font-semibold hover:underline">Alumni Registration</a>
              </li>
              <li>
                <a href="https://forms.gle/b6e8wfEJtxntS8uc8" target="_blank"
                  class="text-gray-700 font-semibold hover:underline">Report an Error</a>
              </li>
            </ul>
          </div>

          <!-- Contact Section -->
          <div class="w-full lg:w-1/4 px-4">
            <h6 class="uppercase font-bold text-navy mb-4 text-lg">
              Contact
            </h6>
            <p>
              <i class="fas fa-home mr-2"></i><a href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7" target="_blank"
                class="text-gray-700 font-semibold hover:underline">Pharmaceutical Society, Dibrugarh University,
                Dibrugarh,
                Assam 786004</a>
            </p>
            <p>
              <i class="fas fa-envelope mr-2"></i><a href="mailto:pharmsociety@dibru.ac.in"
                class="text-gray-700 font-semibold hover:underline">pharmsociety@dibru.ac.in</a>
            </p>
          </div>
        </div>
      </section>

      <!-- Footer Bottom -->
      <div class="text-center py-3 bg-navy text-white mt-6">
        Developed By:
        <a href="#" target="_blank" class="font-bold hover:underline">Digital Solution Cell</a>
      </div>
    </footer>
  </div>

  <!--  -->
  <script>
    // Toggle mobile menu
    document.getElementById('navbar-toggle').addEventListener('click', function() {
      document.getElementById('navbar-menu').classList.toggle('hidden');
    });

    // Set active link
    function setActiveLink(link) {
      document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active', 'text-yellow-300', 'bg-blue-600', 'font-semibold'));
      link.classList.add('active', 'text-yellow-300', 'bg-blue-600', 'font-semibold');
    }

    // Add click event listeners to nav links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function(event) {
        event.preventDefault();
        setActiveLink(this);
        const href = this.getAttribute('href');
        if (href) window.location.href = href;
      });
    });

    // Toggle auth button
    document.getElementById('auth-button').addEventListener('click', function() {
      this.textContent = this.textContent.trim() === 'Join us' ? 'Log Out' : 'Join us';
    });
  </script>
  <!--  -->
</body>

</html>