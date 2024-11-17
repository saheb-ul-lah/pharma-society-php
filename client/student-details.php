<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alumni Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

  <!-- Nav and footer css and js  -->
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

<body class="bg-gray-100 min-h-screen">
<nav class="sticky top-0 z-50 bg-navy py-3 px-6 shadow-lg">
    <div class="container mx-auto flex flex-wrap items-center justify-between">
      <!-- Logo and Title -->
      <a href="./index.php" class="flex items-center">
        <img src="https://ccsaalumni.in/static/media/du.ac81f37e7c52c0eb3d53.png" alt="DU Logo"
          class="w-12 h-12 rounded-full mr-3">
        <span class="text-xl text-antique-white font-bold">Pharmaceutical Society</span>
      </a>

      <!-- Navbar Toggle for Mobile -->
      <button id="navbar-toggle" class="lg:hidden text-antique-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
          </path>
        </svg>
      </button>

      <!-- Navbar Menu -->
      <div id="navbar-menu" class="hidden lg:flex lg:items-center w-full lg:w-auto mt-4 lg:mt-0">
        <ul class="flex flex-col lg:flex-row lg:ml-auto space-x-4 items-center">
          <li><a href="./index.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Home</a>
          </li>
          <li><a href="./alumni.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Alumni</a>
          </li>
          <li><a href="./student.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Students</a>
          </li>
          <li><a href="./about.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">About</a>
          </li>
          <li><a href="./news-events.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">News
              and Events</a></li>

          <!-- Dropdown Menu for Forms -->
          <?php if (isset($_SESSION['email'])): ?>
                    <li class="nav-item"><a class="nav-link" href="./posts.php" onclick="setActiveLink(this)">Posts</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Forms
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./alumni-form.php" onclick="setActiveLink(this)">Alumni Form</a></li>
                            <li><a class="dropdown-item" href="./student-form.php" onclick="setActiveLink(this)">Student Form</a></li>
                        </ul>
                    </li>
          <?php endif; ?>
          <!-- Profile Image -->
         

        <!-- Join Us Button -->
        <?php if (isset($_SESSION['email'])): ?>
              <button class="auth-button ms-3" onclick="window.location.href='logout.php'">Log Out</button>
              <li class="nav-item"><a class="nav-link" href="./profile.php" onclick="setActiveLink(this)"><img
                style="position: absolute;top: 20px;right: 60px; height: 40px; width:40px; border-radius: 50%;"
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ-l3onxJrLVYB8Ak7aKCYcOznSKyaPz1P8Q&s"
                alt="Profile pic"></a></li>
          <?php else: ?>
              <button class="auth-button ms-3" onclick="window.location.href='login.php'">Join us</button>
          <?php endif; ?>
          </ul>

      </div>
    </div>
  </nav>

  <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <h1 class="text-2xl font-bold text-center py-4 bg-gray-200">Student Details</h1>
    <div class="flex flex-col md:flex-row">
      <div class="md:w-1/3 p-4 flex flex-col items-center">
        <img id="profileImage" alt="Student Profile" class="w-48 h-48 rounded-full object-cover bg-indigo-600">
      </div>
      <div class="md:w-2/3 p-4">
        <div id="detailsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Details will be dynamically inserted here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    // Function to create a detail element
    function createDetailElement(key, value) {
      const detailDiv = document.createElement('div');
      detailDiv.className = 'bg-amber-50 p-2 rounded';
      detailDiv.innerHTML = `
            <span class="font-semibold">${key.replace(/_/g, ' ').toUpperCase()}:</span>
            <span class="ml-2">${value}</span>
        `;
      return detailDiv;
    }

    // Fetch and display student details
    async function fetchStudentDetails() {
      const params = new URLSearchParams(window.location.search);
      const student_id = params.get('student_id');

      if (!student_id) {
        alert("No student ID provided in the URL.");
        return;
      }

      try {
        const response = await fetch(`fetch_student_details.php?student_id=${student_id}`);
        const data = await response.json();

        if (data.error) {
          alert(data.error);
          return;
        }

        // Set profile image
        document.getElementById('profileImage').src = data.profile_pic || 'https://via.placeholder.com/150';

        // Fields to exclude from the details
        const excludeFields = ['id', 'phone', 'submitted_at', 'profile_pic'];

        // Populate other details dynamically
        const detailsContainer = document.getElementById('detailsContainer');
        detailsContainer.innerHTML = ''; // Clear existing details
        Object.entries(data).forEach(([key, value]) => {
          if (!excludeFields.includes(key)) { // Skip excluded fields
            detailsContainer.appendChild(createDetailElement(key, value));
          }
        });
      } catch (error) {
        console.error('Error fetching student details:', error);
      }
    }

    // Fetch student details on page load
    fetchStudentDetails();
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
  <!--  -->
  <script>
    // Toggle mobile menu
    document.getElementById('navbar-toggle').addEventListener('click', function () {
      document.getElementById('navbar-menu').classList.toggle('hidden');
    });

    // Set active link
    function setActiveLink(link) {
      document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active', 'text-yellow-300', 'bg-blue-600', 'font-semibold'));
      link.classList.add('active', 'text-yellow-300', 'bg-blue-600', 'font-semibold');
    }

    // Add click event listeners to nav links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        setActiveLink(this);
        const href = this.getAttribute('href');
        if (href) window.location.href = href;
      });
    });

    // Toggle auth button
    document.getElementById('auth-button').addEventListener('click', function () {
      this.textContent = this.textContent.trim() === 'Join us' ? 'Log Out' : 'Join us';
    });
  </script>
  <!--  -->
</body>

</html>