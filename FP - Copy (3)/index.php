<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="index.php"><i class="fas fa-bus"></i> BUROQ TRANSPORT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="services.php"><i class="fas fa-concierge-bell"></i> Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php"><i class="fas fa-user-circle"></i> Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>

    <style>
        body {
          background-color: #eef2f7;
        }
        .navbar {
          position: fixed;
          top: 0;
          width: 100%;
          z-index: 2000;
          background-color: #4B569F;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
          color: #ffffff !important;
          font-weight: bold;
        }

        .nav-link:hover {
          color: black !important;
        }
        .navbar-brand:hover {
          color: black !important;
        }

        .container {
          max-width: 500px;
          margin-top: 50px;
        }
        .btn-choice {
          margin: 10px 0;
        }
        .form-container {
          display: none;
          margin-top: 20px;
          padding: 20px;
          border: 1px solid #dee2e6;
          border-radius: 10px;
          background-color: #fff;
        }

        .social-icons a {
          color: #4B569F;
          font-size: 18px;
        }

        .social-icons a:hover {
          color: #3E4687;
        }
     
    </style>
  <footer>
    <div class="container text-center py-4">
      <p class="mb-0">&copy; 2024 Buroq Trasnport. All Rights Reserved.</p>
      <div class="social-icons mt-3">
        <a href="#" class="mx-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

  </footer>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>