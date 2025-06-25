@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-black dark:text-white">
    <h2 class="text-xl font-bold mb-4">Gemiddelde verzuim voor klas: {{ $klas }}</h2>
    <div class="text-lg mb-6">
        Gemiddelde verzuim: <span class="font-semibold">{{ number_format($gemiddelde, 1, ',', '.') }}%</span><br>
        Geoorloofd afwezig: <span class="font-semibold">{{ number_format($geoorloofd, 1, ',', '.') }}%</span><br>
        Ongeoorloofd afwezig: <span class="font-semibold">{{ number_format($ongeoorloofd, 1, ',', '.') }}%</span><br>
        Niet geregistreerde lestijd: <span class="font-semibold">{{ number_format($nietGeregistreerd, 1, ',', '.') }}%</span>
    </div>
    <canvas id="verzuimPie" width="300" height="300"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('verzuimPie').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Aanwezig', 'Geoorloofd afwezig', 'Ongeoorloofd afwezig', 'Niet geregistreerd'],
                datasets: [{
                    data: [
                        {{ number_format($gemiddelde, 1, '.', '') }},
                        {{ number_format($geoorloofd, 1, '.', '') }},
                        {{ number_format($ongeoorloofd, 1, '.', '') }},
                        {{ number_format($nietGeregistreerd, 1, '.', '') }}
                    ],
                    backgroundColor: [
                        '#22c55e', // green
                        '#facc15', // yellow
                        '#ef4444', // red
                        '#64748b'  // gray
                    ],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                        }
                    }
                }
            }
        });
    </script>
    <a href="{{ route('verzuim.upload.form') }}" class="inline-block mt-4 underline text-blue-700 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100">Opnieuw uploaden</a>
</div>
@endsection
