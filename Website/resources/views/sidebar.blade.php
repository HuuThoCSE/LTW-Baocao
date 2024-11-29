<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="/">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-account" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Account</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-account" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/account">
          <i class="bi bi-circle"></i><span>List Account</span>
        </a>
      </li>
    </ul>
</li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-device" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Device</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-device" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/devices">
          <i class="bi bi-circle"></i><span>List Device</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Accordion</span>
        </a>
      </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-breed" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Breed Management</span> <!-- Quản lý giống -->
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-breed" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('breed.list') }}">
          <i class="bi bi-circle"></i><span>Breed List</span>
        </a>
      </li>
      <!-- <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Link Breed to Goats</span>  Liên kết giống với dê 
        </a>
      </li> -->
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-goat" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Goat</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-goat" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/goats">
          <i class="bi bi-circle"></i><span>List Goat</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Accordion</span>
        </a>
      </li>
    </ul>
  </li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-farm" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Location</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-farm" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/farms">
          <i class="bi bi-circle"></i><span>List Farm</span>
        </a>
      </li>
      <li>
        <a href="/areas">
          <i class="bi bi-circle"></i><span>List Area</span>
        </a>
      </li>
      <li>
        <a href="/zones">
          <i class="bi bi-circle"></i><span>List Zone</span>
        </a>
      </li>
      <li>
        <a href="/barns">
          <i class="bi bi-circle"></i><span>List Barn</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-medication" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Medication</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-medication" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/medication">
          <i class="bi bi-circle"></i><span>List Medication</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Medication Report</span>
        </a>
      </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-food" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i>
        <span>Food</span>
        <i class="bi bi-chevron-down ms-auto">
      </i>
    </a>

    <ul id="components-food" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/food">
          <i class="bi bi-circle"></i><span>List Food</span>
        </a>
      </li>
    </ul>
</li>

</ul>

</aside>
<!-- End Sidebar-->