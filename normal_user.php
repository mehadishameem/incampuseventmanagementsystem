<!-- normal_user.php -->

<?php
// include your navbar HTML here (or keep it in this file)
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Normal User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body>

<!-- Your navbar here (from your example) -->
<!-- Add this in your <head> for Bootstrap Icons -->
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  rel="stylesheet"
/>

<nav class="navbar navbar-expand-lg shadow" style="background-color: #192F59; height: 80px;">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <!-- Brand with subtle hover animation -->
    <a href="#" class="navbar-brand text-white fw-bold fs-4 position-relative overflow-hidden" style="cursor:pointer;">
      <span id="brand-text">Event Management</span>
      <span
        id="brand-underline"
        style="
          position: absolute;
          bottom: 0;
          left: 0;
          height: 3px;
          width: 0;
          background: #61dafb;
          transition: width 0.4s ease;
          border-radius: 2px;
        "
      ></span>
    </a>

    <button
      class="navbar-toggler border-0"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a
            class="nav-link active text-white fw-semibold px-3 rounded"
            href="#"
            data-page="HomePage.php"
            style="background-color: rgba(255,255,255,0.15); transition: background-color 0.3s;"
            onmouseenter="this.style.backgroundColor='rgba(255,255,255,0.3)';"
            onmouseleave="this.style.backgroundColor='rgba(255,255,255,0.15)';"
          >Home</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link text-white fw-semibold px-3 rounded"
            href="#"
            data-page="Events.php"
            style="transition: background-color 0.3s;"
            onmouseenter="this.style.backgroundColor='rgba(255,255,255,0.15)';"
            onmouseleave="this.style.backgroundColor='transparent';"
          >Events</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link text-white fw-semibold px-3 rounded"
            href="#"
            data-page="about.php"
            style="transition: background-color 0.3s;"
            onmouseenter="this.style.backgroundColor='rgba(255,255,255,0.15)';"
            onmouseleave="this.style.backgroundColor='transparent';"
          >About Us</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link text-white fw-semibold px-3 rounded"
            href="#"
            data-page="Venues.php"
            style="transition: background-color 0.3s;"
            onmouseenter="this.style.backgroundColor='rgba(255,255,255,0.15)';"
            onmouseleave="this.style.backgroundColor='transparent';"
          >Venues</a>
        </li>
      </ul>

      <!-- Search Form -->
      <form class="d-flex me-3" role="search" onsubmit="return false;">
        <input
          class="form-control rounded-pill me-2 px-4"
          type="search"
          placeholder="Search"
          aria-label="Search"
          style="width: 250px; transition: box-shadow 0.3s;"
          onfocus="this.style.boxShadow='0 0 10px rgba(97, 218, 251, 0.7)';"
          onblur="this.style.boxShadow='none';"
        />
        <button class="btn btn-outline-light rounded-pill px-4 fw-semibold" type="button" style="transition: background-color 0.3s;">
          Search
        </button>
      </form>

      <!-- Logout Icon -->
      <a href="login.php" class="text-white fs-4 d-flex align-items-center" title="Logout" style="transition: color 0.3s;">
        <i class="bi bi-box-arrow-right"></i>
      </a>
    </div>
  </div>
</nav>

<script>
  // Animate brand underline on hover
  const brand = document.querySelector('.navbar-brand');
  const underline = document.getElementById('brand-underline');

  brand.addEventListener('mouseenter', () => {
    underline.style.width = '100%';
  });
  brand.addEventListener('mouseleave', () => {
    underline.style.width = '0';
  });
</script>



<!-- This div will load the page content dynamically -->
<div id="content" class="container mt-4">
  <!-- Default content load (HomePage.php) -->
  <?php include 'HomePage.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
// Attach click listeners to navbar links
document.querySelectorAll('a.nav-link').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    let page = this.getAttribute('data-page');
    if (!page) return;

    // Optional: highlight active link
    document.querySelectorAll('a.nav-link').forEach(l => l.classList.remove('active'));
    this.classList.add('active');

    // Fetch the content of the page and load into #content div
    fetch(page)
      .then(response => {
        if (!response.ok) throw new Error('Network response was not OK');
        return response.text();
      })
      .then(html => {
        document.getElementById('content').innerHTML = html;
      })
      .catch(error => {
        document.getElementById('content').innerHTML = '<p class="text-danger">Failed to load page.</p>';
        console.error('Error loading page:', error);
      });
  });
});
</script>

</body>
</html>
