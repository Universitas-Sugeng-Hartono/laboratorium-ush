<div class="org-chart-wrapper position-relative">
    <!-- Info Bar (Bersih, Rapi & Responsif Mobile) -->
    <div class="org-info-bar mb-2 mb-md-3 px-1">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 py-1.5 px-2 px-sm-3 rounded-3 bg-white border border-slate-200 shadow-sm">
            <div class="d-flex align-items-center gap-2 flex-wrap text-primary font-12 fw-medium">
                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 text-nowrap font-11">
                    <i class="fa fa-hand-pointer me-1"></i> Interaktif
                </span>
                <span class="text-muted font-11 font-sm-12">
                    <span class="d-none d-md-inline">Klik pada salah satu card untuk melihat profil foto dan detail informasi lengkap.</span>
                    <span class="d-inline d-md-none">Ketuk card untuk melihat profil & detail.</span>
                </span>
            </div>
            <div class="d-inline-flex align-items-center gap-1 text-muted font-11 ms-auto">
                <i class="fa fa-arrows-left-right text-primary"></i>
                <span class="d-none d-sm-inline">Geser horizontal</span>
                <span class="d-inline d-sm-none">Geser bagan</span>
            </div>
        </div>
    </div>

    <!-- Canvas Tetap (Ukuran Pasti & Stabil) -->
    <div class="org-chart-viewport">
        <div class="org-chart-canvas">

            <!-- LEVEL 1: TF Digital Transform -->
            <div class="org-level d-flex justify-content-center">
                <div class="org-card org-card-root" onclick="openPersonDetail('nimas')" role="button" tabindex="0" aria-label="TF Digital Transform - Nimas Ratna Sari, Mgr.Inz.">
                    <div class="org-avatar-circle bg-white text-primary">
                        <img src="{{ asset('assets/images/foto/Nimas Ratna Sari, Mgr.Inz..png') }}" alt="Nimas Ratna Sari, Mgr.Inz." class="org-avatar-img">
                    </div>
                    <div class="org-card-text">
                        <div class="org-role text-white">TF: Digital Transform.</div>
                        <div class="org-name text-white">Nimas Ratna Sari, Mgr.Inz.</div>
                    </div>
                </div>
            </div>

            <!-- Stem 1 -> 2 -->
            <div class="org-vertical-stem-center"></div>

            <!-- LEVEL 2: Head of IST & Lab Dept -->
            <div class="org-level d-flex justify-content-center">
                <div class="org-card org-card-head" onclick="openPersonDetail('deny')" role="button" tabindex="0" aria-label="Head of IST and Lab Dept - Deny Prasetyo, S.Pd., M.Kom.">
                    <div class="org-avatar-circle bg-white text-primary">
                        <img src="{{ asset('assets/images/foto/Deny Prasetyo, S.Pd., M.Kom..png') }}" alt="Deny Prasetyo, S.Pd., M.Kom." class="org-avatar-img">
                    </div>
                    <div class="org-card-text">
                        <div class="org-role text-navy">Head of IST & Lab Dept.</div>
                        <div class="org-name text-navy">Deny Prasetyo, S.Pd., M.Kom.</div>
                    </div>
                </div>
            </div>

            <!-- Stem 2 to Horizontal Crossbar -->
            <div class="org-vertical-stem-center"></div>

            <!-- LEVEL 3 & 4: 4 Columns Container -->
            <div class="org-columns-container">
                <!-- Column 1: Deputi Web & Digital Marketing -->
                <div class="org-col org-col-1">
                    <div class="org-col-crossbar col-crossbar-left"></div>
                    <div class="org-col-stem-down"></div>

                    <!-- Deputy Card -->
                    <div class="org-card org-card-deputy" onclick="openPersonDetail('suyahman')" role="button" tabindex="0" aria-label="Deputi Web and Digital Marketing - Suyahman, S.Kom., M.Kom.">
                        <div class="org-avatar-circle bg-white text-primary flex-shrink-0">
                            <img src="{{ asset('assets/images/foto/Suyahman, S.Kom., M.Kom..png') }}" alt="Suyahman, S.Kom., M.Kom." class="org-avatar-img">
                        </div>
                        <div class="org-card-text">
                            <div class="org-role text-navy">Deputi Web & Digital Marketing</div>
                            <div class="org-name text-primary">Suyahman, S.Kom., M.Kom.</div>
                        </div>
                    </div>

                    <!-- Stem to Sub-team -->
                    <div class="org-vertical-stem-col"></div>

                    <!-- Sub-team crossbar -->
                    <div class="org-sub-crossbar-wrap">
                        <div class="org-sub-crossbar-line"></div>
                        <div class="org-sub-stem-left"></div>
                        <div class="org-sub-stem-right"></div>
                    </div>

                    <!-- 2 Sub-cards: Faruq & Novela (Magang) -->
                    <div class="org-sub-grid-2">
                        <div class="org-card org-card-staff" onclick="openPersonDetail('faruq_magang')" role="button" tabindex="0" aria-label="Muhamad Faruq - Magang">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Muhamad Faruq.png') }}" alt="Muhamad Faruq" class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Muhamad Faruq">Muhamad Faruq</div>
                                <div class="org-staff-role">Magang</div>
                            </div>
                        </div>

                        <div class="org-card org-card-staff" onclick="openPersonDetail('novela_magang')" role="button" tabindex="0" aria-label="Novela Putri Puspasari - Magang">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Novela Putri Puspasari.png') }}" alt="Novela Putri Puspasari" class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Novela Putri Puspasari">Novela Putri P.</div>
                                <div class="org-staff-role">Magang</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom converging lines to banner -->
                    <div class="org-converge-wrap org-converge-extended">
                        <div class="org-converge-stem-left"></div>
                        <div class="org-converge-stem-right"></div>
                        <div class="org-sub-crossbar-line org-converge-bar"></div>
                        <div class="org-arrow-stem-down org-arrow-extended">
                            <div class="org-arrow-line"></div>
                            <div class="org-arrow-head"></div>
                        </div>
                    </div>

                    <!-- Bottom Banner 1 -->
                    <div class="org-bottom-banner" onclick="openPersonDetail('suyahman')" role="button" tabindex="0" aria-label="Wordpress Management">
                        <div class="org-banner-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="org-banner-title">Wordpress Management</div>
                    </div>
                </div>

                <!-- Column 2: Deputi Software Dev & IT Support -->
                <div class="org-col org-col-2">
                    <div class="org-col-crossbar col-crossbar-mid-left"></div>
                    <div class="org-col-stem-down"></div>

                    <!-- Deputy Card -->
                    <div class="org-card org-card-deputy" onclick="openPersonDetail('ardy')" role="button" tabindex="0" aria-label="Deputi Software Dev and IT Support - Ardy Wicaksono, M.Kom.">
                        <div class="org-avatar-circle bg-white text-primary flex-shrink-0">
                            <img src="{{ asset('assets/images/foto/Ardy Wicaksono, M.Kom..png') }}" alt="Ardy Wicaksono, M.Kom." class="org-avatar-img">
                        </div>
                        <div class="org-card-text">
                            <div class="org-role text-navy">Deputi Software Dev. & IT Support</div>
                            <div class="org-name text-primary">Ardy Wicaksono, M.Kom.</div>
                        </div>
                    </div>

                    <!-- Stem to Sahrul -->
                    <div class="org-vertical-stem-col"></div>

                    <!-- Sahrul Card (Centered) -->
                    <div class="d-flex justify-content-center">
                        <div class="org-card org-card-staff org-card-mid" onclick="openPersonDetail('sahrul')" role="button" tabindex="0" aria-label="Sahrul, S.Kom. - Staff IT">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Sahrul, S.Kom..png') }}" alt="Sahrul, S.Kom." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Sahrul, S.Kom.">Sahrul, S.Kom.</div>
                                <div class="org-staff-role">Staff IT</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stem to Nathan & Fajri -->
                    <div class="org-vertical-stem-col" style="height: 14px;"></div>

                    <!-- Sub-team crossbar for Nathan & Fajri -->
                    <div class="org-sub-crossbar-wrap">
                        <div class="org-sub-crossbar-line"></div>
                        <div class="org-sub-stem-left"></div>
                        <div class="org-sub-stem-right"></div>
                    </div>

                    <!-- 2 Sub-cards: Yonathan & Al Fajri (Full Time) -->
                    <div class="org-sub-grid-2">
                        <div class="org-card org-card-staff" onclick="openPersonDetail('nathan')" role="button" tabindex="0" aria-label="Yonathan Tanjung, S.Kom. - Full Time">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Yonathan Tanjung, S.Kom..png') }}" alt="Yonathan Tanjung, S.Kom." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Yonathan Tanjung, S.Kom.">Yonathan Tanjung</div>
                                <div class="org-staff-role">Full Time</div>
                            </div>
                        </div>

                        <div class="org-card org-card-staff" onclick="openPersonDetail('fajri')" role="button" tabindex="0" aria-label="Al Fajri Ridho Hidayat, S.Kom. - Full Time">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Al Fajri Ridho Hidayat, S.Kom..png') }}" alt="Al Fajri Ridho Hidayat, S.Kom." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Al Fajri Ridho Hidayat, S.Kom.">Al Fajri Ridho H.</div>
                                <div class="org-staff-role">Full Time</div>
                            </div>
                        </div>
                    </div>

                    <!-- Converging lines to banner -->
                    <div class="org-converge-wrap org-converge-compact">
                        <div class="org-converge-stem-left"></div>
                        <div class="org-converge-stem-right"></div>
                        <div class="org-sub-crossbar-line org-converge-bar"></div>
                        <div class="org-arrow-stem-down">
                            <div class="org-arrow-line"></div>
                            <div class="org-arrow-head"></div>
                        </div>
                    </div>

                    <!-- Bottom Banner 2 -->
                    <div class="org-bottom-banner" onclick="openPersonDetail('ardy')" role="button" tabindex="0" aria-label="Programming, Trouble Shooting & Jaringan">
                        <div class="org-banner-icon">
                            <i class="fa fa-code"></i>
                        </div>
                        <div class="org-banner-title">Programming, Trouble Shooting & Jaringan</div>
                    </div>
                </div>

                <!-- Column 3: Deputi Lab FTHB -->
                <div class="org-col org-col-3">
                    <div class="org-col-crossbar col-crossbar-mid-right"></div>
                    <div class="org-col-stem-down"></div>

                    <!-- Deputy Card with Labs -->
                    <div class="org-card org-card-deputy org-card-with-labs" onclick="openPersonDetail('agatha')" role="button" tabindex="0" aria-label="Deputi Lab FTHB - Agatha Pricillia Sekar Tamtomo, S.M., M.M.">
                        <div class="d-flex align-items-center gap-2">
                            <div class="org-avatar-circle bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Agatha Pricillia Sekar Tamtomo, S.M., M.M..png') }}" alt="Agatha Pricillia Sekar Tamtomo, S.M., M.M." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-role text-navy">Deputi Lab FTHB</div>
                                <div class="org-name text-primary">Agatha Pricillia Sekar Tamtomo, S.M., M.M.</div>
                            </div>
                        </div>
                        <div class="org-labs-list">
                            Lab IoT, Lab ICT Lt.1, Lab ICT Lt.2, Lab Multimedia, Mootcourt
                        </div>
                    </div>

                    <!-- Stem to Sub-team -->
                    <div class="org-vertical-stem-col"></div>

                    <!-- Sub-team crossbar -->
                    <div class="org-sub-crossbar-wrap">
                        <div class="org-sub-crossbar-line"></div>
                        <div class="org-sub-stem-left"></div>
                        <div class="org-sub-stem-right"></div>
                    </div>

                    <!-- 2 Sub-cards: Faruq & Novela (Laboran) -->
                    <div class="org-sub-grid-2">
                        <div class="org-card org-card-staff" onclick="openPersonDetail('faruq_laboran')" role="button" tabindex="0" aria-label="Muhamad Faruq - Laboran">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Muhamad Faruq.png') }}" alt="Muhamad Faruq" class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Muhamad Faruq">Muhamad Faruq</div>
                                <div class="org-staff-role">Laboran</div>
                            </div>
                        </div>

                        <div class="org-card org-card-staff" onclick="openPersonDetail('novela_laboran')" role="button" tabindex="0" aria-label="Novela Putri Puspasari - Laboran">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Novela Putri Puspasari.png') }}" alt="Novela Putri Puspasari" class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Novela Putri Puspasari">Novela Putri P.</div>
                                <div class="org-staff-role">Laboran</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom converging lines to banner -->
                    <div class="org-converge-wrap org-converge-extended">
                        <div class="org-converge-stem-left"></div>
                        <div class="org-converge-stem-right"></div>
                        <div class="org-sub-crossbar-line org-converge-bar"></div>
                        <div class="org-arrow-stem-down org-arrow-extended">
                            <div class="org-arrow-line"></div>
                            <div class="org-arrow-head"></div>
                        </div>
                    </div>

                    <!-- Bottom Banner 3 -->
                    <div class="org-bottom-banner" onclick="openPersonDetail('agatha')" role="button" tabindex="0" aria-label="Laboratorium Assistance, Maintenance Laboratorium">
                        <div class="org-banner-icon">
                            <i class="fa fa-flask"></i>
                        </div>
                        <div class="org-banner-title">Laboratorium Assistance, Maintenance Laboratorium</div>
                    </div>
                </div>

                <!-- Column 4: Deputi Lab FITH -->
                <div class="org-col org-col-4">
                    <div class="org-col-crossbar col-crossbar-right"></div>
                    <div class="org-col-stem-down"></div>

                    <!-- Deputy Card with Labs -->
                    <div class="org-card org-card-deputy org-card-with-labs" onclick="openPersonDetail('salsabila')" role="button" tabindex="0" aria-label="Deputi Lab FITH - Salsabila Amalia Putri Bumi, S.T.P., M.T.P.">
                        <div class="d-flex align-items-center gap-2">
                            <div class="org-avatar-circle bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Salsabila Amalia Putri Bumi, S.T.P., M.T.P..png') }}" alt="Salsabila Amalia Putri Bumi, S.T.P., M.T.P." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-role text-navy">Deputi Lab FITH</div>
                                <div class="org-name text-primary">Salsabila Amalia Putri Bumi, S.T.P., M.T.P.</div>
                            </div>
                        </div>
                        <div class="org-labs-list">
                            Lab Mikrobiologi, Lab Kuliner, Lab Kimia, Lab AZG, Lab PSG, Lab TekPang
                        </div>
                    </div>

                    <!-- Stem to Sub-team -->
                    <div class="org-vertical-stem-col"></div>

                    <!-- Sub-team crossbar -->
                    <div class="org-sub-crossbar-wrap">
                        <div class="org-sub-crossbar-line"></div>
                        <div class="org-sub-stem-left"></div>
                        <div class="org-sub-stem-right"></div>
                    </div>

                    <!-- 2 Sub-cards: Wida & Rika (Laboran) -->
                    <div class="org-sub-grid-2">
                        <div class="org-card org-card-staff" onclick="openPersonDetail('wida')" role="button" tabindex="0" aria-label="Widasari Atrilania Sri Kunciati, S.T.P. - Laboran">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Widasari Atrilania Sri Kunciati, S.T.P.png') }}" alt="Widasari Atrilania Sri Kunciati, S.T.P." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Widasari Atrilania Sri Kunciati, S.T.P.">Widasari A., S.T.P.</div>
                                <div class="org-staff-role">Laboran</div>
                            </div>
                        </div>

                        <div class="org-card org-card-staff" onclick="openPersonDetail('rika')" role="button" tabindex="0" aria-label="Rika Wahyuningsih, A.Md.Si. - Laboran">
                            <div class="org-avatar-circle-sm bg-white text-primary flex-shrink-0">
                                <img src="{{ asset('assets/images/foto/Rika Wahyuningsih, A. Md. Si.png') }}" alt="Rika Wahyuningsih, A.Md.Si." class="org-avatar-img">
                            </div>
                            <div class="org-card-text">
                                <div class="org-staff-name" title="Rika Wahyuningsih, A. Md. Si.">Rika W., A.Md.Si.</div>
                                <div class="org-staff-role">Laboran</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom converging lines to banner -->
                    <div class="org-converge-wrap org-converge-extended">
                        <div class="org-converge-stem-left"></div>
                        <div class="org-converge-stem-right"></div>
                        <div class="org-sub-crossbar-line org-converge-bar"></div>
                        <div class="org-arrow-stem-down org-arrow-extended">
                            <div class="org-arrow-line"></div>
                            <div class="org-arrow-head"></div>
                        </div>
                    </div>

                    <!-- Bottom Banner 4 -->
                    <div class="org-bottom-banner" onclick="openPersonDetail('salsabila')" role="button" tabindex="0" aria-label="Laboratorium Assistance, Maintenance Laboratorium Tools">
                        <div class="org-banner-icon">
                            <i class="fa fa-wrench"></i>
                        </div>
                        <div class="org-banner-title">Laboratorium Assistance, Maintenance Laboratorium Tools</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL DETAIL ANGGOTA ORGANISASI (Desain Elegan, Warna & Font Harmonis) -->
