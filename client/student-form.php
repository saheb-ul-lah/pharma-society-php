<?php
session_start();
if (!isset($_SESSION['email'])) {
    $redirect_url = 'login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
    header("Location: $redirect_url");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>


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

        body {
            display: flex;
            flex-direction: column;
        }

        form {
            width: 60vw;
            margin-left: 18vw;
        }

        @media only screen and (max-width: 600px) {
            form {
                width: 95vw;
                margin-left: 1vw;

            }
        }
    </style>
    <style>
        /* Navbar styling *
  
  /* Active and hover styles for links */


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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen ">
    <!-- Navbar -->
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
    <!-- Form Content -->
    <div id="app" class="w-full max-w-2xl pl-[1vw] pt-6">
        <div id="formContainer" class="w-full">
            <form id="studentForm" class="bg-white shadow-2xl rounded-lg px-8 pt-6 pb-8 mb-4" method="POST"
                enctype="multipart/form-data">
                <h1 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b-2 border-blue-500 pb-2">
                    Pharmaceutical Society Student Registration Form
                </h1>
                <!-- <p class="mb-8 text-center text-gray-600">Please fill out the form with your information.</p> -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-600">Personal Information</h2>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="fullName">Full Name *</label>
                        <input id="fullName" type="text" name="fullName" placeholder="Enter your full name" required
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="dob">Date of Birth *</label>
                        <input id="dob" type="date" name="dob" required
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email * [Note: Email can't be changed in future]</label>
                        <input id="email" type="email" name="email" placeholder="Enter your email address" required
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone Number *</label>
                        <input id="phone" type="tel" name="phone" placeholder="Enter your phone number" required
                            pattern="[0-9]{10}" title="Please enter a 10-digit phone number"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                </section>
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-600">Course Information</h2>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="course">Course Enrolled *</label>
                        <select id="course" name="course" required
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                            <option value="">Select a course</option>
                            <option value="B. Pharm">B. Pharm</option>
                            <option value="M. Pharm">M. Pharm</option>
                            <option value="B. Pharm (Practice)">B. Pharm (Practice)</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="yearOfAdmission">Year of
                            Admission *</label>
                        <input id="yearOfAdmission" type="number" name="yearOfAdmission"
                            placeholder="Enter year of admission" required
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                </section>

                <!-- Profile Picture -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-600">Profile Picture</h2>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="profilePic">Upload Profile
                            Picture</label>
                        <input id="profilePic" type="file" name="profilePic" accept="image/*"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                    </div>
                </section>

                <div class="flex items-center justify-center">
                    <button id="submitButton" type="submit"
                        class="bg-button-red text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out hover:bg-button-red-hover">Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("studentForm");
            const submitButton = document.getElementById("submitButton");

            // Toast function to show messages
            function showToast(message, type = 'success') {
                Toastify({
                    text: message,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    className: type === 'success' ? 'bg-green-500' : 'bg-red-500',
                    close: true,
                    style: {
                        background: type === 'success' ? 'green' : 'red',
                        borderRadius: '10px',
                        padding: '10px',
                        color: 'white',
                        textAlign: 'center',
                        fontSize: '16px'
                    }
                }).showToast();
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const course = document.getElementById('course').value;
                const dob = document.getElementById('dob').value;
                const yearOfAdmission = document.getElementById('yearOfAdmission').value;
                const profilePic = document.getElementById('profilePic').files[0];

                // Basic validation
                if (!fullName || !email || !phone || !course || !dob || !yearOfAdmission) {
                    showToast('Please fill in all required fields', 'error');
                    return;
                }

                // Phone number validation
                const phoneRegex = /^[0-9]{10}$/;
                if (!phoneRegex.test(phone)) {
                    showToast('Please enter a valid 10-digit phone number', 'error');
                    return;
                }

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showToast('Please enter a valid email address', 'error');
                    return;
                }

                // Profile picture validation (size < 200KB)
                if (profilePic) {
                    if (profilePic.size > 200 * 1024) {
                        showToast('Profile picture size must be less than 200KB', 'error');
                        return;
                    }
                }

                // Create FormData object
                const formData = new FormData(form);

                // Send form data using Fetch API
                fetch('student-form-handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showToast(data.message);
                            form.reset(); // Reset the form
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while submitting the form', 'error');
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
                    <a href="https://maps.app.goo.gl/hVm5jknh8hpqxqP88" target="_blank"><i
                            class="fab fa-google"></i></a>
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
                            <i class="fas fa-university mr-2"></i> CSJMC DU
                        </h6>
                        <p class="text-base font-medium text-navy">&copy; Centre for Studies in Journalism & Mass
                            Communication</p>
                    </div>

                    <!-- Important Links -->
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-6 lg:mb-0">
                        <h6 class="uppercase font-bold text-navy mb-4 text-lg">Important Links</h6>
                        <ul class="space-y-2">
                            <li><a href="https://dibru.ac.in/" target="_blank"
                                    class="text-gray-700 font-semibold hover:underline">Dibrugarh University</a></li>
                            <li><a href="https://erp.dibru.work/dibru/student/login" target="_blank"
                                    class="text-gray-700 font-semibold hover:underline">ERP Portal</a></li>
                            <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSewaN2-wlaET3fROMTOUrpLsG37Vb5Z-ZY_gy1XPCG7ijENhQ/viewform"
                                    target="_blank" class="text-gray-700 font-semibold hover:underline">DUAA Portal</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-6 lg:mb-0">
                        <h6 class="uppercase font-bold text-navy mb-4 text-lg">Quick Links</h6>
                        <ul class="space-y-2">
                            <li><a href="/" class="text-gray-700 font-semibold hover:underline">Home</a></li>
                            <li><a href="https://scribehow.com/shared/Join_CSJMC_Alumni_Association_and_Update_Profile__iAp2_DMCRyGKgzFFMkeF_A"
                                    target="_blank" class="text-gray-700 font-semibold hover:underline">Website
                                    Instructions</a></li>
                            <li><a href="/alumniform" class="text-gray-700 font-semibold hover:underline">Alumni
                                    Registration</a></li>
                            <li><a href="https://forms.gle/b6e8wfEJtxntS8uc8" target="_blank"
                                    class="text-gray-700 font-semibold hover:underline">Report an Error</a></li>
                        </ul>
                    </div>

                    <!-- Contact Section -->
                    <div class="w-full lg:w-1/4 px-4">
                        <h6 class="uppercase font-bold text-navy mb-4 text-lg">Contact</h6>
                        <p><i class="fas fa-home mr-2"></i><a href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7"
                                target="_blank" class="text-gray-700 font-semibold hover:underline">Centre For Studies
                                In Journalism And Mass
                                Communication, Dibrugarh University, Assam 786004</a></p>
                        <p><i class="fas fa-envelope mr-2"></i><a href="mailto:ducsjmc@gmail.com"
                                class="text-gray-700 font-semibold hover:underline">ducsjmc@gmail.com</a></p>
                    </div>
                </div>
            </section>

            <!-- Footer Bottom -->
            <div class="text-center py-3 bg-navy text-white mt-6">
                Developed By:
                <a href="https://www.linkedin.com/in/saheb-ullah-05292a258/" target="_blank"
                    class="font-bold hover:underline">Md Sahebullah</a> &
                <a href="https://www.linkedin.com/in/kalyangupta12/" target="_blank"
                    class="font-bold hover:underline">Kalyan
                    Gupta</a>
            </div>
        </footer>
    </div>
    <!--  -->
    <!-- Navbar scripts -->
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


</body>

</html>