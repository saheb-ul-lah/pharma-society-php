<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About the Centre</title>
  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet" />
  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap"
    rel="stylesheet" />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            "button-red": "rgb(174, 106, 106)",
            "button-red-hover": "rgb(150, 90, 90)",
            navy: "#0c133b",
            "button-red": "rgb(174, 106, 106)",
            "button-red-hover": "rgb(150, 90, 90)",
            "antique-white": "#FAEBD7",
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
  <!--  -->
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

  <!--  -->
  <div class="w-full px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">About the Pharmaceutical Society</h1>

    <div class="bg-white shadow-md p-6 mb-8">
      <p class="text-gray-700 leading-relaxed">
        The "Pharmaceutical Society, Dibrugarh University" was founded in 1986 in the Department of Pharmaceutical Sciences, Dibrugarh University as a professional body of pharmacy by the teachers, and students of the department. Since its establishment, the society has been serving as a professional forum for organizing various professional and socio-cultural activities. The mission of the "Pharmaceutical Society, Dibrugarh University" is the professional growth of pharmacy students and professionals through networking activities, mentorship, and access to resources that help to gain professional knowledge and abilities in various areas of the profession of pharmacy for overall professional growth. The Pharmaceutical Society also keeps a strong emphasis on helping its members by organizing educational workshops, seminars, discussions, invited talks, etc. to improve and update professional knowledge. With the goal of providing healthcare knowledge and professional help to the public and supporting public healthcare activities, the "Pharmaceutical Society, Dibrugarh University" hosts healthcare camps, counselling programmes, and various educational campaigns to spread awareness among the public for drug safety, disease prevention, and general healthcare issues.
      </p>
    </div>

    <div class="bg-white shadow-md p-6 mb-8">
      <h2 class="text-2xl font-semibold mb-4">Major Objectives</h2>
      <ul class="list-none space-y-4">
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To establish a strong connection between the alumni and current students of the Department of Pharmaceutical Sciences, Dibrugarh University.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To enhance the professional growth of pharmacy students and professionals through networking, mentorship, and access to resources.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To organize educational workshops, seminars, discussions, and invited talks that enable members to update and improve their professional knowledge and skills.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To conduct healthcare camps, counselling programs, and educational campaigns to promote public awareness about drug safety, disease prevention, and general healthcare issues.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To support public healthcare activities by providing professional assistance and healthcare knowledge to the community.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To foster a sense of community among members through the organization of various socio-cultural activities that promote teamwork and holistic development.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To encourage innovation and leadership in pharmacy education and practice by providing a platform for students and professionals to share ideas and contribute to the advancement of the field.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To uphold and promote ethical practices in the pharmacy profession for the betterment of society and public health.</span>
        </li>
        <li class="flex items-start">
          <svg
            class="w-6 h-6 text-green-500 mr-2 flex-shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-gray-700">To build collaborative networks with other professional bodies and organizations for mutual growth and to stay at the forefront of advancements in the pharmacy profession.</span>
        </li>
      </ul>
    </div>

    <div class="bg-white shadow-md p-6">
      <h2 class="text-2xl font-semibold mb-4">About The Department of Pharmaceutical Sciences</h2>
      <p class="text-gray-700">
        The Department of Pharmaceutical Sciences was established at Dibrugarh University in 1983 as the first establishment for offering Four years integrated Bachelor Degree course in Pharmacy (B. Pharm.) in entire North East India with the intake of students from the seven North East States of India (Assam, Meghalaya, Manipur, Mizoram, Tripura, Arunachal Pradesh and Nagaland). The initial establishment financial assistance came from the NEC (North Eastern Council), Shillong. The recurring expenditure is borne by the respective North East States on pro-rata basis. The Department, since its establishment, is actively working for the development of Pharmacy Education and Research activities in North East India.
        The Department introduced the Post Graduate courses in Pharmacy (M. Pharm.) from 2002 to provide specialized higher studies and R & D activities in pharmaceutical sector. All the courses conducted in this Department are approved by the PCI. The alumni of this Department are engaged in various pharmaceutical industries, Pharmaceutical academic institutions, Government Regulatory affairs, R & D activities of Drugs and Pharmaceuticals, and as Pharmacy professional in Govt. Health & F.W. Department, Health care professional in various State and National organizations, and serving in various capacities within and outside India.

      </p>
    </div>

    <div class="bg-white shadow-md p-6">
      <h2 class="text-2xl font-semibold mb-4">Objectives of The Department of Pharmaceutical Sciences</h2>
      <p class="text-gray-700">
        The primary objective of the Department of Pharmaceutical Sciences, Dibrugarh University is to impart quality Pharmacy Education to produce pharmacy professionals for serving the country in different Government and private pharmaceutical sectors in particular and to serve the whole human society in general. The Department has been working continuously to cater the need of pharmacy professionals in modern pharmaceutical production sectors (API and Formulation Production, QC/QA), Drug Regulatory Administration, Preservation, Distribution, Sale of Drugs and Pharmaceuticals, Patient Counselling, and Research Organizations (Discovery, Design and Development of Drugs and Pharmaceuticals).
        The Department also aims for Pharmaceutical Research and Development activities in North East India by utilizing the enormous natural Pharmaceutical potential of this region.


      </p>
    </div>
  </div>
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
            <button id="donateBtn" class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-navy px-6 py-3 rounded-lg text-lg font-bold shadow-lg transition duration-300 transform hover:scale-105">
              Donate Us
            </button>
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
  <!-- Donation Modal -->
  <div id="donationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <h3 class="text-2xl leading-6 font-bold text-navy mb-4">Donation Information</h3>
        <div class="mt-2 px-7 py-3">
          <p class="text-md text-gray-700 mb-2">
            <span class="font-semibold">Account Name:</span> M/S Pharmaceutical Society
          </p>
          <p class="text-md text-gray-700 mb-2">
            <span class="font-semibold">Account Number:</span> 9940000100006375
          </p>
          <p class="text-md text-gray-700 mb-2">
            <span class="font-semibold">IFS code:</span> PUNB0994000
          </p>
          <p class="text-md text-gray-700">
            <span class="font-semibold">Branch:</span> Punjab National Bank, Dibrugarh University
          </p>
        </div>
        <div class="items-center px-4 py-3">
          <button id="closeModal" class="px-4 py-2 bg-navy text-white text-lg font-bold rounded-md w-full shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
  <!--  -->
  <!--  -->
  <script>
    const donateBtn = document.getElementById('donateBtn');
    const donationModal = document.getElementById('donationModal');
    const closeModal = document.getElementById('closeModal');

    donateBtn.addEventListener('click', () => {
      donationModal.classList.remove('hidden');
    });

    closeModal.addEventListener('click', () => {
      donationModal.classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
      if (e.target === donationModal) {
        donationModal.classList.add('hidden');
      }
    });

    // Toggle mobile menu
    document
      .getElementById("navbar-toggle")
      .addEventListener("click", function() {
        document.getElementById("navbar-menu").classList.toggle("hidden");
      });

    // Set active link
    function setActiveLink(link) {
      document
        .querySelectorAll(".nav-link")
        .forEach((el) =>
          el.classList.remove(
            "active",
            "text-yellow-300",
            "bg-blue-600",
            "font-semibold"
          )
        );
      link.classList.add(
        "active",
        "text-yellow-300",
        "bg-blue-600",
        "font-semibold"
      );
    }

    // Add click event listeners to nav links
    document.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", function(event) {
        event.preventDefault();
        setActiveLink(this);
        const href = this.getAttribute("href");
        if (href) window.location.href = href;
      });
    });

    // Toggle auth button
    document
      .getElementById("auth-button")
      .addEventListener("click", function() {
        this.textContent =
          this.textContent.trim() === "Join us" ? "Log Out" : "Join us";
      });
  </script>
  <!--  -->
</body>

</html>