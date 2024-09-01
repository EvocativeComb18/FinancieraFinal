<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header("Location: pages-login.html");
    exit();
}

$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener préstamos de trabajadores
$worker_loans = array();
$sql = "SELECT id, full_name, mobile_number, worker_id, nickname FROM registration WHERE id_type = 'worker'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $worker_loans[] = $row;
    }
} else {
    echo "No se encontraron trabajadores.";
}

// Obtener préstamos de clientes
$client_loans = array();
$sql = "SELECT id, first_name, client_number, loan_type, requested_amount FROM loan_information WHERE id_type = 'cliente'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $client_loans[] = $row;
    }
} else {
    echo "No se encontraron préstamos de clientes.";
}
// Obtener notificaciones
$notifications = array();
$sql = "SELECT loan_type, requested_amount, first_name, last_name, middle_name, date_of_birth, phone_number, form_fill_date FROM loan_information ORDER BY form_fill_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notifications[] = array(
            "type" => "primary",
            "title" => "Nueva Solicitud",
            "message" => "Tipo: " . $row['loan_type'] . ", Cantidad: " . $row['requested_amount'] . ", Nombre: " . $row['first_name'] . " " . $row['last_name'],
            "time" => $row['form_fill_date']
        );
    }
} else {
    $notifications[] = array(
        "type" => "primary",
        "title" => "Sin Solicitudes",
        "message" => "No hay nuevas solicitudes de crédito",
        "time" => ""
    );
}

$conn->close();
?>

<!DOCTYPE html>

<html lang="en">



<head>

  <meta charset="utf-8">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">



  <title>Dashboard - NiceAdmin Bootstrap Template</title>

  <meta content="" name="description">

  <meta content="" name="keywords">



  <!-- Favicons -->

  <link href="assets/img/favicon.png" rel="icon">

  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">



  <!-- Google Fonts -->

  <link href="https://fonts.gstatic.com" rel="preconnect">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">



  <!-- Vendor CSS Files -->

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">

  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">

  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">



  <!-- Template Main CSS File -->

  <link href="assets/css/style.css" rel="stylesheet">



  <!-- =======================================================

  * Template Name: NiceAdmin

  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/

  * Updated: Apr 20 2024 with Bootstrap v5.3.3

  * Author: BootstrapMade.com

  * License: https://bootstrapmade.com/license/

  ======================================================== -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js" defer></script>

</head>