<div class="modal fade" id="modalDetailPerson" tabindex="-1" aria-labelledby="modalDetailPersonLabel" aria-hidden="true" style="z-index: 1085;">
    <div class="modal-dialog modal-dialog-centered modal-lg org-detail-dialog">
        <div class="modal-content border-0 rounded-4 shadow-2xl overflow-hidden" style="background: #ffffff;">
            <!-- Modal Header -->
            <div class="modal-header border-bottom py-3 px-4 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="detail-header-icon shadow-sm">
                        <i class="fa fa-id-card text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 font-16" id="modalDetailPersonLabel">
                            Profil Anggota Organisasi
                        </h5>
                        <small class="text-muted font-12">Laboratorium Terpadu & IST Universitas Sugeng Hartono</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <!-- Modal Body: Kiri Foto, Kanan Detail Informasi -->
            <div class="modal-body p-3 p-md-4" style="background-color: #f8fafc;">
                <div class="row g-3 g-md-4 align-items-stretch">
                    <!-- Kolom Kiri: Foto Profil Potret Studio Full -->
                    <div class="col-12 col-md-5">
                        <div class="detail-photo-card h-100 d-flex flex-column align-items-center justify-content-center text-center p-3 p-lg-4 bg-white rounded-4 shadow-sm border border-slate-200">
                            <div class="detail-photo-wrapper position-relative overflow-hidden rounded-3 shadow-sm">
                                <img id="detailPersonPhoto" src="" alt="Foto Profil" class="detail-person-img is-hidden" onerror="handlePhotoError()">
                                <!-- Fallback Avatar -->
                                <div id="detailPersonAvatarFallback" class="detail-person-fallback is-hidden">
                                    <div class="avatar-icon-box shadow-sm mb-2 rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 34px;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <span id="detailPersonInitials" class="fw-bold font-15 text-primary">USH</span>
                                    <small class="text-muted font-11 mt-1">Laboratorium Terpadu</small>
                                </div>
                            </div>

                            <div class="mt-3 w-100">
                                <span id="detailPersonBadge" class="badge rounded-pill px-3 py-2 font-12 fw-semibold" style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                    Struktural
                                </span>
                                <div class="text-muted font-11 mt-1">Universitas Sugeng Hartono</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Detail Informasi Lengkap -->
                    <div class="col-12 col-md-7">
                        <div class="detail-info-card h-100 bg-white p-3 p-md-4 rounded-4 shadow-sm border border-slate-200 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Tag Peran / Kategori -->
                                <div class="mb-2">
                                    <span id="detailPersonRoleTag" class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 font-11 fw-semibold text-uppercase tracking-wider">
                                        Jabatan
                                    </span>
                                </div>

                                <!-- Nama Resmi & Gelar -->
                                <h4 id="detailPersonName" class="fw-bold mb-1" style="color: #0f172a; font-size: 19px; line-height: 1.35; letter-spacing: -0.2px;">
                                    Nama Anggota
                                </h4>

                                <!-- Peran Jabatan Utama -->
                                <div id="detailPersonRoleSub" class="fw-semibold mb-3 font-14" style="color: #2563eb;">
                                    Peran / Posisi
                                </div>

                                <div class="detail-divider"></div>

                                <!-- Rincian Unit, Ruang, Tugas, Email -->
                                <div class="d-flex flex-column gap-3 mt-3">
                                    <!-- Unit / Departemen -->
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="detail-icon-box">
                                            <i class="fa fa-building-columns"></i>
                                        </div>
                                        <div>
                                            <span class="detail-item-label">Unit / Departemen</span>
                                            <div id="detailPersonDept" class="detail-item-value">Departemen IST</div>
                                        </div>
                                    </div>

                                    <!-- Laboratorium Terkait -->
                                    <div class="d-flex align-items-start gap-3" id="detailPersonLabRow">
                                        <div class="detail-icon-box">
                                            <i class="fa fa-flask-vial"></i>
                                        </div>
                                        <div class="w-100">
                                            <span class="detail-item-label">Laboratorium / Ruang Lingkup</span>
                                            <div id="detailPersonLabsList" class="d-flex flex-wrap gap-1 mt-1"></div>
                                        </div>
                                    </div>

                                    <!-- Tanggung Jawab -->
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="detail-icon-box">
                                            <i class="fa fa-clipboard-check"></i>
                                        </div>
                                        <div>
                                            <span class="detail-item-label">Tugas & Tanggung Jawab</span>
                                            <p id="detailPersonDesc" class="detail-item-desc mb-0">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-white border-top py-2 px-4 d-flex justify-content-between align-items-center">
                <span class="text-muted font-12 d-flex align-items-center gap-1">
                    <i class="fa fa-circle-check text-success"></i> Data diverifikasi resmi Laboratorium Terpadu USH
                </span>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    /* Scoped Styles for Organization Chart */
    .org-chart-wrapper {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        user-select: none;
    }

    .org-chart-viewport {
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 32px 20px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .org-chart-viewport::-webkit-scrollbar {
        height: 6px;
    }

    .org-chart-viewport::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .org-chart-viewport::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .org-chart-viewport::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    @media (max-width: 575.98px) {
        .org-chart-viewport {
            padding: 22px 12px;
            border-radius: 10px;
        }
    }

    .org-chart-canvas {
        min-width: 1040px;
        max-width: 1160px;
        margin: 0 auto;
        position: relative;
    }

    /* Colors */
    :root {
        --org-navy-dark: #1b4486;
        --org-blue-primary: #2563eb;
        --org-blue-light: #eff6ff;
        --org-blue-border: #2b5fb3;
        --org-line-color: #1b4486;
        --org-text-navy: #1e3a8a;
    }

    .text-navy {
        color: #1e3a8a !important;
    }

    .text-navy-dark {
        color: #1b4486 !important;
    }

    /* Card Base */
    .org-card {
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        outline: none;
    }

    .org-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -3px rgba(27, 68, 134, 0.2);
    }

    .org-card:focus-visible {
        outline: 3px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Level 1: Root */
    .org-card-root {
        background: #1b4486;
        color: #ffffff;
        border-radius: 10px;
        padding: 12px 28px;
        min-width: 320px;
        max-width: 390px;
        display: inline-flex;
        align-items: center;
        gap: 16px;
        border: 1.5px solid #14356b;
    }

    .org-card-root .org-role {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .org-card-root .org-name {
        font-size: 13.5px;
        font-weight: 500;
        color: #ffffff;
    }

    /* Level 2: Head */
    .org-card-head {
        background: #dbeafe;
        border: 2px solid #2b5fb3;
        border-radius: 10px;
        padding: 12px 28px;
        min-width: 340px;
        max-width: 410px;
        display: inline-flex;
        align-items: center;
        gap: 16px;
    }

    .org-card-head .org-role {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .org-card-head .org-name {
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Avatar Circles with Full Photo Display */
    .org-avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        background-color: #ffffff;
        overflow: hidden;
        position: relative;
    }

    .org-avatar-circle-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1.5px solid #ffffff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.12);
        background-color: #ffffff;
        overflow: hidden;
        position: relative;
    }

    .org-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    /* Stems */
    .org-vertical-stem-center {
        width: 2px;
        height: 24px;
        background-color: var(--org-line-color);
        margin: 0 auto;
    }

    .org-vertical-stem-col {
        width: 2px;
        height: 24px;
        background-color: var(--org-line-color);
        margin: 0 auto;
    }

    /* Columns Layout */
    .org-columns-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        column-gap: 16px;
        position: relative;
    }

    .org-col {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* Crossbar across 4 columns */
    .org-col-crossbar {
        position: absolute;
        top: 0;
        height: 2px;
        background-color: var(--org-line-color);
    }

    .col-crossbar-left {
        left: 50%;
        right: -16px;
    }

    .col-crossbar-mid-left {
        left: 0;
        right: -16px;
    }

    .col-crossbar-mid-right {
        left: 0;
        right: -16px;
    }

    .col-crossbar-right {
        left: 0;
        right: 50%;
    }

    .org-col-stem-down {
        width: 2px;
        height: 24px;
        background-color: var(--org-line-color);
        margin: 0 auto;
    }

    /* Level 3: Deputy Cards */
    .org-card-deputy {
        background: #ebf3fd;
        border: 2px solid #2b5fb3;
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 86px;
    }

    .org-card-deputy.org-card-with-labs {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }

    .org-card-deputy .org-role {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.25;
    }

    .org-card-deputy .org-name {
        font-size: 12px;
        font-weight: 600;
        margin-top: 2px;
        line-height: 1.25;
    }

    .org-labs-list {
        font-size: 11px;
        font-weight: 600;
        color: #1e3a8a;
        line-height: 1.35;
        text-align: center;
        background: rgba(255, 255, 255, 0.75);
        padding: 5px 8px;
        border-radius: 6px;
        border: 1px dashed rgba(43, 95, 179, 0.3);
    }

    /* Sub-team Crossbar */
    .org-sub-crossbar-wrap {
        position: relative;
        height: 16px;
        width: 100%;
    }

    .org-sub-crossbar-line {
        position: absolute;
        top: 0;
        left: calc(25% - 2.5px);
        right: calc(25% - 2.5px);
        height: 2px;
        background-color: var(--org-line-color);
    }

    .org-sub-stem-left {
        position: absolute;
        top: 0;
        left: calc(25% - 2.5px);
        width: 2px;
        height: 16px;
        background-color: var(--org-line-color);
    }

    .org-sub-stem-right {
        position: absolute;
        top: 0;
        right: calc(25% - 2.5px);
        width: 2px;
        height: 16px;
        background-color: var(--org-line-color);
    }

    /* Sub-cards Grid */
    .org-sub-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    /* Sub-cards */
    .org-card-staff {
        background: #ffffff;
        border: 1.5px solid #2b5fb3;
        border-radius: 8px;
        padding: 8px 9px;
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 56px;
    }

    .org-card-staff.org-card-mid {
        width: 70%;
        margin: 0 auto;
    }

    .org-staff-name {
        font-size: 11.5px;
        font-weight: 700;
        color: #1e3a8a;
        line-height: 1.25;
        word-break: normal;
    }

    .org-staff-role {
        font-size: 11px;
        font-weight: 500;
        color: #64748b;
        margin-top: 1px;
        line-height: 1.1;
    }

    /* Converge wrap to bottom banner */
    .org-converge-wrap {
        position: relative;
        margin-top: 10px;
        width: 100%;
    }

    .org-converge-stem-left {
        position: absolute;
        top: 0;
        left: calc(25% - 2.5px);
        width: 2px;
        height: 14px;
        background-color: var(--org-line-color);
    }

    .org-converge-stem-right {
        position: absolute;
        top: 0;
        right: calc(25% - 2.5px);
        width: 2px;
        height: 14px;
        background-color: var(--org-line-color);
    }

    .org-converge-wrap .org-converge-bar {
        top: 14px;
    }

    .org-arrow-stem-down {
        position: absolute;
        top: 14px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .org-arrow-line {
        width: 2px;
        height: 14px;
        background-color: var(--org-line-color);
    }

    .org-arrow-head {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid var(--org-line-color);
    }

    /* Extended converge for Col 1, 3, 4 so all 4 banners align horizontally */
    .org-converge-extended {
        height: 100px;
    }

    .org-converge-extended .org-arrow-line {
        height: 80px;
    }

    .org-converge-compact {
        height: 34px;
    }

    .org-converge-compact .org-arrow-line {
        height: 14px;
    }

    /* Bottom Banners */
    .org-bottom-banner {
        background: #1b4486;
        color: #ffffff;
        border-radius: 8px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 54px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #14356b;
    }

    .org-bottom-banner:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .org-banner-icon {
        font-size: 17px;
        padding-right: 8px;
        border-right: 1px solid rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .org-banner-title {
        font-size: 11.5px;
        font-weight: 600;
        line-height: 1.3;
        color: #ffffff;
    }

    /* Modal Detail Typography, Layout & Color System */
    #modalDetailPerson {
        z-index: 1085 !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    #modalDetailPerson .org-detail-dialog {
        max-width: 860px !important;
        width: 94% !important;
        margin: 1.75rem auto;
    }

    .detail-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #2563eb;
    }

    .detail-photo-card {
        border-color: #e2e8f0;
        background: #ffffff;
    }

    .detail-photo-wrapper {
        width: 100%;
        max-width: 250px;
        height: 330px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        position: relative;
    }

    .detail-person-img {
        width: 100%;
        height: 100%;
        max-height: 318px;
        object-fit: contain;
        object-position: center bottom;
        display: block;
        margin: 0 auto;
    }

    .detail-person-img.is-hidden {
        display: none !important;
    }

    .detail-person-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 16px;
        background: #f1f5f9;
        border-radius: 8px;
    }

    .detail-person-fallback.is-hidden {
        display: none !important;
    }

    .detail-info-card {
        border-color: #e2e8f0;
    }

    .detail-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 14px 0;
    }

    .detail-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .detail-item-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .detail-item-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.4;
    }

    .detail-item-desc {
        font-size: 12.5px;
        color: #475569;
        line-height: 1.6;
    }

    .detail-item-email {
        font-size: 13px;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
        word-break: break-all;
    }

    .detail-item-email:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .detail-lab-pill {
        background: #eff6ff;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        font-size: 11px;
        font-weight: 600;
        border-radius: 6px;
        padding: 3px 8px;
        display: inline-block;
        line-height: 1.35;
    }

    @media (max-width: 767.98px) {
        #modalDetailPerson .org-detail-dialog {
            margin: 0.5rem auto;
            width: 96% !important;
        }
        .detail-photo-wrapper {
            max-width: 210px !important;
            height: 250px !important;
        }
        .detail-person-img {
            max-height: 240px !important;
        }
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }
</style>

