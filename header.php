<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">3D# Bugs</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="../">Queue</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../report/">Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../bug-reports/">Bug Reports</a>
          </li>
          <?php
          if ($_SESSION["access_level"] === 3) {
            echo
            '<li class="nav-item">
          <a class="nav-link" href="../logs/">Logs</a>
        </li>';
          }
          ?>
        </ul>
        <span class="navbar-text">
          <?php
          if ($_SESSION["logged_in"] === true) {
            echo "<a class='btn bg-danger' style='text-decoration: none' href='../logout.php'>Log out</a>";
          } else {
            echo "<a class='btn btn-success' style='text-decoration: none' href='../login/'>Log in</a>";
          }
          ?>
        </span>
      </div>
    </div>
  </nav>
  <script>
    const pages = document.querySelectorAll(".nav-link");
    for (let i = 0; i < pages.length; i++) {
      if (pages[i].href === location.href) {
        pages[i].className += " active";
      }
    }
  </script>
</header>
<br>