<?php
session_start();
include('includes/db_connect.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_name = '';
if (isset($_SESSION['email'])) {
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
$sql = "SELECT * FROM notifications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    json_encode($notifications);
} else {
    json_encode([]);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pharmaceutical Society | Dibrugarh University</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0c133b',
                        secondary: '#ae6a6a',
                        'button-red': 'rgb(174, 106, 106)',
                        'button-red-hover': 'rgb(150, 90, 90)',
                        'navy': '#0c133b',
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
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</head>

<body class="font-montserrat">
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

    <!-- <div id="carousel" class="relative h-[550px] overflow-hidden">
        <button id="prevBtn" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="nextBtn" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div> -->


    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <div style="height: 500px;" class="relative h-[650px] overflow-hidden md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1731176497854-f9ea4dd52eb6?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <div style="border-top: 2px solid #DDDDDD;margin:10px;border-radius:10px;" class="bg-[#EEEEEE] py-2 overflow-hidden">
        <div class="animate-marquee whitespace-nowrap inline-block">
            <span class="text-lg md:text-xl lg:text-2xl text-[#B22222] mx-4">Welcome to Our Community &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|</span>
            <span class="text-lg md:text-xl lg:text-2xl text-[#B22222] mx-4">Discover Opportunities &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|</span>
            <span class="text-lg md:text-xl lg:text-2xl text-[#B22222] mx-4">Connect with Alumni and Students &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|</span>
        </div>
    </div>

    <section class="container mx-auto px-4 my-20">
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-3xl font-bold mb-4">ABOUT US</h2>
                <p class="mb-4">
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
                <a href="./about.html" class="inline-block px-6 py-3 bg-[#FAEBD7] text-gray-800 border-2 border-gray-800 rounded-lg hover:bg-gray-100 transition duration-300 shadow-lg animate-pulse font-semibold">Read More</a>
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-4">NOTICE BOARD</h2>
                <div id="notifications" class="space-y-2"></div>
                <a href="./news-events.html" class="inline-block mt-4 px-6 py-3 bg-[#FAEBD7] text-gray-800 border-2 border-gray-800 rounded-lg hover:bg-gray-100 transition duration-300 shadow-lg animate-pulse font-semibold">View All</a>
            </div>
        </div>
    </section>

    <footer class="bg-[#F0F8FF] text-gray-600">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center py-6 border-b border-gray-300">
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <span class="text-lg font-bold">Get connected with us on social networks:</span>
                </div>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/ducsjmc/" target="_blank" class="text-2xl hover:text-blue-600"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com/DUCSJMC" target="_blank" class="text-2xl hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                    <a href="https://maps.app.goo.gl/hVm5jknh8hpqxqP88" target="_blank" class="text-2xl hover:text-red-600"><i class="fab fa-google"></i></a>
                    <a href="https://www.instagram.com/dumasscomm/" target="_blank" class="text-2xl hover:text-pink-600"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/school/dibrugarh-university-dibrugarh/?originalSubdomain=in" target="_blank" class="text-2xl hover:text-blue-800"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="py-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h6 class="text-lg font-bold mb-4 text-primary">
                        <i class="fas fa-university mr-2"></i> Pharmaceutical Society, Dibrugarh University
                    </h6>
                    <p class="text-base font-medium">&copy; Pharmaceutical Society</p>
                </div>

                <div>
                    <h6 class="text-lg font-bold mb-4 text-primary">Important Links</h6>
                    <ul class="space-y-2">
                        <li><a href="https://dibru.ac.in/" target="_blank" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Dibrugarh University</a></li>
                        <li><a href="https://erp.dibru.work/dibru/student/login" target="_blank" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>ERP Portal</a></li>
                        <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSewaN2-wlaET3fROMTOUrpLsG37Vb5Z-ZY_gy1XPCG7ijENhQ/viewform" target="_blank" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Dibrugarh University Alumni Association Portal</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="text-lg font-bold mb-4 text-primary">Quick Links</h6>
                    <ul class="space-y-2">
                        <li><a href="/" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Home</a></li>
                        <li><a href="https://scribehow.com/shared/Join_CSJMC_Alumni_Association_and_Update_Profile__iAp2_DMCRyGKgzFFMkeF_A" target="_blank" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Website Instructions</a></li>
                        <li><a href="/alumniform" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Alumni Registration</a></li>
                        <li><a href="https://forms.gle/b6e8wfEJtxntS8uc8" target="_blank" class="hover:text-primary transition duration-300"><i class="fas fa-angle-right mr-2"></i>Report an Error</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="text-lg font-bold mb-4 text-primary">Contact</h6>
                    <p class="mb-2"><i class="fas fa-home mr-2"></i><a href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7" target="_blank" class="hover:text-primary transition duration-300">Pharmaceutical Society, Dibrugarh University, Dibrugarh, Assam 786004</a></p>
                    <p><i class="fas fa-envelope mr-2"></i><a href="mailto:pharmsociety@dibru.ac.in" class="hover:text-primary transition duration-300">pharmsociety@dibru.ac.in</a></p>
                </div>
            </div>
        </div>

        <div class="bg-primary text-white text-center py-4">
            Developed By:
            <a href="#" target="_blank" class="font-bold hover:underline">Digital Solution Cell</a>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            document.getElementById('navbar-menu').classList.toggle('hidden');
        });

        

        // Directly use the PHP variable for notifications
        const notifications = <?php echo json_encode($notifications) ?>

        // Display notifications
        const notificationsContainer = document.getElementById("notifications");

        if (notifications.length > 0) {
            notifications.forEach(notification => {
                const notificationElement = document.createElement("div");

                // Create title element
                const titleElement = document.createElement("h4");
                titleElement.innerHTML = `<i class="fas fa-bell mr-2"></i>${notification.title}`;
                titleElement.className = "font-bold text-lg mb-1";

                // Create message element
                const messageElement = document.createElement("p");
                messageElement.textContent = notification.message;
                messageElement.className = "text-sm text-gray-700";

                // Append title and message to the notification container
                notificationElement.appendChild(titleElement);
                notificationElement.appendChild(messageElement);

                // Style the notification container
                notificationElement.className = "bg-[#FAEBD7] p-4 mb-2 rounded-lg shadow";

                // Append the notification element to the notifications container
                notificationsContainer.appendChild(notificationElement);
            });
        } else {
            notificationsContainer.textContent = "No notifications available.";
        }

        // Infinite scroll for marquee
        const marquee = document.querySelector('.animate-marquee');
        marquee.addEventListener('animationiteration', () => {
            marquee.style.animationDuration = `${30 + Math.random() * 10}s`;
        });
    </script>
</body>

</html>