<!-- SCRIPT -->
<script>
    // Data Lengkap Seluruh Anggota Struktur Organisasi Laboratorium Terpadu USH dengan Tugas & Tanggung Jawab Resmi
    const orgMembersData = {
        'nimas': {
            name: 'Nimas Ratna Sari, Mgr.Inz.',
            role: 'TF: Digital Transform.',
            dept: 'Task Force Digital Transformation',
            labs: ['Digital Transformation Unit', 'Sistem Informasi Kampus'],
            desc: 'Memimpin Task Force Digital Transformation untuk merumuskan peta jalan dan prioritas digitalisasi layanan laboratorium dan IST. Mengoordinasikan implementasi program lintas unit, memantau capaian dan kendalanya, serta melaporkan perkembangannya kepada pimpinan universitas.',
            badge: 'Task Force Leader',
            initials: 'NR',
            photo: "{{ asset('assets/images/foto/Nimas Ratna Sari, Mgr.Inz..png') }}"
        },
        'deny': {
            name: 'Deny Prasetyo, S.Pd., M.Kom.',
            role: 'Head of IST & Lab Dept.',
            dept: 'Departemen IST & Laboratorium Terpadu',
            labs: ['Unit Lab FTHB', 'Unit Lab FITH', 'Data Center & IT Infrastructure'],
            desc: 'Memimpin Departemen IST dan Laboratorium Terpadu secara menyeluruh, mencakup perencanaan program kerja, pengelolaan anggaran, dan pengawasan mutu layanan. Mengoordinasikan para deputi, menjadi penghubung dengan fakultas dan pimpinan universitas, serta mengevaluasi kinerja tim secara berkala.',
            badge: 'Kepala Departemen',
            initials: 'DP',
            photo: "{{ asset('assets/images/foto/Deny Prasetyo, S.Pd., M.Kom..png') }}"
        },
        'suyahman': {
            name: 'Suyahman, S.Kom., M.Kom.',
            role: 'Deputi Web & Digital Marketing',
            dept: 'Divisi Web & Digital Marketing',
            labs: ['Wordpress Management', 'Kanal Digital Kampus'],
            desc: 'Mengoordinasikan pengelolaan website dan kanal digital universitas, termasuk pembaruan konten, optimasi SEO, dan keamanan situs WordPress. Menyusun serta menjalankan strategi digital marketing, membimbing tim magang, dan melaporkan kinerja kanal digital secara berkala.',
            badge: 'Deputi Web & Marketing',
            initials: 'SY',
            photo: "{{ asset('assets/images/foto/Suyahman, S.Kom., M.Kom..png') }}"
        },
        'ardy': {
            name: 'Ardy Wicaksono, M.Kom.',
            role: 'Deputi Software Dev. & IT Support',
            dept: 'Divisi Software Dev. & IT Support',
            labs: ['development', 'IT Support & Hardware', 'Jaringan Kampus'],
            desc: 'Mengoordinasikan pengembangan dan pemeliharaan sitem digital kampus serta layanan IT Support. Mengawasi pengelolaan server, database, dan infrastruktur jaringan, menetapkan prioritas penanganan gangguan, dan memastikan keamanan serta ketersediaan sistem.',
            badge: 'Deputi Software & IT',
            initials: 'AW',
            photo: "{{ asset('assets/images/foto/Ardy Wicaksono, M.Kom..png') }}"
        },
        'agatha': {
            name: 'Agatha Pricillia Sekar Tamtomo, S.M., M.M.',
            role: 'Deputi Lab FTHB',
            dept: 'Fakultas Teknologi, Hukum, & Bisnis (FTHB)',
            labs: ['Lab IoT', 'Lab ICT Lt.1', 'Lab ICT Lt.2', 'Lab Multimedia', 'Mootcourt'],
            desc: 'Mengoordinasikan pengelolaan laboratorium FTHB, meliputi penjadwalan penggunaan, kesiapan sarana, dan pemeliharaan peralatan. Mengawasi kinerja laboran, menyusun usulan kebutuhan alat dan perbaikan, serta menyampaikan laporan operasional laboratorium secara berkala.',
            badge: 'Deputi Lab FTHB',
            initials: 'AP',
            photo: "{{ asset('assets/images/foto/Agatha Pricillia Sekar Tamtomo, S.M., M.M..png') }}"
        },
        'salsabila': {
            name: 'Salsabila Amalia Putri Bumi, S.T.P., M.T.P.',
            role: 'Deputi Lab FITH',
            dept: 'Fakultas Ilmu Terapan & Halal (FITH)',
            labs: ['Lab Mikrobiologi', 'Lab Kuliner', 'Lab Kimia', 'Lab AZG', 'Lab PSG', 'Lab TekPang'],
            desc: 'Mengoordinasikan pengelolaan laboratorium FITH, meliputi penjadwalan, inventarisasi bahan dan alat, serta kalibrasi dan pemeliharaan instrumen. Memastikan penerapan standar K3 dan kebersihan laboratorium, mengawasi kinerja laboran, dan menyusun laporan operasional secara berkala.',
            badge: 'Deputi Lab FITH',
            initials: 'SA',
            photo: "{{ asset('assets/images/foto/Salsabila Amalia Putri Bumi, S.T.P., M.T.P..png') }}"
        },
        'sahrul': {
            name: 'Sahrul, S.Kom.',
            role: 'Staff IT',
            dept: 'Divisi Software Dev. & IT Support',
            labs: ['Programming', 'Trouble Shooting & Jaringan'],
            desc: 'Mengembangkan, memelihara, dan mendukung operasional sistem informasi serta infrastruktur jaringan di lingkungan kampus. Menangani permintaan dukungan teknis dari dosen, mahasiswa, dan unit kerja, termasuk perawatan perangkat komputer dan instalasi perangkat lunak. Melakukan pemecahan masalah perangkat keras, perangkat lunak, dan jaringan, serta melaporkan kondisi dan kebutuhan perbaikan kepada Deputi.',
            badge: 'Staff IT',
            initials: 'SH',
            photo: "{{ asset('assets/images/foto/Sahrul, S.Kom..png') }}"
        },
        'nathan': {
            name: 'Yonathan Tanjung, S.Kom.',
            role: 'Full Time',
            dept: 'Divisi Software Dev. & IT Support',
            labs: ['Programming', 'Jaringan & IT Support'],
            desc: 'Merancang, mengembangkan, memelihara, dan mengamankan sistem informasi kampus, mencakup pembuatan fitur baru, perbaikan bug, dan pengelolaan basis data. Mengelola dan menjaga infrastruktur jaringan kampus, meliputi konfigurasi router, switch, dan access point, memantau kestabilan koneksi, serta menangani gangguan jaringan kabel maupun nirkabel. Melakukan pengujian sebelum rilis, menyusun dokumentasi teknis, dan memastikan seluruh sistem serta layanan IT kampus berjalan stabil dan aman.',
            badge: 'Full Time',
            initials: 'YT',
            photo: "{{ asset('assets/images/foto/Yonathan Tanjung, S.Kom..png') }}"
        },
        'fajri': {
            name: 'Al Fajri Ridho Hidayat, S.Kom.',
            role: 'Full Time',
            dept: 'Divisi Software Dev. & IT Support',
            labs: ['Programming', 'Jaringan & IT Support'],
            desc: 'Merancang, mengembangkan, memelihara, dan mengamankan sistem informasi kampus, mencakup pembuatan fitur baru, perbaikan bug, dan pengelolaan basis data. Mengelola dan menjaga infrastruktur jaringan kampus, meliputi konfigurasi router, switch, dan access point, memantau kestabilan koneksi, serta menangani gangguan jaringan kabel maupun nirkabel. Melakukan pengujian sebelum rilis, menyusun dokumentasi teknis, dan memastikan seluruh sistem serta layanan IT kampus berjalan stabil dan aman.',
            badge: 'Full Time',
            initials: 'AF',
            photo: "{{ asset('assets/images/foto/Al Fajri Ridho Hidayat, S.Kom..png') }}"
        },
        'faruq_magang': {
            name: 'Muhamad Faruq',
            role: 'Magang, Website Management',
            dept: 'Divisi Web & Digital Marketing',
            labs: ['Wordpress Management', 'Update Konten Website'],
            desc: 'Mengelola seluruh website kampus, meliputi pembaruan konten, publikasi artikel, pengumuman, dan jadwal, serta pemeliharaan tampilan dan fungsi situs. Memantau ketersediaan dan keamanan website, serta berkoordinasi dengan Deputi Web & Digital Marketing dalam pelaksanaannya.',
            badge: 'Magang (Website)',
            initials: 'MF',
            photo: "{{ asset('assets/images/foto/Muhamad Faruq.png') }}"
        },
        'novela_magang': {
            name: 'Novela Putri Puspasari',
            role: 'Magang, Website Management',
            dept: 'Divisi Web & Digital Marketing',
            labs: ['Wordpress Management', 'Update Konten Website'],
            desc: 'Mengelola seluruh website kampus, meliputi pembaruan konten, publikasi artikel, pengumuman, dan jadwal, serta pemeliharaan tampilan dan fungsi situs. Memantau ketersediaan dan keamanan website, serta berkoordinasi dengan Deputi Web & Digital Marketing dalam pelaksanaannya.',
            badge: 'Magang (Website)',
            initials: 'NP',
            photo: "{{ asset('assets/images/foto/Novela Putri Puspasari.png') }}"
        },
        'faruq_laboran': {
            name: 'Muhamad Faruq',
            role: 'Laboran FTHB',
            dept: 'Laboratorium FTHB',
            labs: ['Lab IoT', 'Lab ICT Lt.2', 'Lab Multimedia'],
            desc: 'Menyiapkan ruang dan peralatan praktikum laboratorium FTHB sebelum perkuliahan, serta memastikan perangkat dan jaringan berfungsi baik. Mendampingi pelaksanaan praktikum, mencatat peminjaman alat, dan melaporkan kerusakan kepada Deputi Lab FTHB.',
            badge: 'Laboran FTHB',
            initials: 'MF',
            photo: "{{ asset('assets/images/foto/Muhamad Faruq.png') }}"
        },
        'novela_laboran': {
            name: 'Novela Putri Puspasari',
            role: 'Laboran FTHB',
            dept: 'Laboratorium FTHB',
            labs: ['Lab ICT Lt.1', 'Mootcourt'],
            desc: 'Mendampingi dosen dan mahasiswa selama praktikum di laboratorium FTHB, serta mengelola inventaris dan peminjaman alat. Menjaga ketertiban dan kebersihan ruang laboratorium, dan melaporkan kondisi peralatan kepada Deputi Lab FTHB.',
            badge: 'Laboran FTHB',
            initials: 'NP',
            photo: "{{ asset('assets/images/foto/Novela Putri Puspasari.png') }}"
        },
        'wida': {
            name: 'Widasari Atrilania Sri Kunciati, S.T.P.',
            role: 'Laboran FITH',
            dept: 'Laboratorium FITH',
            labs: ['Lab Mikrobiologi', 'Lab Kuliner', 'Lab Kimia'],
            desc: 'Menyiapkan bahan, alat gelas, dan instrumen praktikum di laboratorium FITH, termasuk sterilisasi peralatan. Memantau stok bahan habis pakai, menerapkan prosedur K3 dan kebersihan, serta melaporkan kebutuhan kepada Deputi Lab FITH.',
            badge: 'Laboran FITH',
            initials: 'WA',
            photo: "{{ asset('assets/images/foto/Widasari Atrilania Sri Kunciati, S.T.P.png') }}"
        },
        'rika': {
            name: 'Rika Wahyuningsih, A.Md.Si.',
            role: 'Laboran FITH',
            dept: 'Laboratorium FITH',
            labs: ['Lab AZG', 'Lab PSG', 'Lab TekPang'],
            desc: 'Menyiapkan bahan dan alat praktikum untuk laboratorium analisis zat gizi dan teknologi pangan, serta merawat instrumen analitik dan penimbangan. Mencatat inventaris dan logbook penggunaan alat, serta menjaga kebersihan dan keselamatan kerja di laboratorium.',
            badge: 'Laboran FITH',
            initials: 'RW',
            photo: "{{ asset('assets/images/foto/Rika Wahyuningsih, A. Md. Si.png') }}"
        }
    };

    // Fungsi membuka modal detail ketika salah satu card diklik
    function openPersonDetail(personKey) {
        const data = orgMembersData[personKey];
        if (!data) return;

        // Isi data modal
        document.getElementById('detailPersonName').textContent = data.name;
        document.getElementById('detailPersonRoleTag').textContent = data.badge;
        document.getElementById('detailPersonRoleSub').textContent = data.role;
        document.getElementById('detailPersonDept').textContent = data.dept;
        document.getElementById('detailPersonDesc').textContent = data.desc;

        // Render Labs sebagai Badge Pills
        const labsContainer = document.getElementById('detailPersonLabsList');
        labsContainer.innerHTML = '';
        if (Array.isArray(data.labs) && data.labs.length > 0) {
            data.labs.forEach(function (lab) {
                const span = document.createElement('span');
                span.className = 'detail-lab-pill';
                span.textContent = lab;
                labsContainer.appendChild(span);
            });
            document.getElementById('detailPersonLabRow').style.display = 'flex';
        } else {
            document.getElementById('detailPersonLabRow').style.display = 'none';
        }

        document.getElementById('detailPersonBadge').textContent = data.badge;
        document.getElementById('detailPersonInitials').textContent = data.initials;

        // Kontrol Foto Profil Full vs Fallback Avatar
        const photoEl = document.getElementById('detailPersonPhoto');
        const fallbackEl = document.getElementById('detailPersonAvatarFallback');

        if (data.photo && data.photo.trim() !== '') {
            photoEl.src = data.photo;
            photoEl.classList.remove('is-hidden');
            fallbackEl.classList.add('is-hidden');
        } else {
            photoEl.classList.add('is-hidden');
            fallbackEl.classList.remove('is-hidden');
        }

        // Tampilkan modal menggunakan Bootstrap 5
        const modalEl = document.getElementById('modalDetailPerson');
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }

    function handlePhotoError() {
        const photoEl = document.getElementById('detailPersonPhoto');
        const fallbackEl = document.getElementById('detailPersonAvatarFallback');
        if (photoEl) photoEl.classList.add('is-hidden');
        if (fallbackEl) fallbackEl.classList.remove('is-hidden');
    }

    // Fungsi bantu menengahkan bagan di layar mobile agar langsung memperlihatkan pimpinan
    function centerOrgChartOnMobile() {
        const viewport = document.querySelector('.org-chart-viewport');
        const canvas = document.querySelector('.org-chart-canvas');
        if (viewport && canvas) {
            const scrollTarget = (canvas.scrollWidth - viewport.clientWidth) / 2;
            if (scrollTarget > 0) {
                viewport.scrollLeft = scrollTarget;
            }
        }
    }

    // Pastikan modal bertumpuk (nested modal) bekerja mulus
    document.addEventListener('DOMContentLoaded', function () {
        // Tengahkan bagan pada load jika di mobile
        if (window.innerWidth < 992) {
            setTimeout(centerOrgChartOnMobile, 200);
        }

        // Tengahkan juga ketika modal induk (#modalOrganisasi) dibuka
        const parentModal = document.getElementById('modalOrganisasi');
        if (parentModal) {
            parentModal.addEventListener('shown.bs.modal', function () {
                setTimeout(centerOrgChartOnMobile, 120);
            });
        }

        const detailModal = document.getElementById('modalDetailPerson');
        if (detailModal) {
            // Pindahkan modal ke document.body agar tidak terpotong oleh overflow-hidden container
            if (detailModal.parentElement !== document.body) {
                document.body.appendChild(detailModal);
            }

            // Atur backdrop jika dibuka di atas modal lain
            detailModal.addEventListener('show.bs.modal', function () {
                setTimeout(function () {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 1) {
                        backdrops[backdrops.length - 1].style.zIndex = '1080';
                    }
                }, 10);
            });

            // Kembalikan class modal-open jika modal parent masih terbuka
            detailModal.addEventListener('hidden.bs.modal', function () {
                if (document.querySelector('.modal.show')) {
                    document.body.classList.add('modal-open');
                }
            });
        }

        // Keyboard Accessibility (Enter / Space to activate card)
        document.querySelectorAll('.org-card, .org-bottom-banner').forEach(function (card) {
            card.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
        });
    });
</script>
