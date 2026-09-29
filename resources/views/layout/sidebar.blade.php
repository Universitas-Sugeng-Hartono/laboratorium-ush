<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <!-- Dashboard Utama -->
        <li class="sidebar-item">
            <a class="sidebar-link" href="/home" aria-expanded="false">
                <i data-feather="home" class="feather-icon"></i>
                <span class="hide-menu">Dashboard</span>
            </a>
        </li>

        <!-- Operasional Harian Lab -->
        @can('operateLab')
        <li class="list-divider"></li>
        <li class="nav-small-cap"><span class="hide-menu">Operasional Lab</span></li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('jadwal.index') }}" aria-expanded="false">
                <i data-feather="calendar" class="feather-icon"></i>
                <span class="hide-menu">Jadwal Praktikum</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ auth()->user()->can('manageMaster') ? route('jurnal.pemantauan') : route('jurnal.index') }}" aria-expanded="false">
                <i data-feather="book-open" class="feather-icon"></i>
                <span class="hide-menu">Jurnal Praktikum</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('absensi.index') }}" aria-expanded="false">
                <i data-feather="users" class="feather-icon"></i>
                <span class="hide-menu">Presensi Tamu Lab</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('pemakaian.index') }}" aria-expanded="false">
                <i data-feather="clipboard" class="feather-icon"></i>
                <span class="hide-menu">Peminjaman Lab</span>
            </a>
        </li>
        @endcan

        @can('manageMaster')
        <!-- Inventaris & Logistik -->
        <li class="list-divider"></li>
        <li class="nav-small-cap"><span class="hide-menu">Inventaris & Logistik</span></li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('alat.index') }}" aria-expanded="false">
                <i data-feather="tool" class="feather-icon"></i>
                <span class="hide-menu">Inventaris Alat</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('bahan.index') }}" aria-expanded="false">
                <i data-feather="box" class="feather-icon"></i>
                <span class="hide-menu">Bahan Praktikum</span>
            </a>
        </li>

        <!-- Data Master -->
        <li class="list-divider"></li>
        <li class="nav-small-cap"><span class="hide-menu">Data Master</span></li>

        @php
            $masterOpen = request()->routeIs('ta.*', 'laboratorium.*', 'matkul.*', 'fakultas.*', 'program.*');
        @endphp
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="{{ $masterOpen ? 'true' : 'false' }}">
                <i data-feather="database" class="feather-icon"></i>
                <span class="hide-menu">Master Data</span>
            </a>
            <ul aria-expanded="{{ $masterOpen ? 'true' : 'false' }}" class="collapse first-level base-level-line {{ $masterOpen ? 'in show' : '' }}">
                <li class="sidebar-item {{ request()->routeIs('ta.*') ? 'selected' : '' }}">
                    <a href="{{ route('ta.index') }}" class="sidebar-link {{ request()->routeIs('ta.*') ? 'active' : '' }}">
                        <span class="hide-menu">Tahun Ajaran (TA)</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('laboratorium.*') ? 'selected' : '' }}">
                    <a href="{{ route('laboratorium.index') }}" class="sidebar-link {{ request()->routeIs('laboratorium.*') ? 'active' : '' }}">
                        <span class="hide-menu">Ruang Laboratorium</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('matkul.*') ? 'selected' : '' }}">
                    <a href="{{ route('matkul.index') }}" class="sidebar-link {{ request()->routeIs('matkul.*') ? 'active' : '' }}">
                        <span class="hide-menu">Mata Kuliah</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('fakultas.*') ? 'selected' : '' }}">
                    <a href="{{ route('fakultas.index') }}" class="sidebar-link {{ request()->routeIs('fakultas.*') ? 'active' : '' }}">
                        <span class="hide-menu">Data Fakultas</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('program.*') ? 'selected' : '' }}">
                    <a href="{{ route('program.index') }}" class="sidebar-link {{ request()->routeIs('program.*') ? 'active' : '' }}">
                        <span class="hide-menu">Data Program Studi</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Sistem & Keamanan (Super Admin) -->
        @can('isSuper')
            <li class="list-divider"></li>
            <li class="nav-small-cap"><span class="hide-menu">Sistem & Keamanan</span></li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('audit.index') }}" aria-expanded="false">
                    <i data-feather="shield" class="feather-icon"></i>
                    <span class="hide-menu">Audit Log</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('user.index') }}" aria-expanded="false">
                    <i data-feather="user-check" class="feather-icon"></i>
                    <span class="hide-menu">Manajemen User</span>
                </a>
            </li>
        @endcan
    </ul>
</nav>