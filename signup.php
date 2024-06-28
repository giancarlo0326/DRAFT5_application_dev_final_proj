<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PUIHAHA Videos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h1 {
            color: #fff;
            font-size: 75px;
            text-align: center;
        }
        .typed-text {
            color: #82420f;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 4rem;
            }
        }
        body {
            position: relative;
        }
        .hero-content {
            position: relative;
            text-align: center;
            margin: 48px, 107.5px, 0px;
        }
    </style>
</head>
<body>
    <nav>
        <a class="home-link" href="index.php">
            <img src="https://i.postimg.cc/CxLnK8q1/PUIHAHA-VIDEOS.png" alt="Home">
        </a>
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </label>
        <label id="overlay" for="sidebar-active"></label>
        <div class="links-container">
            <label for="sidebar-active" class="close-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224-224-224Z"/></svg>
            </label>
            <a href="add.php">Add Videos</a>
            <a href="account.php">Account</a>
            <a href="viewrentals.php">View Rentals</a>
            <a href="aboutdevs.php">About the Devs</a>
            <a href="signin.php">Sign In</a>
            <a href="signup.php">Sign Up</a>
            <a href="logout.php">Log Out</a>
        </div>
    </nav>

    <div class="hero-content">
        <h1>Create <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type", {
                strings: ["Account"],
                typeSpeed: 100,
                backSpeed: 10,
            });
        </script>
    </div>

    <div class="container mt-5">
        <div class="centered-container">
            <?php
            $firstName = $lastName = $address = $username = $password = $email = $status = $zipCode = $terms = "";
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include 'database.php';

                // Sanitize and validate input fields
                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                // Check if all required fields are filled
                if (empty($_POST['first_name'])) {
                    $errors[] = "First Name is required";
                } else {
                    $firstName = sanitize_input($_POST['first_name']);
                }
                if (empty($_POST['last_name'])) {
                    $errors[] = "Last Name is required";
                } else {
                    $lastName = sanitize_input($_POST['last_name']);
                }
                if (empty($_POST['address'])) {
                    $errors[] = "Address is required";
                } else {
                    $address = sanitize_input($_POST['address']);
                }
                if (empty($_POST['username'])) {
                    $errors[] = "Username is required";
                } else {
                    $username = sanitize_input($_POST['username']);
                }
                if (!empty($_POST['password'])) {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    $errors[] = "Password is required";
                }
                if (empty($_POST['email'])) {
                    $errors[] = "Email is required";
                } else {
                    $email = sanitize_input($_POST['email']);
                }
                if (empty($_POST['status']) || $_POST['status'] == "Choose...") {
                    $errors[] = "Status is required";
                } else {
                    $status = sanitize_input($_POST['status']);
                }
                if (empty($_POST['zip_code'])) {
                    $errors[] = "Zip Code is required";
                } else {
                    $zipCode = sanitize_input($_POST['zip_code']);
                }
                if (!isset($_POST['terms'])) {
                    $errors[] = "You must agree to the terms and conditions";
                } else {
                    $terms = $_POST['terms'];
                }

                // Insert into database if no errors
                if (empty($errors)) {
                    $sql = "INSERT INTO users (first_name, last_name, address, username, password, email, status, zip_code)
                            VALUES ('$firstName', '$lastName', '$address', '$username', '$password', '$email', '$status', '$zipCode')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>You have successfully created an account.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                } else {
                    // Display errors if there are any
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }

                $conn->close();
            }
            ?>

            <form class="row g-3" method="POST" action="signup.php">
                <div class="col-md-6">
                    <label for="inputFirstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="first_name" required>
                </div>
                <div class="col-md-6">
                    <label for="inputLastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="last_name" required>
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="100 Nicanor Reyes St. Sampaloc, Manila" required>
                </div>
                <div class="col-md-6">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="inputUsername" name="username" placeholder="myusername" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Ilovetorentvideos123" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="someone@domain.com" required>
                </div>
                <div class="col-md-4">
                    <label for="inputStatus" class="form-label">Status</label>
                    <select id="inputStatus" class="form-select" name="status" required>
                        <option selected disabled>Choose...</option>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Divorced</option>
                        <option>Widowed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="inputZip" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="inputZip" name="zip_code" placeholder="1008" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="terms" required>
                        <label class="form-check-label" for="gridCheck">
                            By signing up, I hereby agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a> of PUIHAHA Videos Limited.
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Welcome to PUIHAHA Videos Limited!</p>
                    <p>By signing up, you agree to the following terms and conditions:</p>
                    <ul>
                        <li>You must provide accurate and complete information during registration.</li>
                        <li>Your account is for personal use only and should not be shared with others.</li>
                        <li>You are responsible for maintaining the confidentiality of your account information.</li>
                        <li>All rentals are subject to availability and must be returned by the due date.</li>
                        <li>Late returns may incur additional fees.</li>
                        <li>We reserve the right to modify these terms at any time without prior notice.</li>
                    </ul>
                    <p>For more detailed information, please contact our support team.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="collab">
                        <img src="https://i.postimg.cc/CxLnK8q1/PUIHAHA-VIDEOS.png" class="collab-img img-fluid">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footerBottom text-center text-md-end">
                        <h3>Application Development and Emerging Technologies - Final Project</h3>
                        <p></p>
                        <p>This website is for educational purposes only and no copyright infringement is intended.</p>
                        <p>Copyright &copy;2024; All images used in this website are from the Internet.</p>
                        <p>Designed by PIPOPIP, June 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
