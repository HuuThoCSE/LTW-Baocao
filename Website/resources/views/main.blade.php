<?php
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    @yield('title')
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('/assets/img/favicon/favicon.ico') }}" rel="icon">
  <link href="{{ asset('/assets/img/favicon/apple-touch-icon.png') }}" rel="apple-touch-icon">

  @include('links')
  @yield('account_style')
  @yield('dashboard_style')
  @yield('dashboard_script')

    <style>
        /* Container cho Alerts ở góc trên bên phải */
        #alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050; /* Đảm bảo alert nằm trên các phần tử khác */
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px; /* Khoảng cách giữa các alerts */
        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- Container cho Alerts -->
    <div id="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Thêm các loại alert khác nếu cần -->
    </div>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <span class="d-none d-lg-block">Farm Goat</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

      <!--
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
    -->

    <span class="ms-2">{{ Session::get('farm_name') }} - (farm: {{ Auth::user()->farm_id }})</span>


    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a> -->
          <!-- End Notification Icon -->

          <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul> -->
          <!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a> -->
          <!-- End Messages Icon -->

          <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul> -->
          <!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

          <li class="nav-item">
              @if(Session::get('locale') == 'vi')
                  <a class="nav-link nav-icon" href="{{ route('change.language', ['locale' => 'en']) }}">
                      <img src="{{asset('/assets/img/lang-united-kingdom.png')}}" alt="English" width="32" height="32">
                  </a>
              @else
                  <a class="nav-link nav-icon"  href="{{ route('change.language', ['locale' => 'vi']) }}" >
                      <img src="{{asset('/assets/img/lang-vietnam.png')}}" alt="Vietnamese" width="32" height="32">
                  </a>
              @endif
          </li>

        <li class="nav-item dropdown pe-3">

          @if(auth()->check()) <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{ auth()->user()->user_name }}</h6> <!-- Hiển thị tên người dùng -->
                    <span>{{ Auth::user()->role->role_name ." ( ". Auth::user()->role_id }} )</span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('settings') }}">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>{{ __('messages.logout') }}</span>
                    </a>
                </li>
            </ul>
          @else
              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ route('login') }}">
                  <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ __('messages.login') }}</span>
              </a>
          @endif
        </li>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/">
          <i class="bi bi-grid"></i>
          <span>{{ __('messages.dashboard') }}</span>
        </a>
      </li><!-- End Dashboard Nav -->

        <?php if (Auth::user()->role_id == 1): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-account" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.farm') }}</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="components-account" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <a href="{{ route('farms.index') }}">
                    <i class="bi bi-circle"></i><span>{{ __('messages.farms_list')  }}</span>
                </a>
            </ul>
        </li>
        <?php endif; ?>

        <!-- Chỉ có Administator với Owner mới hiểm thị Account -->
        <?php if (Auth::user()->role_id == 2): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-account" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.account_manager') }}</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="components-account" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('account.index') }}">
                        <i class="bi bi-circle"></i><span>{{ __('messages.account_list')  }}</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!--  -->
        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-iot" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.iot') }}</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="components-iot" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('iot.index') }}">
                  <!-- <i class="bi bi-circle"></i><span>{{ __('messages.iot_list') }}</span> -->
                  <i class="bi bi-circle"></i><span>Hệ Thống Điều Khiển IoT</span>
                </a>
              </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 2): ?>
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-device" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.equipment')  }}</span>
                <i class="bi bi-chevron-down ms-auto">
              </i>
            </a>

            <ul id="components-device" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="/devices">
                  <i class="bi bi-circle"></i><span>{{ __('messages.equipment_list') }}</span>
                </a>
              </li>
              <!-- <li>
                <a href="components-accordion.html">
                  <i class="bi bi-circle"></i><span>Accordion</span>
                </a>
              </li> -->
            </ul>
        </li>
        <?php endif; ?>

        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 4): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-breed" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i>
                    <span>{{ __('messages.breed') }}</span> <!-- Quản lý giống -->
                    <i class="bi bi-chevron-down ms-auto">
                  </i>
                </a>

                <ul id="components-breed" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="{{ route('breeds.index') }}">
                      <i class="bi bi-circle"></i><span>{{ __('messages.breed_list') }}</span>
                    </a>
                  </li>
                  <!-- <li>
                    <a href="components-accordion.html">
                      <i class="bi bi-circle"></i><span>Link BreedModel to Goats</span>  Liên kết giống với dê
                    </a>
                  </li> -->
                </ul>
            </li>
        <?php endif; ?>

        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 4): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-goat" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.goat') }}</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-goat" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="/goats">
                  <i class="bi bi-circle"></i><span>{{ __('messages.goat_list') }}</span>
                </a>
              </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 2): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-location" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.location')  }}</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-location" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('zones.index')}}">
                  <i class="bi bi-circle"></i><span>List Zone</span>
                </a>
              </li>
              <li>
                <a href="{{ route('areas.index')}}">
                  <i class="bi bi-circle"></i><span>List Area</span>
                </a>
              </li>
              <li>
                <a href="{{ route('barns.index')}}">
                  <i class="bi bi-circle"></i><span>{{ __('messages.barn_list') }}</span>
                </a>
              </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- Chỉ có Administator, Owner và Fammer mới hiểm thị Medication -->
        <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 4): ?>
          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#components-medication" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                  <span>{{ __('messages.medicine') }}</span>
                  <i class="bi bi-chevron-down ms-auto">
                </i>
              </a>

              <ul id="components-medication" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="/medication">
                    <i class="bi bi-circle"></i><span>List Medication</span>
                  </a>
                </li>

{{--                <li>--}}
{{--                  <a href="components-accordion.html">--}}

{{--                    <i class="bi bi-circle"></i><span>Medication Report</span>--}}
{{--                  </a>--}}
{{--                </li>--}}

              </ul>
            </li>
          <?php endif; ?>

          <?php if (Auth::user()->role_id == 2 || Auth::user()->role_id == 4): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-food" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i>
                    <span>{{ __('messages.food_management') }}</span>
                    <i class="bi bi-chevron-down ms-auto">
                  </i>
                </a>

                <ul id="components-food" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="{{ route('foods.index') }}">
                      <i class="bi bi-circle"></i><span>{{ __('messages.food_list') }}</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('typefoods.index') }}">
                      <i class="bi bi-circle"></i><span>{{ __('messages.food_type_list') }}</span>
                    </a>
                  </li>
                </ul>
            </li>
          <?php endif; ?>


    <?php if (Auth::user()->role_id == 1): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-food" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('messages.system') }}</span>
                <i class="bi bi-chevron-down ms-auto">
                </i>
            </a>

            <ul id="components-food" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('logs.index') }}">
                        <i class="bi bi-circle"></i><span>{{ __('messages.logs') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>


      <!-- <li class="nav-item">
        <a href="{{ route('login') }}">
            <i></i>
            <span>Login</span>
        </a>
      </li> -->
  </aside>

  <!-- End Sidebar-->

  <main id="main" class="main">
    {{-- Dùng content--}}
    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Farm Goat</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    $(document).ready(function() {
        // Tự động tắt alerts sau 10 giây
        setTimeout(function() {
            $('.alert').alert('close');
        }, 10000);

        // Tự động tắt alerts success sau 10 giây
        setTimeout(function() {
            $('.alert-success').alert('close');
        }, 10000);
    });
  </script>

  @stack('scripts')

</body>
</html>
