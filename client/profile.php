<?php
session_start();
if (!isset($_SESSION['email'])) {
    $redirect_url = 'login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
    header("Location: $redirect_url");
    exit();
}

include('includes/db_connect.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add this function at the top to handle toast messages
function setToastMessage($message, $type = 'success')
{
    $_SESSION['toast_message'] = $message;
    $_SESSION['toast_type'] = $type;
}

$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$userData = [];
$degrees = [];

// Fetch user data from the database
if ($user_email) {
    // Fetch user data
    $stmt = $conn->prepare("SELECT id, full_name, email, phone, dob, gender, address, job_title, company, company_location, linkedin, twitter, facebook, profile_picture FROM alumni_registration WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($alumni_id, $fullName, $email, $phone, $dob, $gender, $address, $jobTitle, $company, $companyLocation, $linkedin, $twitter, $facebook, $profile_picture);
    if ($stmt->fetch()) {
        $userData = [
            'alumni_id' => $alumni_id,
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'dob' => $dob,
            'gender' => $gender,
            'address' => $address,
            'jobTitle' => $jobTitle,
            'company' => $company,
            'companyLocation' => $companyLocation,
            'linkedin' => $linkedin,
            'twitter' => $twitter,
            'facebook' => $facebook,
            'profile_picture' => $profile_picture

        ];
    }
    if (!$alumni_id) {
        echo "
    <script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
    <link rel='stylesheet' type='text/css' href='https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css'>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Toastify({
                text: 'Please fill up the registration form to access your dashboard!',
                duration: 1000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                stopOnFocus: true
            }).showToast();

            setTimeout(function () {
                window.location.href = 'alumni-form.php';
            }, 2000);
        });
    </script>
    ";
        exit();
    }


    $stmt->close();

    // Fetch degrees from the database
    $stmt = $conn->prepare("SELECT degree, year FROM alumni_degrees WHERE alumni_id = ?");
    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();
    $stmt->bind_result($degree, $year);
    while ($stmt->fetch()) {
        $degrees[] = [
            'degree' => $degree,
            'year' => $year
        ];
    }
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $jobTitle = $_POST['jobTitle'];
    $company = $_POST['company'];
    $companyLocation = $_POST['companyLocation'];
    $linkedin = $_POST['linkedin'];
    $twitter = $_POST['twitter'];
    $facebook = $_POST['facebook'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $stmt = $conn->prepare("UPDATE alumni_registration SET profile_picture = ? WHERE email = ?");
                $stmt->bind_param("ss", $dest_path, $user_email);
                if ($stmt->execute()) {
                    setToastMessage('Profile picture uploaded successfully!');
                } else {
                    setToastMessage('Error updating profile picture in database.', 'error');
                }
                $stmt->close();
            } else {
                setToastMessage('There was an error moving the uploaded file.', 'error');
            }
        } else {
            setToastMessage('Upload failed. Allowed file types: ' . implode(", ", $allowedfileExtensions), 'error');
        }
    }

    // Update user data
    if ($user_email) {
        $stmt = $conn->prepare("UPDATE alumni_registration SET full_name = ?, phone = ?, dob = ?, gender = ?, address = ?, job_title = ?, company = ?, company_location = ?, linkedin = ?, twitter = ?, facebook = ? WHERE email = ?");
        $stmt->bind_param("ssssssssssss", $fullName, $phone, $dob, $gender, $address, $jobTitle, $company, $companyLocation, $linkedin, $twitter, $facebook, $user_email);
        if ($stmt->execute()) {
            setToastMessage('Profile updated successfully!');
        } else {
            setToastMessage('Error updating profile. Please try again.', 'error');
        }
        $stmt->close();
    }

    // Handle degrees update
    if (isset($_POST['degree']) && isset($_POST['year'])) {
        $stmt = $conn->prepare("DELETE FROM alumni_degrees WHERE alumni_id = ?");
        $stmt->bind_param("i", $alumni_id);
        $stmt->execute();
        $stmt->close();

        foreach ($_POST['degree'] as $index => $degree) {
            $year = $_POST['year'][$index];
            if (!empty($degree) && !empty($year)) {
                $stmt = $conn->prepare("INSERT INTO alumni_degrees (alumni_id, degree, year) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $alumni_id, $degree, $year);
                $stmt->execute();
                $stmt->close();
            }
        }
        setToastMessage('Profile updated successfully!');
    }

    // Redirect to reload the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Profile Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        input,
        textarea,
        select {
            border: 1px solid #333;
        }

        select {
            padding: 30px 0;
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

    <div class="container mx-auto mt-8 mb-8 p-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">Alumni Profile Dashboard</h1>

        <form id="profile-form" class="space-y-6" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/3 flex flex-col items-center">
                    <img id="profile-picture" src="<?php echo htmlspecialchars($userData['profile_picture'] ?? 'placeholder.png'); ?>" alt="Profile Picture"
                        class="w-40 h-40 rounded-full border-2 object-cover mb-4">
                    <label for="profile-picture-input"
                        class="cursor-pointer bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition-all">
                        Change Picture
                    </label>
                    <input id="profile-picture-input"
                        name="profile_picture"
                        type="file"
                        accept="image/*"
                        class="hidden">
                    <!-- <div class="col-span-2">
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-md">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div> -->
                </div>

                <div class="md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="fullName" name="fullName"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="John Doe" value="<?php echo htmlspecialchars($userData['fullName'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Non-editable)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email"
                                class="bg-gray-100 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" readonly>
                        </div>
                    </div>

                    <div <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" id="phone" name="phone"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="1234567890" value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                            <input type="date" id="dob" name="dob"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                value="<?php echo htmlspecialchars($userData['dob'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-venus-mars text-gray-400"></i>
                            </div>
                            <select id="gender" name="gender"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md">
                                <option value="">Select gender</option>
                                <option value="male" <?php echo (isset($userData['gender']) && $userData['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo (isset($userData['gender']) && $userData['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo (isset($userData['gender']) && $userData['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea id="address" name="address" rows="3"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Enter your address"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="jobTitle" class="block text-sm font-medium text-gray-700 mb-1">Current Job Title</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <input type="text" id="jobTitle" name="jobTitle"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Pharmacist" value="<?php echo htmlspecialchars($userData['jobTitle'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company/Organization</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" id="company" name="company"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="ABC Pharmacy" value="<?php echo htmlspecialchars($userData['company'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="companyLocation" class="block text-sm font-medium text-gray-700 mb-1">Current Location</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-pin text-gray-400"></i>
                            </div>
                            <input type="text" id="companyLocation" name="companyLocation"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="New York, USA" value="<?php echo htmlspecialchars($userData['companyLocation'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn Profile</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fab fa-linkedin text-gray-400"></i>
                            </div>
                            <input type="url" id="linkedin" name="linkedin"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="https://www.linkedin.com/in/johndoe" value="<?php echo htmlspecialchars($userData['linkedin'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter Profile</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fab fa-twitter text-gray-400"></i>
                            </div>
                            <input type="url" id="twitter" name="twitter"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="https://twitter.com/johndoe" value="<?php echo htmlspecialchars($userData['twitter'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook Profile</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fab fa-facebook text-gray-400"></i>
                            </div>
                            <input type="url" id="facebook" name="facebook"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="https://www.facebook.com/johndoe" value="<?php echo htmlspecialchars($userData['facebook'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Degrees</h2>
                <div id="degree-container">
                    <?php foreach ($degrees as $index => $degree): ?>
                        <div class="flex items-center mb-4">
                            <input type="text" name="degree[]" placeholder="Degree" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mr-2" value="<?php echo htmlspecialchars($degree['degree']); ?>">
                            <input type="text" name="year[]" placeholder="Year" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?php echo htmlspecialchars($degree['year']); ?>">
                            <button type="button" class="ml-2 text-red-500" onclick=" this.parentElement.remove();">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded" onclick="addDegree()">Add Degree</button>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 font-montserrat bg-antiquewhite">
        <footer class="text-center text-lg-start text-muted bg-antiquewhite overflow-hidden">
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

            <section class="container mx-auto mt-5 text-center lg:text-left">
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
                        <h6 class="uppercase font-bold text-navy mb-4 flex items-center text-lg">
                            <i class="fas fa-university mr-2"></i> Pharmaceutical Society,
                            Dibrugarh University
                        </h6>
                        <p class="text-base font-medium text-navy">
                            &copy; Pharmaceutical Society
                        </p>
                    </div>

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
                                    target="_blank" class=" text-gray-700 font-semibold hover:underline">Website Instructions</a>
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

                    <div class="w-full lg:w-1/4 px-4">
                        <h6 class="uppercase font-bold text-navy mb-4 text-lg">
                            Contact
                        </h6>
                        <p>
                            <i class="fas fa-home mr-2"></i><a href="https://maps.app.goo.gl/wWHJG7H3w6JL9xUZ7"
                                target="_blank" class="text-gray-700 font-semibold hover:underline">Pharmaceutical
                                Society, Dibrugarh University, Dibrugarh,
                                Assam 786004</a>
                        </p>
                        <p>
                            <i class="fas fa-envelope mr-2"></i><a href="mailto:pharmsociety@dibru.ac.in"
                                class="text-gray-700 font-semibold hover:underline">pharmsociety@dibru.ac.in</a>
                        </p>
                    </div>
                </div>
            </section>

            <div class="text-center py-3 bg-navy text-white mt-6">
                Developed By:
                <a href="#" target="_blank" class="font-bold hover:underline">Digital Solution Cell</a>
            </div>
        </footer>
    </div>

    <script>
        function addDegree() {
            const degreeContainer = document.getElementById('degree-container');
            const newDegreeDiv = document.createElement('div');
            newDegreeDiv.className = 'flex items-center mb-4';
            newDegreeDiv.innerHTML = `
                <input type="text" name="degree[]" placeholder="Degree" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mr-2">
                <input type="text" name="year[]" placeholder="Year" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                <button type="button" class="ml-2 text-red-500" onclick="this.parentElement.remove();">Remove</button>
            `;
            degreeContainer.appendChild(newDegreeDiv);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profile-form');
            const profilePictureInput = document.getElementById('profile-picture-input');
            const profilePicture = document.getElementById('profile-picture');

            // Handle profile picture change
            profilePictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePicture.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
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
        });
    </script>
    <script>
        <?php if (isset($_SESSION['toast_message'])): ?>
            Toastify({
                text: "<?php echo $_SESSION['toast_message']; ?>",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "<?php echo $_SESSION['toast_type'] === 'error' ? '#ff6b6b' : '#51cf66' ?>",
                stopOnFocus: true
            }).showToast();

            <?php
            // Clear the toast message from session
            unset($_SESSION['toast_message']);
            unset($_SESSION['toast_type']);
            ?>
        <?php endif; ?>
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "button-red": "rgb(174, 106, 106)",
                        "button-red-hover": "rgb(150, 90, 90)",
                        navy: "#0c133b",
                        "antique-white": "#FAEBD7",
                    },
                    fontFamily: {
                        montserrat: ["Montserrat", "sans-serif"],
                    },
                },
            },
        };
    </script>
</body>

</html>