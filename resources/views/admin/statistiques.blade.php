@extends('layouts.admin')

@section('title', 'Statistiques Détaillées')

@section('content')
<div class="space-y-6">
    <!-- Graphiques principaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Utilisateurs par rôle -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Utilisateurs par rôle</h3>
            <canvas id="usersRoleChart" width="400" height="300"></canvas>
        </div>

        <!-- Contenus par région -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contenus par région</h3>
            <canvas id="contenusRegionChart" width="400" height="300"></canvas>
        </div>
    </div>

    <!-- Contenus par mois -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contenus créés par mois</h3>
        <canvas id="contenusMoisChart" width="400" height="220"></canvas>
    </div>

    <!-- Tableaux de données -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Utilisateurs par rôle -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Détail utilisateurs par rôle</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stats['users_par_role'] as $role)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-900">{{ $role->nom_role }}</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $role->utilisateurs_count }} utilisateurs
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contenus par région -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Détail contenus par région</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stats['contenus_par_region'] as $region)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-900">{{ $region->nom_region }}</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $region->contenus_count }} contenus
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Graphique utilisateurs par rôle
const usersRoleCtx = document.getElementById('usersRoleChart').getContext('2d');
const usersRoleChart = new Chart(usersRoleCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($stats['users_par_role']->pluck('nom_role')) !!},
        datasets: [{
            label: 'Nombre d\'utilisateurs',
            data: {!! json_encode($stats['users_par_role']->pluck('utilisateurs_count')) !!},
            backgroundColor: '#3B82F6',
            borderColor: '#2563EB',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Graphique contenus par région
const contenusRegionCtx = document.getElementById('contenusRegionChart').getContext('2d');
const contenusRegionChart = new Chart(contenusRegionCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($stats['contenus_par_region']->pluck('nom_region')) !!},
        datasets: [{
            data: {!! json_encode($stats['contenus_par_region']->pluck('contenus_count')) !!},
            backgroundColor: [
                '#EF4444', '#F59E0B', '#10B981', '#3B82F6', 
                '#8B5CF6', '#EC4899', '#6B7280', '#84CC16'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Graphique contenus par mois
const contenusMoisCtx = document.getElementById('contenusMoisChart').getContext('2d');
const contenusMoisChart = new Chart(contenusMoisCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($stats['contenus_par_mois']->pluck('mois')->map(fn($m) => sprintf('%02d', $m))) !!},
        datasets: [{
            label: 'Contenus créés',
            data: {!! json_encode($stats['contenus_par_mois']->pluck('count')) !!},
            borderColor: '#15803d',
            backgroundColor: 'rgba(21, 128, 61, 0.1)',
            tension: 0.25,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#15803d'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        },
        plugins: {
            legend: { display: true, position: 'bottom' }
        }
    }
});
</script>
@endsection