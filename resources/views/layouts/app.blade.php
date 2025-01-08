<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="{{ asset('assets/icon.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title')</title>
</head>

<body>
  @include('partials.sidebar')
  
  <section class="home-section">
    <nav>
      <div class="sidebar-button" >
        <i class="bx bx-menu sidebarBtn" id="group-icon"></i>
      </div>
      <div class="profile-details">
        <span class="admin_name">(HIPPAM) Admin</span>
      </div>
    </nav>
    
    <div class="home-content">
      @yield('content')
    </div>
  </section>
  
  <script>

   let sidebar = document.querySelector(".sidebar");
	 let sidebarBtn = document.querySelector(".sidebarBtn");
   const subsidebars = document.querySelectorAll('.subsidebar');

	   sidebarBtn.onclick = function () {
     subsidebars.forEach(function (subSidebar) {
            subSidebar.classList.remove('show');
            subSidebar.style.maxHeight = 0; // Atur maxHeight menjadi 0
            subSidebar.style.padding = '0'; // Reset padding saat tersembunyi
      });

	   sidebar.classList.toggle("active");
		 if (sidebar.classList.contains("active")) {
		    sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
 	     } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
			};

      

  </script>
</body>

</html>
