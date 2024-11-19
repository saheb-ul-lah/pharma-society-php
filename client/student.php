<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alumni Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>
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

  <div class="container mx-auto mt-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto mb-4 md:mb-0">
        <select id="year-filter" class="w-full md:w-48 p-2 border rounded" aria-label="Select Year">
          <option value="">All Years</option>
        </select>
        <select id="course-filter" class="w-full md:w-48 p-2 border rounded" aria-label="Select Course">
          <option value="">All Courses</option>
        </select>
      </div>
      <div class="flex w-full md:w-auto">
        <input id="search-input" type="text" placeholder="Search students..." class="w-full md:w-64 p-2 border rounded">
      </div>
    </div>

    <div id="students-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <!-- Student cards will be dynamically inserted here -->
    </div>
  </div>

  <script>
    const studentsGrid = document.getElementById('students-grid');
    const yearFilter = document.getElementById('year-filter');
    const courseFilter = document.getElementById('course-filter');
    const searchInput = document.getElementById('search-input');
    let studentData = []; // Store the full student data

    // Function to format date
    function formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString();
    }

    // Function to create student card
    function createStudentCard(student) {
      const card = document.createElement('div');
      card.className = 'bg-white rounded-lg shadow-md overflow-hidden';
      card.dataset.year = student.year_of_admission;
      card.dataset.course = student.course;

      // card.innerHTML = `
      //       <img src="${student.profile_pic || 'default-profile.jpg'}" alt="${student.full_name}" 
      //           class="w-full h-48 object-cover">
      //       <div class="p-4">
      //           <h3 class="font-bold text-lg">${student.full_name}</h3>
      //           <p class="text-gray-600">${student.email}</p>
      //           <p class="text-gray-600">${student.phone}</p>
      //           <p class="text-sm text-gray-500">Course: ${student.course}</p>
      //           <p class="text-sm text-gray-500">DOB: ${formatDate(student.dob)}</p>
      //           <div class="mt-2">
      //               <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-lg">
      //                   Year: ${student.year_of_admission}
      //               </span>
      //           </div>
      //           <p class="text-xs text-gray-400 mt-2">Registered: ${formatDate(student.submitted_at)}</p>
      //       </div>
      //   `;


      card.innerHTML = `
            <img src="${student.profile_pic || 'default-profile.jpg'}" alt="${student.full_name}" 
                class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-lg">${student.full_name}</h3>
                <p class="text-gray-600">${student.email}</p>
                <p class="text-md text-gray-500">Course: ${student.course}</p>
                <div class="mt-2">
                    <span class="text-md bg-blue-500 text-white px-2 py-1 rounded-lg">
                        Year: ${student.year_of_admission}
                    </span>
                </div>
            </div>
        `;
      // Add click event listener
      card.addEventListener('click', () => {
        // Redirect to details page with student_id in the query string
        window.location.href = `student-details.php?student_id=${student.id}`;
      });
      return card;

    }

    // Function to filter students
    function filterStudents() {
      const searchQuery = searchInput.value.toLowerCase();
      const selectedYear = yearFilter.value;
      const selectedCourse = courseFilter.value;

      studentsGrid.innerHTML = ''; // Clear existing cards

      studentData.forEach(student => {
        const matchesSearch =
          student.full_name.toLowerCase().includes(searchQuery) ||
          student.email.toLowerCase().includes(searchQuery) ||
          student.course.toLowerCase().includes(searchQuery);

        const matchesYear = !selectedYear || student.year_of_admission === selectedYear;
        const matchesCourse = !selectedCourse || student.course === selectedCourse;

        if (matchesSearch && matchesYear && matchesCourse) {
          studentsGrid.appendChild(createStudentCard(student));
        }
      });
    }

    // Fetch and display student data
    async function fetchStudents() {
      try {
        const response = await fetch('fetch_students.php'); // You'll need to create this PHP file
        studentData = await response.json();

        // Populate year filter
        const years = new Set(studentData.map(student => student.year_of_admission));
        years.forEach(year => {
          const option = document.createElement('option');
          option.value = year;
          option.textContent = year;
          yearFilter.appendChild(option);
        });

        // Populate course filter
        const courses = new Set(studentData.map(student => student.course));
        courses.forEach(course => {
          const option = document.createElement('option');
          option.value = course;
          option.textContent = course;
          courseFilter.appendChild(option);
        });

        // Initial display
        filterStudents();
      } catch (error) {
        console.error('Error fetching student data:', error);
      }
    }

    // Event listeners for live filtering
    searchInput.addEventListener('input', filterStudents);
    yearFilter.addEventListener('change', filterStudents);
    courseFilter.addEventListener('change', filterStudents);



    // Initial fetch
    fetchStudents();
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