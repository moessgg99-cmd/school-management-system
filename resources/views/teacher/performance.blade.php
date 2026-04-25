@extends('layouts.app')

@section('title', 'Performance')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header -->
    <div class="mb-8 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase">FACULTY ANALYTICS</h1>
            <p class="text-slate-400 font-medium text-sm">Real-time data visualization of teacher performance</p>
        </div>
        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
            <i class="fas fa-chart-pie text-xl"></i>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- 1. Teaching Load Chart (Bar Chart) -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-2 h-8 bg-indigo-500 rounded-full"></div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wider">Teaching Load</h3>
            </div>
            <p class="text-xs text-slate-400 mb-6 italic">Total assigned classes per faculty member</p>
            <div class="relative h-[300px]">
                <canvas id="loadChart"></canvas>
            </div>
        </div>

        <!-- 2. Experience Distribution (Doughnut Chart) -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-2 h-8 bg-emerald-500 rounded-full"></div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wider">Experience Level</h3>
            </div>
            <p class="text-xs text-slate-400 mb-6 italic">Teacher distribution based on years of exp</p>
            <div class="relative h-[300px] flex justify-center">
                <canvas id="expChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // ၁။ LocalStorage ကနေ data ဆွဲယူမယ်
        const teacherList = JSON.parse(localStorage.getItem('myTeachers')) || [];

        if (teacherList.length === 0) {
            console.log("No data for charts");
            return;
        }

        // ၂။ Data တွေကို Chart အတွက် ပြင်ဆင်မယ် (Mapping)
        const names = teacherList.map(t => t.name);
        // ဆရာမတစ်ယောက်စီရဲ့ classes ကို split လုပ်ပြီး အရေအတွက်ယူမယ်
        const classCounts = teacherList.map(t => t.classes.split(',').length);
        const expLevels = teacherList.map(t => parseInt(t.exp));

        // --- CHART 1: Teaching Load (Bar Chart) ---
        new Chart(document.getElementById('loadChart'), {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: 'Number of Classes',
                    data: classCounts,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)', // Indigo
                    borderRadius: 12,
                    hoverBackgroundColor: '#4f46e5'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- CHART 2: Experience (Doughnut Chart) ---
        new Chart(document.getElementById('expChart'), {
            type: 'doughnut',
            data: {
                labels: names,
                datasets: [{
                    data: expLevels,
                    backgroundColor: [
                        '#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'
                    ],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                },
                cutout: '70%' // Doughnut ဖြစ်အောင် အလယ်မှာ အပေါက်ဖောက်မယ်
            }
        });
    });
</script>

@endsection