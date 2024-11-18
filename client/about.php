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
          <li class="relative group">
            <a href="#"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Register</a>
            <ul class="absolute hidden group-hover:block bg-navy mt-1 rounded-md shadow-lg">
              <li><a style="text-wrap: nowrap;" href="./alumni-form.php"
                  class="block px-4 py-2 text-antique-white hover:bg-blue-600 hover:text-yellow-300 transition duration-300 ease-in-out">Alumni
                  Form</a></li>
              <li><a style="text-wrap: nowrap;" href="./student-form.php"
                  class="block px-4 py-2 text-antique-white hover:bg-blue-600 hover:text-yellow-300 transition duration-300 ease-in-out">Student
                  Form</a></li>
            </ul>
          </li>

          <li><a href="./posts.php"
              class="nav-link text-antique-white px-4 py-2 rounded-md transition duration-300 ease-in-out hover:text-yellow-300 hover:bg-blue-600 font-medium">Posts</a>
          </li>

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

  <!--  -->
  <div class="w-full px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">About the Centre</h1>

    <div class="bg-white shadow-md p-6 mb-8">
      <p class="text-gray-700 leading-relaxed">
        The Centre for Studies in Journalism and Mass Communication, Dibrugarh
        University is one of the leading institutions of higher learning in
        the field of communication and media studies in India. The Centre
        offers M.A in Mass Communication (MAMC) course with a provision for
        specialization in print, electronic, new media and public affairs and
        a mandatory internship programme. With faculty trained in reputed
        institutions and well-equipped studios and computer laboratories, it
        has been successful in carving a niche for itself in the field of
        Media and Communication education since its inception in 2008. Its
        state-of-the-art infrastructure provides the students balanced inputs
        in both theory and practice of mass communication. Eminent scholars,
        journalists, filmmakers, video professionals, corporate communication
        specialists, and leading academicians constitute a panel of eminent
        visiting faculty who offer quality education to the students from
        across India and those from abroad enrolled under Indian Council for
        Cultural Relations - African Scholarship Scheme.
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
          <span class="text-gray-700">To enable the learner to develop sound theoretical knowledge and
            professional skills and competencies in media and communication
            studies.</span>
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
          <span class="text-gray-700">To train the learners with equipment and infrastructure to
            understand the converging world of communications and adapt to the
            latest developments in the field.</span>
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
          <span class="text-gray-700">To enable the learners to undergo thorough internships that
            afford them hands-on training and an opportunity to work with the
            leading professionals of the region and nation.</span>
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
          <span class="text-gray-700">To enable the learners to implement ethical behaviors in their
            own professional practice of mass communication and usage of mass
            media tools.</span>
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
          <span class="text-gray-700">To enable the learners to receive guidance from a diverse field
            of faculties with a mix of academic and professional backgrounds
            to ensure excellence in the field of communication and
            journalism.</span>
        </li>
      </ul>
    </div>

    <div class="bg-white shadow-md p-6">
      <h2 class="text-2xl font-semibold mb-4">International Collaboration</h2>
      <p class="text-gray-700">
        [Content for International Collaboration section goes here]
      </p>
    </div>
  </div>
  <!-- Footer -->
  <div class="font-montserrat bg-antiquewhite">
    <footer
      class="text-center text-lg-start text-muted bg-antiquewhite overflow-hidden">
      <!-- Social Media Links -->
      <section
        class="flex justify-center items-center p-4 border-b border-gray-300">
        <div
          class="hidden lg:flex items-center text-lg font-bold text-navy mx-10">
          Get connected with us on social networks:
        </div>
        <div class="flex space-x-4 text-2xl text-gray-700">
          <a href="https://www.facebook.com/ducsjmc/" target="_blank"><i class="fab fa-facebook"></i></a>
          <a href="https://twitter.com/DUCSJMC" target="_blank"><i class="fab fa-twitter"></i></a>
          <a href="https://maps.app.goo.gl/hVm5jknh8hpqxqP88" target="_blank"><i class="fab fa-google"></i></a>
          <a href="https://www.instagram.com/dumasscomm/" target="_blank"><i class="fab fa-instagram"></i></a>
          <a
            href="https://www.linkedin.com/school/dibrugarh-university-dibrugarh/?originalSubdomain=in"
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
            <h6
              class="uppercase font-bold text-navy mb-4 flex items-center text-lg">
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
                <a
                  href="https://dibru.ac.in/"
                  target="_blank"
                  class="text-gray-700 font-semibold hover:underline">Dibrugarh University</a>
              </li>
              <li>
                <a
                  href="https://erp.dibru.work/dibru/student/login"
                  target="_blank"
                  class="text-gray-700 font-semibold hover:underline">ERP Portal</a>
              </li>
              <li>
                <a
                  href="https://docs.google.com/forms/d/e/1FAIpQLSewaN2-wlaET3fROMTOUrpLsG37Vb5Z-ZY_gy1XPCG7ijENhQ/viewform"
                  target="_blank"
                  class="text-gray-700 font-semibold hover:underline">DUAA Portal</a>
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
                <a
                  href="/"
                  class="text-gray-700 font-semibold hover:underline">Home</a>
              </li>
              <li>
                <a
                  href="https://scribehow.com/shared/Join_CSJMC_Alumni_Association_and_Update_Profile__iAp2_DMCRyGKgzFFMkeF_A"
                  target="_blank"
                  class="text-gray-700 font-semibold hover:underline">Website Instructions</a>
              </li>
              <li>
                <a
                  href="/alumniform"
                  class="text-gray-700 font-semibold hover:underline">Alumni Registration</a>
              </li>
              <li>
                <a
                  href="https://forms.gle/b6e8wfEJtxntS8uc8"
                  target="_blank"
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
              <i class="fas fa-home mr-2"></i><a
                href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7"
                target="_blank"
                class="text-gray-700 font-semibold hover:underline">Pharmaceutical Society, Dibrugarh University, Dibrugarh,
                Assam 786004</a>
            </p>
            <p>
              <i class="fas fa-envelope mr-2"></i><a
                href="mailto:pharmsociety@dibru.ac.in"
                class="text-gray-700 font-semibold hover:underline">pharmsociety@dibru.ac.in</a>
            </p>
          </div>
        </div>
      </section>

      <!-- Footer Bottom -->
      <div class="text-center py-3 bg-navy text-white mt-6">
        Developed By:
        <a
          href="#"
          target="_blank"
          class="font-bold hover:underline">Digital Solution Cell</a>
      </div>
    </footer>
  </div>
  <!--  -->
  <!--  -->
  <script>
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