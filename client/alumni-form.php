<?php
session_start();
if (!isset($_SESSION['email'])) {
    $redirect_url = 'login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
    header("Location: $redirect_url");
    exit();
}
include('includes/db_connect.php'); // Ensure this file has proper connection details

// Ensure connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch the user's email from the session
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Check if the user has already filled the form
if ($user_email) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM alumni_registration WHERE email = ?");
  $stmt->bind_param("s", $user_email);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  // If the count is greater than 0, the form has already been filled
  if ($count > 0) {
    echo "<script>alert('You have already filled out the registration form.'); window.location.href = './index.php';</script>";
    exit(); // Stop further execution
  }
}

// Proceed to show the registration form if the user hasn't filled it out
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pharma Society Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
      animation: fadeIn 0.5s ease-in-out;
    }
  </style>

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
  <!--  -->
  <style>
    * {
      font-family: montserrat;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen">
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
  <div class="container mx-auto max-w-3xl bg-white shadow-lg rounded-lg overflow-hidden p-6 mt-6 mb-6 fade-in">
    <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600 border-b-2 border-indigo-600 pb-2">Pharmaceutical
      Society Alumni Registration Form</h1>
    <p class="text-gray-600 mb-8 text-center font-bold ">Please fill out the form with your correct information.</p>

    <form id="registrationForm" class="space-y-8" enctype="multipart/form-data">
      <section>
        <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Personal Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Full Name *</label>
            <input type="text" id="fullName" name="fullName" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Date of Birth *</label>
            <input type="date" id="dob" name="dob" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 font-bold">Gender *</label>
            <div class="flex space-x-4">
              <label class="inline-flex items-center">
                <input type="radio" name="gender" value="male" required class="form-radio text-indigo-600">
                <span class="ml-2">Male</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="gender" value="female" required class="form-radio text-indigo-600">
                <span class="ml-2">Female</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="gender" value="other" required class="form-radio text-indigo-600">
                <span class="ml-2">Other</span>
              </label>
            </div>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Email *</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user_email); ?>" readonly
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Contact Number *</label>
            <input type="tel" id="phone" name="phone" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div class="md:col-span-2">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Address *</label>
            <textarea id="address" name="address" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              rows="3"></textarea>
          </div>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Association with the Department</h2>
        <div id="degreeEntries">
          <!-- Degree entries will be dynamically added here -->
        </div>
        <button type="button" id="addDegree"
          class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300">Add
          Another Degree</button>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Career Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="jobTitle" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Current Job
              Title</label>
            <input type="text" id="jobTitle" name="jobTitle"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="company"
              class="block text-sm font-medium text-gray-700 mb-1 font-bold">Company/Organization</label>
            <input type="text" id="company" name="company"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="companyLocation" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Current
              Location</label>
            <input type="text" id="companyLocation" name="companyLocation"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Social Handles [Optional]</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1 font-bold">LinkedIn
              Profile</label>
            <input type="url" id="linkedin" name="linkedin"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Twitter Profile</label>
            <input type="url" id="twitter" name="twitter"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Facebook
              Profile</label>
            <input type="url" id="facebook" name="facebook"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Profile Picture *</h2>
        <div>
          <label for="profilePicture" class="block text-sm font-medium text-gray-700 mb-1 font-bold">Upload Profile
            Picture</label>
          <input type="file" id="profilePicture" name="profilePicture" accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <div id="imagePreview" class="mt-4 hidden">
            <img id="previewImage" src="#" alt="Profile Preview" class="max-w-xs rounded-md shadow-md">
          </div>
        </div>
      </section>

      <button type="submit"
        class="w-full px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300 text-lg font-semibold">Submit
        Registration</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('registrationForm');
      const degreeEntries = document.getElementById('degreeEntries');
      const addDegreeButton = document.getElementById('addDegree');
      const profilePictureInput = document.getElementById('profilePicture');
      const imagePreview = document.getElementById('imagePreview');
      const previewImage = document.getElementById('previewImage');

      let degreeCount = 0;

      function addDegreeEntry() {
        const entryDiv = document.createElement('div');
        entryDiv.className = 'degree-entry grid grid-cols-1 md:grid-cols-2 gap-6 mb-4 fade-in';
        entryDiv.innerHTML = `
      <div>
        <label for="degree-${degreeCount}" class="block text-sm font-medium text-gray-700 mb-1">Degree obtained *</label>
        <select id="degree-${degreeCount}" name="degree[]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option value="">Select a degree</option>
          <option value="B. Pharm">B. Pharm</option>
          <option value="M. Pharm">M. Pharm</option>
          <option value="B. Pharm (Practice)">B. Pharm (Practice)</option>
          <option value="PhD">PhD</option>
        </select>
      </div>
      <div>
        <label for="year-${degreeCount}" class="block text-sm font-medium text-gray-700 mb-1">Year of degree obtained *</label>
        <input type="number" id="year-${degreeCount}" name="year[]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>
    `;

        if (degreeCount > 0) {
          const removeButton = document.createElement('button');
          removeButton.textContent = 'Remove';
          removeButton.className = 'mt-2 px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300';
          removeButton.onclick = function() {
            degreeEntries.removeChild(entryDiv);
          };
          entryDiv.appendChild(removeButton);
        }

        degreeEntries.appendChild(entryDiv);
        degreeCount++;
      }

      addDegreeEntry(); // Add initial degree entry
      addDegreeButton.addEventListener('click', addDegreeEntry);

      profilePictureInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          if (file.size > 200 * 1024) {
            alert('Image size must be less than 200KB');
            event.target.value = '';
            return;
          }
          const reader = new FileReader();
          reader.onload = function(e) {
            previewImage.src = e.target.result;
            imagePreview.classList.remove('hidden');
          };
          reader.readAsDataURL(file);
        }
      });

      form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('alumni-form-handler.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            console.log("This is the form data :", data);
            if (data.status === 'success') {
              alert(data.message);
              form.reset(); // Optionally reset the form
            } else {
              alert(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the form.');
          });
      });
    });
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