<body>
  



  <!-- ======= Header ======= -->

  <header id="header" class="header fixed-top d-flex align-items-center">



    <div class="d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">

        <img src="assets/img/logo.png" alt="">

        <span class="d-none d-lg-block">Prestamos</span>

      </a>

      <i class="bi bi-list toggle-sidebar-btn"></i>

    </div><!-- End Logo -->



    <div class="search-bar">

      <form class="search-form d-flex align-items-center" method="POST" action="#">

        <input type="text" name="query" placeholder="Search" title="Enter search keyword">

        <button type="submit" title="Search"><i class="bi bi-search"></i></button>

      </form>

    </div><!-- End Search Bar -->



    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-primary badge-number"><?php echo count($notifications); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header">
                                You have <span><?php echo count($notifications); ?></span> new notifications
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <div id="notifications-list">
                                <?php foreach ($notifications as $notification): ?>
                                    <li class="notification-item">
                                        <i class="bi bi-exclamation-circle text-<?php echo $notification['type']; ?>"></i>
                                        <div>
                                            <h4><?php echo $notification['title']; ?></h4>
                                            <p><?php echo $notification['message']; ?></p>
                                            <p><?php echo $notification['time']; ?></p>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endforeach; ?>
                            </div>
                            <li class="dropdown-footer">
                                <a href="#">Show all notifications</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" id="profile-image">
                <span class="d-none d-md-block dropdown-toggle ps-2" id="user-name"><?php echo $user_info['full_name'] ?? 'Guest'; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6 id="profile-name"><?php echo $user_info['full_name'] ?? 'Guest'; ?></h6>
                    <span id="profile-role"><?php echo $user_info['nickname'] ?? ''; ?></span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="account-settings.html">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="help.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Need Help?</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav><!-- End Icons Navigation -->



  </header><!-- End Header -->



  <!-- ======= Sidebar ======= -->

  <aside id="sidebar" class="sidebar">



    <ul class="sidebar-nav" id="sidebar-nav">



      <li class="nav-item">

        <a class="nav-link " href="index.html">

          <i class="bi bi-grid"></i>

          <span>Dashboard</span>

        </a>

      </li><!-- End Dashboard Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">

          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>

        </a>

        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>

            <a href="components-alerts.html">

              <i class="bi bi-circle"></i><span>Alerts</span>

            </a>

          </li>

          <li>

            <a href="components-accordion.html">

              <i class="bi bi-circle"></i><span>Accordion</span>

            </a>

          </li>

          <li>

            <a href="components-badges.html">

              <i class="bi bi-circle"></i><span>Badges</span>

            </a>

          </li>

          <li>

            <a href="components-breadcrumbs.html">

              <i class="bi bi-circle"></i><span>Breadcrumbs</span>

            </a>

          </li>

          <li>

            <a href="components-buttons.html">

              <i class="bi bi-circle"></i><span>Buttons</span>

            </a>

          </li>

          <li>

            <a href="components-cards.html">

              <i class="bi bi-circle"></i><span>Cards</span>

            </a>

          </li>

          <li>

            <a href="components-carousel.html">

              <i class="bi bi-circle"></i><span>Carousel</span>

            </a>

          </li>

          <li>

            <a href="components-list-group.html">

              <i class="bi bi-circle"></i><span>List group</span>

            </a>

          </li>

          <li>

            <a href="components-modal.html">

              <i class="bi bi-circle"></i><span>Modal</span>

            </a>

          </li>

          <li>

            <a href="components-tabs.html">

              <i class="bi bi-circle"></i><span>Tabs</span>

            </a>

          </li>

          <li>

            <a href="components-pagination.html">

              <i class="bi bi-circle"></i><span>Pagination</span>

            </a>

          </li>

          <li>

            <a href="components-progress.html">

              <i class="bi bi-circle"></i><span>Progress</span>

            </a>

          </li>

          <li>

            <a href="components-spinners.html">

              <i class="bi bi-circle"></i><span>Spinners</span>

            </a>

          </li>

          <li>

            <a href="components-tooltips.html">

              <i class="bi bi-circle"></i><span>Tooltips</span>

            </a>

          </li>

        </ul>

      </li><!-- End Components Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">

          <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>

        </a>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>

            <a href="forms-elements.html">

              <i class="bi bi-circle"></i><span>Form Elements</span>

            </a>

          </li>

          <li>

            <a href="forms-layouts.html">

              <i class="bi bi-circle"></i><span>Form Layouts</span>

            </a>

          </li>

          <li>

            <a href="forms-editors.html">

              <i class="bi bi-circle"></i><span>Form Editors</span>

            </a>

          </li>

          <li>

            <a href="forms-validation.html">

              <i class="bi bi-circle"></i><span>Form Validation</span>

            </a>

          </li>

        </ul>

      </li><!-- End Forms Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">

          <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>

        </a>

        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>

            <a href="tables-general.html">

              <i class="bi bi-circle"></i><span>General Tables</span>

            </a>

          </li>

          <li>

            <a href="tables-data.html">

              <i class="bi bi-circle"></i><span>Data Tables</span>

            </a>

          </li>

        </ul>

      </li><!-- End Tables Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">

          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>

        </a>

        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>

            <a href="charts-chartjs.html">

              <i class="bi bi-circle"></i><span>Chart.js</span>

            </a>

          </li>

          <li>

            <a href="charts-apexcharts.html">

              <i class="bi bi-circle"></i><span>ApexCharts</span>

            </a>

          </li>

          <li>

            <a href="charts-echarts.html">

              <i class="bi bi-circle"></i><span>ECharts</span>

            </a>

          </li>

        </ul>

      </li><!-- End Charts Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">

          <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>

        </a>

        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>

            <a href="icons-bootstrap.html">

              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>

            </a>

          </li>

          <li>

            <a href="icons-remix.html">

              <i class="bi bi-circle"></i><span>Remix Icons</span>

            </a>

          </li>

          <li>

            <a href="icons-boxicons.html">

              <i class="bi bi-circle"></i><span>Boxicons</span>

            </a>

          </li>

        </ul>

      </li><!-- End Icons Nav -->



      <li class="nav-heading">Pages</li>



      <li class="nav-item">

        <a class="nav-link collapsed" href="users-profile.html">

          <i class="bi bi-person"></i>

          <span>Profile</span>

        </a>

      </li><!-- End Profile Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-faq.html">

          <i class="bi bi-question-circle"></i>

          <span>F.A.Q</span>

        </a>

      </li><!-- End F.A.Q Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-contact.html">

          <i class="bi bi-envelope"></i>

          <span>Contact</span>

        </a>

      </li><!-- End Contact Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-register.html">

          <i class="bi bi-card-list"></i>

          <span>Register</span>

        </a>

      </li><!-- End Register Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-login.html">

          <i class="bi bi-box-arrow-in-right"></i>

          <span>Login</span>

        </a>

      </li><!-- End Login Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-error-404.html">

          <i class="bi bi-dash-circle"></i>

          <span>Error 404</span>

        </a>

      </li><!-- End Error 404 Page Nav -->



      <li class="nav-item">

        <a class="nav-link collapsed" href="pages-blank.html">

          <i class="bi bi-file-earmark"></i>

          <span>Blank</span>

        </a>

      </li><!-- End Blank Page Nav -->



    </ul>



  </aside><!-- End Sidebar-->



  <main id="main" class="main">



    <div class="pagetitle">

      <h1>Dashboard</h1>

      <nav>

        <ol class="breadcrumb">

          <li class="breadcrumb-item"><a href="index.html">Home</a></li>

          <li class="breadcrumb-item active">Dashboard</li>

        </ol>

      </nav>

    </div><!-- End Page Title -->



    <section class="section dashboard">

      <div class="row">



        <!-- Left side columns -->

        <div class="col-lg-8">

          <div class="row">



            


            
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
    <div class="card info-card customers-card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h5 class="card-title">Clientes <span>| Total</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="total-clients"><?php echo $total_clients; ?></h6>
                    <span class="text-success small pt-1 fw-bold">Clientes</span> <span class="text-muted small pt-2 ps-1">Registrados</span>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Customers Card -->




            <!-- Reports -->
            <div class="container mt-5">
        <!-- Tabla de Préstamos de Trabajadores -->
        <h5 class="card-title">Préstamos <span>| Trabajadores</span></h5>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Número de Teléfono</th>
                        <th scope="col">Worker ID</th>
                        <th scope="col">Nickname</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($worker_loans as $loan): ?>
                        <tr>
                            <td><?php echo $loan['id']; ?></td>
                            <td><?php echo $loan['full_name']; ?></td>
                            <td><?php echo $loan['phone_number']; ?></td>
                            <td><?php echo $loan['worker_id']; ?></td>
                            <td><?php echo $loan['nickname']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Préstamos de Clientes -->
        <h5 class="card-title mt-5">Préstamos <span>| Clientes</span></h5>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Número de Cliente</th>
                        <th scope="col">Tipo de Préstamo</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client_loans as $loan): ?>
                        <tr>
                            <td><?php echo $loan['id']; ?></td>
                            <td><?php echo $loan['first_name']; ?></td>
                            <td><?php echo $loan['client_number']; ?></td>
                            <td><?php echo $loan['loan_type']; ?></td>
                            <td><?php echo $loan['requested_amount']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>-->
