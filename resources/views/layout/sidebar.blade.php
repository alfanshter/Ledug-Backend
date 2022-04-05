        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                @if (auth()->user()->role ==0)
                <div class="sidebar-brand-text mx-3">Admin</div>                    
                @endif
                @if (auth()->user()->role ==1)
                <div class="sidebar-brand-text mx-3">Siswa</div>                    
                @endif
                @if (auth()->user()->role ==2)
                <div class="sidebar-brand-text mx-3">Pelatih</div>                    
                @endif
                @if (auth()->user()->role ==3)
                <div class="sidebar-brand-text mx-3">Kepala Sekolah</div>                    
                @endif


            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

         

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- ==================== ADMIN ===================== --}}
            @if (auth()->user()->role==0 )
            <li class="nav-item {{Request::is('beritadesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/beritadesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Berita Desa</span></a>
            </li>

            <li class="nav-item {{Request::is('multidesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/multidesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Multi Desa</span></a>
            </li>

            <li class="nav-item {{Request::is('tvcc') ? 'active' : ''}} ">
                <a class="nav-link" href="/tvcc">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Link TVCC</span></a>
            </li>

       
            <li class="nav-item">
                <a class="nav-link" href="/datasiswa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Bayar/Beli
                        </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/datasiswa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Pasar Desa</span></a>
            </li>

            <li class="nav-item {{Request::is('admin') ? 'active' : ''}} ">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin</span></a>
            </li>


            @endif
            {{-- ==================== END ADMIN ===================== --}}

      
                        <!-- Nav Item - Pages Collapse Menu -->


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
