@include('shared.html')

@include('shared.head', ['pageTitle' => 'Skup surowców'])

<body>
    @include('shared.navbar')

    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/carousel1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/carousel2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="container mt-5">
        <div class="row">
            <h1>Surowce</h1>
        </div>
        <div class="row">
            @forelse ($randomMaterials as $material)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset('storage/img/' . $material->img) }}" class="card-img-top"
                                alt="{{ $material->name }}">
                            <div class="card-img-overlay d-flex justify-content-end align-items-start">
                                <h5 class="badge bg-primary text-white">{{ $material->price_for_ton }} zł/ton</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $material->name }}</h5>
                            <p class="card-text">{{ $material->type }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center">
                            <a href="{{ route('materials.show', $material->id) }}" class="btn btn-primary w-100">Więcej
                                szczegółów...</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Brak surowców.</p>
            @endforelse
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Cennik</h1>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Typ surowca</th>
                        <th scope="col">Nazwa surowca</th>
                        <th scope="col">Cena za tonę</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $material)
                        <tr>
                            <th scope="row">{{ $material->id }}</th>
                            <td>{{ $material->type }}</td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->price_for_ton }} PLN</td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan="6">Brak surowców.</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Odchylenie Cen Surowców od Średniej</h1>
        </div>
        <canvas id="priceDeviationChart"></canvas>
    </div>




    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Statystyki cen materiałów</h1>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nazwa surowca</th>
                        <th scope="col">Typ surowca</th>
                        <th scope="col">Cena za tonę</th>
                        <th scope="col">Odchylenie od średniej ceny</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materialStats as $stat)
                        <tr>
                            <td class="align-middle">{{ $stat['name'] }}</td>
                            <td class="align-middle">{{ $stat['type'] }}</td>
                            <td class="align-middle">{{ number_format($stat['price_for_ton'], 2) }} PLN</td>
                            <td class="align-middle">{{ number_format($stat['price_deviation'], 2) }} PLN</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="align-middle">Brak danych do wyświetlenia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Dominanta typu surowca</h1>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Typ surowca</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">{{ $dominantType }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Kwantyle ceny za tonę</h1>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Kwantyl</th>
                        <th scope="col">Cena za tonę (PLN)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">Q1 (25%)</td>
                        <td class="align-middle">{{ number_format($quantiles['q1'], 2) }} PLN</td>
                    </tr>
                    <tr>
                        <td class="align-middle">Q2 (50%)</td>
                        <td class="align-middle">{{ number_format($quantiles['q2'], 2) }} PLN</td>
                    </tr>
                    <tr>
                        <td class="align-middle">Q3 (75%)</td>
                        <td class="align-middle">{{ number_format($quantiles['q3'], 2) }} PLN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Liczba dostępnych surowców według ich typu</h1>
        </div>
        <div class="d-flex justify-content-center">
            <canvas id="materialTypeChart" style="width: 500px; height: 500px;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('materialTypeChart').getContext('2d');
            const materialTypes = @json($materialTypes);
            const labels = Object.keys(materialTypes);
            const data = Object.values(materialTypes);

            const materialTypeChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Rozkład Surowców według Typu'
                        }
                    }
                },
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('priceDeviationChart').getContext('2d');
            const chartData = @json($materialStats);

            const labels = chartData.map(item => item.name);
            const data = chartData.map(item => item.price_deviation);

            const priceDeviationChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Odchylenie od średniej ceny (PLN)',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .thead-dark th {
            background-color: #343a40;
            color: white;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
        }
    </style>


    @include('shared.footer', ['fixedBottom' => false])

    </html>