<!-- End Left side columns -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>-->
        <!--

      



      </div>

    </section>



  </main><!-- End #main -->



  <!-- ======= Footer ======= -->

 



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  <!-- Vendor JS Files -->

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/vendor/chart.js/chart.umd.js"></script>

  <script src="assets/vendor/echarts/echarts.min.js"></script>

  <script src="assets/vendor/quill/quill.js"></script>

  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

  <script src="assets/vendor/tinymce/tinymce.min.js"></script>

  <script src="assets/vendor/php-email-form/validate.js"></script>



  <!-- Template Main JS File -->

  <script src="assets/js/main.js"></script>
<!--
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('get_user_info.php')
            .then(response => response.json())
            .then(user => {
                if (user) {
                    document.getElementById('user-name').textContent = user.full_name;
                    document.getElementById('profile-name').textContent = user.full_name;
                    document.getElementById('profile-role').textContent = user.role;
                    // Si quieres mostrar una imagen de perfil vacía
                    document.getElementById('profile-image').src = 'path/to/default/profile/image.jpg';
                }
            });
    });
</script> -->

  <!--
  php
            // Información de conexión a la base de datos
            $host = '216.238.107.20';
            $db = 'droopyst_test01';
            $user = 'droopyst_admin01';
            $pass = 'M3nd0z@2020.';
            $port = 3306;

            // Crear conexión
            $mysqli = new mysqli($host, $user, $pass, $db, $port);

            // Verificar conexión
            if ($mysqli->connect_error) {
                echo '<div class="alert alert-danger" role="alert">Conexión fallida: ' . $mysqli->connect_error . '</div>';
            } else {
                echo '<div class="alert alert-success" role="alert">Conexión exitosa</div>';
            }

            // Cerrar conexión
            $mysqli->close();
            ?> -->

</body>

<!--Script que tambien se encuentra arriba--> 
<script>
  // Hacer una solicitud a la API
  fetch('api.php')
      .then(response => response.json())
      .then(data => {
          // Llenar la tabla con datos
          const tableBody = document.getElementById('table-body');
          data.data.forEach(row => {
              const tr = document.createElement('tr');
              tr.innerHTML = `
                  <th scope="row"><a href="#">${row.id}</a></th>
                  <td>${row.full_name}</td>
                  <td>${row.mobile_number}</td>
                  <td>${row.date_of_birth}</td>
                  <td><span class="badge bg-success">${row.status}</span></td>
              `;
              tableBody.appendChild(tr);
          });

          // Mostrar el total de clientes
          const totalCustomers = document.getElementById('total-customers');
          totalCustomers.textContent = data.total_clients;
      })
      .catch(error => console.error('Error:', error));
</script>



</html>