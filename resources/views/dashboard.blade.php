@extends('layouts.app')

@section('content')
    <div class="app-content pt-5 p-md-4 p-lg-4 pb-2">
        <div class="container-xl">
            {{-- ===== WELCOME BANNER ===== --}}
            @php
                $user      = auth()->user();
                $userName  = $user ? $user->name : 'User';
                $initials  = collect(explode(' ', $userName))
                                ->take(2)
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->implode('');
                $quotes = [
                    '"Success is not final, failure is not fatal: it is the courage to continue that counts."',
                    '"The secret of getting ahead is getting started."',
                    '"Don\'t watch the clock; do what it does. Keep going."',
                    '"Great things never come from comfort zones."',
                ];
                $quote = $quotes[array_rand($quotes)];
            @endphp
            <div class="row mb-4">
                <div class="col-12">
                    <div class="rounded-3 shadow-sm px-4 py-4"
                         style="background: linear-gradient(135deg, #15a362 0%, #0b7044 100%); color:#fff; overflow:hidden; position:relative;">
                        <!-- decorative circles -->
                        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none;"></div>
                        <div style="position:absolute;bottom:-50px;right:80px;width:130px;height:130px;border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="fw-bold mb-1" style="color:#fff;">
                                    Selamat Datang, {{ $userName }}! 👋
                                </h3>
                                <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:.93rem;">
                                    Let's do The Work and Have a Nice Day
                                </p>
                            </div>
                            <div class="col-auto text-end d-none d-md-block">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <div style="width:70px;height:70px;border-radius:50%;border:3px solid rgba(255,255,255,.6);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:#fff;background:rgba(255,255,255,.15);">
                                        {{ $initials }}
                                    </div>
                                    <p class="mb-0 fst-italic text-center" style="color:rgba(255,255,255,.75); font-size:.78rem; max-width:220px;">
                                        {{ $quote }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ===== END WELCOME BANNER ===== --}}
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-4">
                    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder" style="background: rgb(217, 241, 255)">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt"
                                            fill="blue" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                            <path fill-rule="evenodd"
                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                    </div><!--//icon-holder-->

                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Invoices In</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4">

                            <div class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                aliquet eros vel diam semper mollis.</div>
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto">
                            <a class="btn app-btn-secondary" href="{{ route('invoiceIn.index') }}">Create New</a>
                        </div><!--//app-card-footer-->
                    </div><!--//app-card-->
                </div><!--//col-->
                <div class="col-12 col-lg-4">
                    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder" style="background: rgb(225, 255, 225)">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                            <path fill-rule="evenodd"
                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                    </div><!--//icon-holder-->

                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Invoices Out</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4">

                            <div class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                aliquet eros vel diam semper mollis.</div>
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto">
                            <a class="btn app-btn-secondary" href="{{ route('invoiceOut.index') }}">Create New</a>
                        </div><!--//app-card-footer-->
                    </div><!--//app-card-->
                </div><!--//col-->
                <div class="col-12 col-lg-4">
                    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder" style="background: rgb(253, 220, 220)">
                                        <!-- Contoh menggunakan SVG gambar sepatu -->
                                        <div>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-shoe"
                                                fill="red" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M4.5 5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5V5zM1.5 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-.5zm8-6a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5V6.5zm-8 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5V6.5zM13.5 2a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h11z" />
                                            </svg>
                                        </div>
                                    </div><!--//icon-holder-->
                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Shoes</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4">

                            <div class="intro">Pellentesque varius, elit vel volutpat sollicitudin, lacus quam
                                efficitur augue</div>
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto">
                            <a class="btn app-btn-secondary" href="{{ route('sepatu.index') }}">Lihat</a>
                        </div><!--//app-card-footer-->
                    </div><!--//app-card-->
                </div><!--//col-->
            </div><!--//row-->

            {{-- ===== BAR CHART: Transaksi Bulanan ===== --}}
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="app-card app-card-stats-table shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">
                                        <i class="fa-solid fa-chart-bar me-2 text-primary"></i>
                                        Grafik Transaksi Bulanan
                                    </h4>
                                </div>
                                <div class="col-auto">
                                    <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2">
                                        <label for="yearSelect" class="me-2 mb-0 fw-semibold text-muted small">Tahun:</label>
                                        <select id="yearSelect" name="year" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                                            @foreach ($years as $yr)
                                                <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>{{ $yr }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="app-card-body p-3 p-lg-4">
                            <canvas id="chart-bar-monthly" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div><!--//row bar chart-->

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctxBar = document.getElementById('chart-bar-monthly').getContext('2d');
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($months) !!},
                            datasets: [
                                {
                                    label: 'Invoice In',
                                    data: {!! json_encode($invoiceInMonthly) !!},
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    borderRadius: 4
                                },
                                {
                                    label: 'Invoice Out',
                                    data: {!! json_encode($invoiceOutMonthly) !!},
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    borderRadius: 4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Nominal Transaksi per Bulan – Tahun {{ $selectedYear }}',
                                    font: { size: 13 }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1, precision: 0 },
                                    title: { display: true, text: 'Nominal (Rp)' }
                                },
                                x: {
                                    title: { display: true, text: 'Bulan' }
                                }
                            }
                        }
                    });
                });
            </script>
            {{-- ===== END BAR CHART ===== --}}

            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="app-card app-card-stats-table h-100 shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">Invoice Chart</h4>
                                </div><!--//col-->
                                <div class="col-auto d-flex align-items-center gap-2">
                                    <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2">
                                        <label class="mb-0 fw-semibold text-muted small">Tahun:</label>
                                        <select name="year" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                                            @foreach ($years as $yr)
                                                <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>{{ $yr }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body p-3 p-lg-4">
                            <div class="app-card-body p-1">
                                <div class="chart-container">
                                    <canvas id="chart-donut" height="125"></canvas>
                                </div>
                            </div><!--//app-card-body-->
                        </div><!--//app-card-body-->
                    </div><!--//app-card-->
                </div><!--//col-->

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('chart-donut').getContext('2d');
                        var donutChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Invoice In', 'Invoice Out'], // Replace with dynamic labels as needed
                                datasets: [{
                                    data: [{{ $invoiceInYear }}, {{ $invoiceOutYear }}],
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.2)', // Invoice In (biru)
                                        'rgba(75, 192, 192, 0.2)' // Invoice Out (hijau)
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)', // Invoice In (biru)
                                        'rgba(75, 192, 192, 1)' // Invoice Out (hijau)
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'right', // Move the legend to the right side
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                var label = context.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.parsed !== null) {
                                                    label += context.parsed;
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                }
                            }
                        });


                    });
                </script>


                <div class="col-12 col-lg-6">
                    <div class="app-card app-card-stats-table h-100 shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">Shoes</h4>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <div class="card-header-action">
                                        <a href="{{ route('sepatu.index') }}">View</a>
                                    </div><!--//card-header-actions-->
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body p-3 p-lg-4">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th class="meta">Shoes</th>
                                            <th class="meta stat-cell text-center">Harga</th>
                                            <th class="meta stat-cell">Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Mengambil 5 data terbaru dengan mengurutkan dari yang terbaru ke yang terlama
                                            $latestShoes = $sepatu->sortByDesc('created_at')->take(5);
                                        @endphp

                                        @foreach ($latestShoes as $item)
                                            <tr>
                                                <td><a href="#file-link" data-bs-toggle="modal"
                                                        data-bs-target="#viewSepatuModal_{{ $item->id }}">{{ $item->kode }}</a>
                                                </td>
                                                <td class="stat-cell text-center">Rp. {{ $item->harga }}</td>
                                                <td class="stat-cell">{{ date('d M Y', strtotime($item->created_at)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!--//table-responsive-->
                        </div><!--//app-card-body-->
                    </div><!--//app-card-->
                </div><!--//col-->
                @foreach ($sepatu as $item)
                    <div class="modal fade" id="viewSepatuModal_{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="viewSepatuModalLabel_{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewSepatuModalLabel_{{ $item->id }}">
                                        {{ $item->kode }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset('foto/' . $item->gambar) }}" alt="Foto Sepatu" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div><!--//container-fluid-->
    </div><!--//app-content pb-0-->
@endsection
