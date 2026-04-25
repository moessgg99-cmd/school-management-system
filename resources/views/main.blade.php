@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- <div class="max-w-md pl-5">
    <div class="flex border border-gray-300 rounded-lg overflow-hidden">
        
        <input type="text" placeholder="Search..."
            class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <button class="flex items-center px-4 py-2 bg-blue-500 text-white rounded">
            <i class="fas fa-search mr-2 text-white text-lg"></i>
        </button>
    </div>
</div> -->

<div x-data="{ openModal: false }"
    class="flex flex-col md:flex-row items-center justify-between bg-white shadow px-4 py-2 ml-5 mr-5">
    <!-- Left: Search Bar -->
    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full md:w-1/3 mb-2 md:mb-0">
        <!-- Search Input -->
        <input type="text" placeholder="Search anything..." class="w-full px-3 py-2 border rounded focus:outline-none"
            @click="openModal = true">
        <button class="px-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-search mr-2 text-black text-lg"></i>
        </button>
    </div>

    <!-- Right: Actions -->
    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4 w-full md:w-auto">
        <button class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-clock text-xl"></i>
        </button>
        <div class="relative">
            <button class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-bell text-xl"></i>
            </button>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">1</span>
        </div>
        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold">
            AS
        </div>
    </div>

    <!-- Modal -->
    <template x-if="openModal">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click.self="openModal = false">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
                <h2 class="text-lg font-semibold mb-4">Search</h2>
                <input type="text" placeholder="Type to search..."
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="flex justify-end mt-4">
                    <button @click="openModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Enrollment -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Total Enrollment</h2>
        <canvas id="homeEnrollmentChart"></canvas>
    </div>

    <!-- Attendance -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Attendance Rate</h2>
        <canvas id="homeAttendanceChart"></canvas>
    </div>

    <!-- Grades -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Grades Distribution</h2>
        <canvas id="homeGradesChart"></canvas>
    </div>

    <!-- Fees -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Fees Collection</h2>
        <canvas id="homeFeesChart"></canvas>
    </div>

    <!-- Teachers Performance -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Teachers Performance</h2>
        <canvas id="homeTeachersChart"></canvas>
    </div>

    <!-- Activities -->
    <div class="bg-white rounded shadow-md p-4">
        <h2 class="text-lg font-bold mb-4">Activities Participation</h2>
        <canvas id="homeActivitiesChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enrollment (Bar)
    new Chart(document.getElementById('homeEnrollmentChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Students', data: [200, 220, 240, 260, 280],
                backgroundColor: 'rgba(59,130,246,0.7)'
            }]
        }
    });

    // Attendance (Line)
    new Chart(document.getElementById('homeAttendanceChart'), {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Attendance %', data: [92, 95, 90, 93],
                borderColor: 'rgba(16,185,129,1)', fill: false
            }]
        }
    });

    // Grades (Pie)
    new Chart(document.getElementById('homeGradesChart'), {
        type: 'pie',
        data: {
            labels: ['A', 'B', 'C', 'D', 'F'],
            datasets: [{
                data: [40, 30, 20, 7, 3],
                backgroundColor: ['#22c55e', '#3b82f6', '#eab308', '#f97316', '#ef4444']
            }]
        }
    });

    // Fees (Doughnut)
    new Chart(document.getElementById('homeFeesChart'), {
        type: 'doughnut',
        data: {
            labels: ['Collected', 'Outstanding'],
            datasets: [{
                data: [75, 25],
                backgroundColor: ['#22c55e', '#ef4444']
            }]
        }
    });

    // Teachers Performance (Bar)
    new Chart(document.getElementById('homeTeachersChart'), {
        type: 'bar',
        data: {
            labels: ['Math', 'Science', 'English', 'History'],
            datasets: [{
                label: 'Performance Rating', data: [4.5, 4.2, 4.7, 4.0],
                backgroundColor: 'rgba(234,179,8,0.7)'
            }]
        }
    });

    // Activities (Pie)
    new Chart(document.getElementById('homeActivitiesChart'), {
        type: 'pie',
        data: {
            labels: ['Sports', 'Music', 'Clubs', 'Others'],
            datasets: [{
                data: [35, 25, 30, 10],
                backgroundColor: ['#3b82f6', '#22c55e', '#f97316', '#a855f7']
            }]
        }
    });

    function logoutUser() {
        // ၁။ Login state ကို ဖျက်မယ်
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('currentUser');

        // ၂။ Login page ကို ပြန်ပို့မယ်
        window.location.href = '/login';
    };
</script>



@endsection