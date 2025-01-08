<div class="sidebar">
  <div class="logo-details">
    <i class="bx bx-category"></i>
    <span class="logo_name">  Administrasi <br>  HIPPAM <br> Tirto Lestari</span>
  </div>

  <ul class="nav-links">

    <li>
      <a href="#" onclick="navigateTo('/dashboard')">
      <i class="bx bx-grid-alt" id="group-icon"></i>
      <span class="links_name">Dashboard</span>
      </a>
    </li>

    <li>
      <a href="#" onclick="toggleSubSidebar(['Normal','Villa','Kos'])">
      <i class='bx bxs-contact' id="group-icon"></i>
      <span class="links_name">Data Pelanggan</span>
      </a>
    </li>

    <li class="subsidebar" onclick="navigateTo('/normal')" id="Normal">
      <a>
      <i class='bx bxs-group' id="group-icon"></i> 
		  <span class="links_name">Normal</span>
      </a>
	  </li>

    <li class="subsidebar" onclick="navigateTo('/villa')" id="Villa">
      <a>
      <i class='bx bxs-institution' id="group-icon"></i>
		  <span class="links_name">Villa</span>
      </a>
	  </li>

    <li class="subsidebar" onclick="navigateTo('/kos')" id="Kos">
       <a>
		   <i class='bx bx-home' id="group-icon"></i>
		   <span class="links_name">Kos</span>
      </a>
	  </li>
    
      <li>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class='bx bx-log-out' id="group-icon"></i>
    <span class="links_name">Logout</span>
  </a>
</li>


  </ul>
</div>


<script>

function navigateTo(url) {
    window.location.href = url;
}


function toggleSubSidebar(ids) {
    ids.forEach(function(id) {
        const subSidebar = document.getElementById(id);

        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.remove('active');


        subSidebar.style.transition = 'max-height 0.5s ease, padding 0.5s ease';


        if (subSidebar.classList.contains('show')) {
            localStorage.setItem(id, 'closed');
            subSidebar.style.maxHeight = 0;
            subSidebar.style.padding = '0 10px';
        } else {
            localStorage.setItem(id, 'open');
            subSidebar.style.maxHeight = '50px';
            subSidebar.style.padding = '10px';
        }

        subSidebar.classList.toggle('show');  
    });
}


function loadSubSidebarStatus(ids) {
    ids.forEach(function(id) {
        const subSidebar = document.getElementById(id);
        const status = localStorage.getItem(id);

        if (status === 'open') {
            
            subSidebar.style.transition = 'none';
            subSidebar.classList.add('show');  
            subSidebar.style.maxHeight = '50px';
            subSidebar.style.padding = '10px';

            
            subSidebar.offsetHeight;  

            
            setTimeout(() => {
                subSidebar.style.transition = '';  
            }, 10); 
        }
    });
}

    
    document.addEventListener('DOMContentLoaded', function() {
        loadSubSidebarStatus(['Normal', 'Villa', 'Kos']); 
    });

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('collapsed'); 
    }
</script>