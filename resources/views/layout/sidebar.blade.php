        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                @if (auth()->user()->role ==0)
                <div class="sidebar-brand-text mx-3">Super Admin</div>                    
                @endif
                @if (auth()->user()->role ==1)
                <div class="sidebar-brand-text mx-3">Admin</div>                    
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
            {{-- ==================== Super Admin ===================== --}}
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

            <li class="nav-item {{Request::is('lada') ? 'active' : ''}} ">
                <a class="nav-link" href="/lada">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Link LADA</span></a>
            </li>

       
            <li class="nav-item  {{Request::is('bayarbeli') ? 'active' : ''}} ">
                <a class="nav-link" href="/bayarbeli">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Bayar/Beli
                        </span></a>
            </li>

            <li class="nav-item  {{Request::is('pasardesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/pasardesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Pasar Desa
                        </span></a>
            </li>
            
            <li class="nav-item {{Request::is('admin') ? 'active' : ''}} ">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin</span></a>
            </li>


            @endif
            {{-- ==================== END ADMIN ===================== --}}

      
              {{-- ==================== Admin ===================== --}}
            @if (auth()->user()->role==1 )
            <li class="nav-item {{Request::is('banner_admin') ? 'active' : ''}} ">
                <a class="nav-link" href="/banner_admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Banner</span></a>
            </li>
             <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{Request::is(['profildesa','gambardesa','datastatistik_desa']) ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Profil Desa</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Profil Desa:</h6>
                        <a class="collapse-item" href="/profildesa">Profil</a>
                        <a class="collapse-item" href="/gambardesa">Gambar Desa</a>
                        <a class="collapse-item" href="/datastatistik_desa">Data statistik</a>
                    </div>
                </div>
            </li>


            <li class="nav-item {{Request::is('fasilitasdesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/fasilitasdesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Fasilitas Desa</span></a>
            </li>

            <li class="nav-item {{Request::is('beritadesa_admin') ? 'active' : ''}} ">
                <a class="nav-link" href="/beritadesa_admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Berita Desa</span></a>
            </li>

            <li class="nav-item {{Request::is('leaflet') ? 'active' : ''}} ">
                <a class="nav-link" href="/leaflet">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Leaflet Map</span></a>
            </li>

       
            <li class="nav-item  {{Request::is('leafletdesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/leafletdesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Desa Lainnya
                        </span></a>
            </li>

            <li class="nav-item  {{Request::is('pasardesa') ? 'active' : ''}} ">
                <a class="nav-link" href="/pasardesa">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Pasar Desa
                        </span></a>
            </li>
            
            <li class="nav-item {{Request::is('admin') ? 'active' : ''}} ">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin</span></a>
            </li>


            @endif
            {{-- ==================== ADMIN ===================== --}}

                        <!-- Nav Item - Pages Collapse Menu -->


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
