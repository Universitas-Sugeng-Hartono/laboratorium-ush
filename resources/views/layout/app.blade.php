@extends('layout.home')
@section('inti')
<style>
td {
    width: 8%;
    height: 40px;
    vertical-align: top;
    border: 1px solid #ddd;
    position: relative;
}

td div {
    max-height: 40px;
    overflow-y: auto;
    margin-bottom: 5px;
}

td small {
    display: block;
    margin-top: 5px;
    color: blue;
    font-weight: bold;
}

td div,
td small {
    font-size: 12px;
    line-height: 1.2;
}
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Halo, {{ session('siakad_user_name', 'Pengguna') }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-end">
                <select
                    class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
                    <option>{{ $dates->format('M d') }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-lg-6">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium"> {{$jurnal}}</h2>
                                <span
                                    class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jurnal
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium"> {{$tamu}}</h2>
                                <span
                                    class="badge bg-secondary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Tamu
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$pemakaian}}</h2>
                                <span
                                    class="badge bg-success font-12 text-white font-weight-medium rounded-pill ms-2 d-md-none d-lg-block"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Permintaan Peminjaman
                                (Approve)
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$pemakaian1}}</h2>
                                <span
                                    class="badge bg-danger font-12 text-white font-weight-medium rounded-pill ms-2 d-md-none d-lg-block"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Permintaan Peminjaman
                                (Antrian)
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$pemakaian2}}</h2>
                                <span
                                    class="badge bg-warning font-12 text-white font-weight-medium rounded-pill ms-2 d-md-none d-lg-block"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Peminjaman Belum dikembalikan
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$user}}</h2>
                                <span
                                    class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none"></span>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">User
                            </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-end">
                <div class="card-body">
                    <h3>Kalender Jadwal Praktikum - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $startDay = $startOfMonth->dayOfWeek;
                            $daysInMonth = $startOfMonth->daysInMonth;
                            $weeks = [];
                            $currentDay = 1;

                            for ($row = 0; $row < 6; $row++) { $week=[]; for ($col=0; $col < 7; $col++) { if (($row==0
                                && $col < $startDay) || $currentDay> $daysInMonth) {
                                $week[] = null;
                                } else {
                                $week[] = $currentDay++;
                                }
                                }
                                $weeks[] = $week;
                                }
                                @endphp
                                @php
                                use Carbon\Carbon;
                                @endphp
                                @foreach ($weeks as $week)
                                <tr>
                                    @foreach ($week as $day)
                                    <td>
                                        @if ($day)
                                        <div>{{ $day }}</div>
                                        @foreach ($jadwal as $event)
                                        @php
                                        $jadwalDate = Carbon::parse($event->jadwal)->format('Y-m-d');
                                        $currentDate = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                                        @endphp
                                        @if ($jadwalDate == $currentDate)
                                        <small>{{ $event->matkulId->matakuliah }} -
                                            {{ $event->labId->laboratorium }}</small><br>
                                        @endif
                                        @endforeach

                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection