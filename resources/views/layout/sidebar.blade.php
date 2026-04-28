<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/home" aria-expanded="false"><i
                    data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
        <li class="list-divider"></li>
        <li class="nav-small-cap"><span class="hide-menu">Set Tahun Ajaran</span></li>
        <li class="sidebar-item"><a href="{{ route('ta.index') }}" class="sidebar-link"><i data-feather="calendar"
                    class="feather-icon"></i><span class="hide-menu">
                    TA</span></a>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">Jadwal</span></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="calendar" class="feather-icon"></i><span class="hide-menu">Jadwal </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="{{ route('jadwal.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Jadwal</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">Jurnal</span></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Jurnal </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="{{ route('jurnal.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Jurnal</span></a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="user-check" class="feather-icon"></i><span class="hide-menu">Tamu </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="{{ route('absensi.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Tamu</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">Pemakaian/Peminjaman</span></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Pemakaian </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="{{ route('pemakaian.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">Stok Opname </span></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="shopping-cart" class="feather-icon"></i><span class="hide-menu">Stok Opname
                </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="{{ route('alat.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Inventaris Alat</span></a>
                </li>
                <li class="sidebar-item"><a href="{{ route('bahan.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Bahan</span></a>
                </li>
                <li class="sidebar-item"><a href="{{ route('bahan.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Detail Penggunaan</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">Data</span></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                    data-feather="crosshair" class="feather-icon"></i><span class="hide-menu">Master Data </span></a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="" class="sidebar-link"><span class="hide-menu">
                            Data Fakultas</span></a>
                </li>
                <li class="sidebar-item"><a href="{{ route('program.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Prodi</span></a>
                </li>
                <li class="sidebar-item"><a href="{{ route('laboratorium.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Laboratorium</span></a>
                </li>
                <li class="sidebar-item"><a href="{{ route('matkul.index') }}" class="sidebar-link"><span
                            class="hide-menu">
                            Data Mata Kuliah</span></a>
                </li>
            </ul>
        </li>
        @can('isSuper')
            <li class="nav-small-cap"><span class="hide-menu">Pengguna</span></li>
            <li class="sidebar-item"><a class="sidebar-link sidebar-link" href="{{ route('user.index') }}"
                    aria-expanded="false"><i data-feather="user-check" class="feather-icon"></i><span
                        class="hide-menu">Management
                        User</span></a>
            </li>
        @elsecan('isLab')
        @endcan
    </ul>
</nav>