<?php
session_start(); // Start the session at the beginning of the script
include('includes/db_connect.php'); // Ensure this file has proper connection details

// Ensure connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the session email is set, if not, redirect to login
$user_name = ''; // Initialize user_name
if (isset($_SESSION['email'])) {
    // Use prepared statements to prevent SQL injection
    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT user_name FROM `signup-users` WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and fetch the username
    if ($result && mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        $user_name = $row['user_name']; // Assign user_name from the result
    }
    // Close the statement
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pharmaceutical Society | Dibrugarh University</title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />

  <!--  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
</head>
<style>
  /* Navbar styling */

  .navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background-color: #0c133b;
    padding: 10px 20px;
  }

  /* Logo and brand styling */
  .navbar-brand img {
    border-radius: 50%;
    margin-right: 10px;
  }

  .navbar-brand span {
    font-family: "Montserrat", sans-serif;
    font-size: 1.2rem;
    color: antiquewhite;
    font-weight: 700;
  }

  /* Navbar links */
  .navbar-nav .nav-link {
    font-family: "Montserrat", sans-serif;
    color: antiquewhite;
    padding: 8px 15px;
    margin: 0 5px;
    transition: background-color 0.3s, color 0.3s;
  }

  /* Active and hover styles for links */
  .navbar-nav .nav-link.active,
  .navbar-nav .nav-link:hover {
    color: yellow;
    background-color: blue;
    font-weight: 600;
    border-radius: 10px;
  }

  /* Join us / Log Out button styling */
  .auth-button {
    font-family: "Montserrat", sans-serif;
    background-color: rgb(174, 106, 106);
    color: antiquewhite;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .auth-button:hover {
    background-color: rgb(150, 90, 90);
  }
</style>
<style>
  .carousel-caption h3 {
    text-shadow: 2px 2px 3px #000;
    font-family: "Montserrat", sans-serif;
    font-size: 40px;
    color: yellow;
  }

  .carousel-caption p {
    text-shadow: 2px 2px 3px #000;
    font-family: "Montserrat", sans-serif;
    font-size: 20px;
  }

  .btn {
    font-family: "Montserrat", sans-serif;
    border: 2px solid black;
    color: black;
    padding: 10px 15px;
    font-weight: 600;
    background-color: beige;
    border-radius: 10px;
  }
</style>
<style>
  * {
    font-family: montserrat;
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="./index.php">
        <img src="https://ccsaalumni.in/static/media/du.ac81f37e7c52c0eb3d53.png" alt="DU Logo" width="50" height="50">
        <span>Pharmaceutical Society</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="./index.php" onclick="setActiveLink(this)">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="./alumni.php" onclick="setActiveLink(this)">Alumni</a></li>
          <li class="nav-item"><a class="nav-link" href="./student.php" onclick="setActiveLink(this)">Students</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="./about.php" onclick="setActiveLink(this)">About</a></li>
          <li class="nav-item"><a class="nav-link" href="./news-events.php" onclick="setActiveLink(this)">News &
              events</a>
          </li>
          <!-- Conditionally render this link if the user is authenticated -->
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
        <!-- Authentication buttons -->
      </div>
    </div>
  </nav>

  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <!-- Duplicate the below div to get multiple slides -->
      <!-- 1st slide-->
      <div class="carousel-item active">
        <img style="height: 550px;filter: brightness(70%);" class="d-block w-100"
          src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt="First slide">
        <div class="carousel-caption d-none d-md-block">
          <h1 style="margin-bottom: 20px;">Welcome back <?php echo htmlspecialchars($user_name) ?>!</h1>
          <p style="margin-bottom: 100px;">Pharmaceutical Society's Alumni & Students Association, DU</p>
        </div>
      </div>
      <!-- 2nd slide-->
      <div class="carousel-item ">
        <img style="height: 550px;filter: brightness(70%);" class="d-block w-100"
          src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt="First slide">
        <div class="carousel-caption d-none d-md-block">
          <h1
            style="margin-bottom: 20px; animation: fadeIn 2s; font-size: 50px; font-weight: 700; color: #fff; text-shadow: 2px 2px 3px #000;">
            Welcome back <span id="username" style="color: #ff69b4;"></span>!</h1>
          <p
            style="margin-bottom: 100px; animation: fadeIn 2s; font-size: 25px; font-weight: 500; color: #fff; text-shadow: 2px 2px 3px #000;">
            Pharmaceutical Society's Alumni & Students Association, DU</p>
        </div>
      </div>
      <!-- 3rd slide-->
      <div class="carousel-item ">
        <img style="height: 550px;filter: brightness(70%);" class="d-block w-100"
          src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt="First slide">
        <div class="carousel-caption d-none d-md-block">
          <h1 style="margin-bottom: 20px;">Welcome back <span id="username"></span>!</h1>
          <p style="margin-bottom: 100px;">Pharmaceutical Society's Alumni & Students Association, DU</p>
        </div>
      </div>


    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span style="display: none;" class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span style="display: none;" class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>


  <iframe src="./includes/marquee.html" width="100%" frameborder="0"></iframe>

  <!-- About and notifications -->
  <section class="container mt-5 mb-5">
    <div class="row">
      <div class="col-md-6 mt-5">
        <h2>ABOUT US</h2>
        <p>
          The mission of the Pharmaceutical Society, Dibrugarh University, is
          to support the professional development of pharmacy students through
          networking, mentorship, and access to resources. The Society
          emphasizes educational workshops, seminars, discussions, and guest
          lectures to keep members updated with the latest advancements in
          pharmacy. In its commitment to public health, the Society organizes
          healthcare camps, counseling programs, and awareness campaigns
          focused on drug safety, disease prevention, and healthcare
          education.
        </p>
        <a href="./about.html" class="btn btn-outline-primary"
          style="font-family: Georgia, Times, 'Times New Roman', serif; background-color: #FAEBD7; color: #333; padding: 10px 20px; border: 2px solid #333; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); animation: pulse 3s infinite; font-family: Montserrat; font-weight: 600;">Read
          More</a>
      </div>
      <div class="col-md-6 mt-5">
        <h2>NOTIFICATIONS</h2>
        <div style="font-family: Georgia, Times, 'Times New Roman', serif;" id="notifications"></div>
        <a style="font-family: Georgia, Times, 'Times New Roman', serif; background-color: #FAEBD7; color: #333; padding: 10px 20px; border: 2px solid #333; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); animation: pulse 3s infinite; font-family: Montserrat; font-weight: 600;"
          href="./news-events.html" class="btn btn-outline-primary">View All</a>
      </div>
    </div>
  </section>

  <footer style="background-color: aliceblue" class=" text-lg-start text-muted">
    <!-- Social Media Links -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <div class="me-5 d-none d-lg-block">
        <span class="footer-text" style="
              font-family: Montserrat;
              font-weight: 700;
              margin-left: 110px;
            ">
          Get connected with us on social networks:
        </span>
      </div>
      <div>
        <a href="https://www.facebook.com/ducsjmc/" target="_blank" class="me-4 text-reset" style="font-size: 20px">
          <i class="fab fa-facebook"></i>
        </a>
        <a href="https://twitter.com/DUCSJMC" target="_blank" class="me-4 text-reset" style="font-size: 20px">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://maps.app.goo.gl/hVm5jknh8hpqxqP88" target="_blank" class="me-4 text-reset"
          style="font-size: 20px">
          <i class="fab fa-google"></i>
        </a>
        <a href="https://www.instagram.com/dumasscomm/" target="_blank" class="me-4 text-reset" style="font-size: 20px">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com/school/dibrugarh-university-dibrugarh/?originalSubdomain=in" target="_blank"
          class="me-4 text-reset" style="font-size: 20px">
          <i class="fab fa-linkedin"></i>
        </a>
      </div>
    </section>

    <!-- Footer Links -->
    <section class="footer-links">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <!-- About Section -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4" style="font-size: 18px; color: #0c133b">
              <i class="fas fa-university"></i> Pharmaceutical Society, Dibrugarh University
            </h6>
            <p style="font-size: 16px; font-weight: 500">
              &copy; Pharmaceutical Society
            </p>
          </div>

          <!-- Important Links -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4" style="font-size: 18px; color: #0c133b">
              Important Links
            </h6>
            <p>
              <a href="https://dibru.ac.in/" target="_blank" class="text-reset"
                style="text-decoration: none; font-weight: 600"><i class="fas fa-angle-right"></i> Dibrugarh
                University</a>
            </p>
            <p>
              <a href="https://erp.dibru.work/dibru/student/login" target="_blank" class="text-reset"
                style="text-decoration: none; font-weight: 600"><i class="fas fa-angle-right"></i> ERP Portal</a>
            </p>
            <p>
              <a href="https://docs.google.com/forms/d/e/1FAIpQLSewaN2-wlaET3fROMTOUrpLsG37Vb5Z-ZY_gy1XPCG7ijENhQ/viewform"
                target="_blank" class="text-reset" style="text-decoration: none; font-weight: 600"><i
                  class="fas fa-angle-right"></i> DUAA Portal</a>
            </p>
          </div>

          <!-- Quick Links -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4" style="font-size: 18px; color: #0c133b">
              Quick Links
            </h6>
            <p>
              <a href="/" class="text-reset" style="text-decoration: none; font-weight: 600"><i
                  class="fas fa-angle-right"></i> Home</a>
            </p>
            <p>
              <a href="https://scribehow.com/shared/Join_CSJMC_Alumni_Association_and_Update_Profile__iAp2_DMCRyGKgzFFMkeF_A"
                target="_blank" class="text-reset" style="text-decoration: none; font-weight: 600"><i
                  class="fas fa-angle-right"></i> Website Instructions</a>
            </p>
            <p>
              <a href="/alumniform" class="text-reset" style="text-decoration: none; font-weight: 600"><i
                  class="fas fa-angle-right"></i> Alumni Registration</a>
            </p>
            <p>
              <a href="https://forms.gle/b6e8wfEJtxntS8uc8" target="_blank" class="text-reset"
                style="text-decoration: none; font-weight: 600"><i class="fas fa-angle-right"></i> Report an Error</a>
            </p>
          </div>

          <!-- Contact Section -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <h6 class="text-uppercase fw-bold mb-4" style="font-size: 18px; color: #0c133b">
              Contact
            </h6>
            <p>
              <i class="fas fa-home me-3"></i><a href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7" target="_blank"
                style="text-decoration: none; font-weight: 600; color: grey">Pharmaceutical Society, Dibrugarh
                University, Dibrugarh, Assam 786004</a>
            </p>
            <p>
              <i class="fas fa-envelope me-3"></i><a href="mailto:pharmsociety@dibru.ac.in"
                style="text-decoration: none; font-weight: 600; color: grey">pharmsociety@dibru.ac.in</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Bottom -->
    <div class="text-center p-3" style="background-color: #0c133b; color: white">
      Developed By:
      <a href="#" target="_blank" class="text-reset fw-bold" style="text-decoration: none">Digital Solution Cell</a>
    </div>
  </footer>

  <script>
    // Set active link
    function setActiveLink(link) {
      document
        .querySelectorAll(".nav-link")
        .forEach((el) => el.classList.remove("active"));
      link.classList.add("active");
    }

    // Toggle between login and logout states
    function toggleAuth() {
      const button = document.querySelector(".auth-button");
      if (button.textContent.trim() === "Join us") {
        button.textContent = "Log Out";
        // Replace with login logic
      } else {
        button.textContent = "Join us";
        // Replace with logout logic
      }
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
    
      // Fetch and display notifications
      fetch("https://csjmcadmin-api.vercel.app/notifications")
        .then((response) => response.json())
        .then((data) => {
          const notificationsContainer =
            document.getElementById("notifications");
          if (data.length > 0) {
            data.forEach((notification) => {
              const notificationElement = document.createElement("p");
              notificationElement.innerHTML = `<i class="fas fa-bell"></i> ${notification.message}`;
              notificationElement.style.backgroundColor = "antiquewhite";
              notificationElement.style.padding = "5px";
              notificationElement.style.borderRadius = "10px";
              notificationsContainer.appendChild(notificationElement);
            });
          } else {
            notificationsContainer.textContent =
              "No notifications available.";
          }
        });

      // Fetch and display testimonials
      fetch("https://csjmcdualumni-api.vercel.app/users/testimonial")
        .then((response) => response.json())
        .then((data) => {
          const testimonialContainer = document.getElementById(
            "testimonial-content"
          );
          if (data.length > 0) {
            data.forEach((testimonial, index) => {
              const testimonialItem = document.createElement("div");
              testimonialItem.className = `carousel-item ${index === 0 ? "active" : ""
                }`;
              testimonialItem.innerHTML = `
              <div class="text-center">
                <img src="${testimonial.upload_profile_picture}" alt="Profile" class="rounded-circle shadow-1-strong mb-4" style="width: 150px;">
                <h5 class="mb-3">${testimonial.full_name}</h5>
                <p>${testimonial.current_job_title}, ${testimonial.company_or_organization}</p>
                <p class="text-muted"><i class="fas fa-quote-left"></i> ${testimonial.testimonial}</p>
              </div>
            `;
              testimonialContainer.appendChild(testimonialItem);
            });
          } else {
            testimonialContainer.innerHTML =
              "<p>No testimonials available.</p>";
          }
        });
    });
  </script>


  <script src="script.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
</body>

</html>