@extends('layouts.app')

@section('title', 'Performance')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header Section -->
    <div
        class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase">Class Timetables</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Manage weekly schedules by grade and section</p>
        </div>

        <div class="flex items-center gap-4">
            <select id="classSelect" onchange="renderTimetable()"
                class="bg-slate-50 border-none rounded-2xl px-6 py-3 font-bold text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer shadow-sm">
                <option value="10-A">Grade 10-A</option>
                <option value="10-B">Grade 10-B</option>
                <option value="9-A">Grade 9-A</option>
                <option value="8-C">Grade 8-C</option>
            </select>
            <button onclick="window.print()"
                class="bg-slate-800 text-white p-3 rounded-2xl hover:bg-slate-900 transition-all shadow-lg">
                <i class="fas fa-print"></i>
            </button>
        </div>
    </div>

    <!-- Timetable Grid -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th
                            class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 w-32 border-r border-slate-100/50">
                            TIME</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">MON</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">TUE</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">WED</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">THU</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">FRI</th>
                    </tr>
                </thead>
                <tbody id="timetableBody" class="divide-y divide-slate-50">
                    <!-- JS will generate rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {

        aside,
        nav,
        .no-print,
        button,
        select {
            display: none !important;
        }

        .max-w-7xl {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .shadow-xl {
            box-shadow: none !important;
            border: 1px solid #eee !important;
        }
    }
</style>

<script>
    const times = ["09:00 - 10:00", "10:00 - 11:00", "11:00 - 12:00", "12:00 - 01:00", "01:00 - 02:00", "02:00 - 03:00", "03:00 - 04:00"];
    const days = ["Mon", "Tue", "Wed", "Thu", "Fri"];

    const subjects = [
        { name: "Mathematics", color: "bg-blue-500", text: "text-blue-50" },
        { name: "English", color: "bg-indigo-500", text: "text-indigo-50" },
        { name: "Myanmar", color: "bg-orange-500", text: "text-orange-50" },
        { name: "Physics", color: "bg-purple-500", text: "text-purple-50" },
        { name: "Chemistry", color: "bg-emerald-500", text: "text-emerald-50" },
        { name: "Biology", color: "bg-rose-500", text: "text-rose-50" }
    ];

    function renderTimetable() {
        const tbody = document.getElementById('timetableBody');
        const selectedClass = document.getElementById('classSelect').value;

        tbody.innerHTML = times.map((time, tIdx) => `
            <tr class="group hover:bg-slate-50/50 transition-all">
                <td class="p-6 text-center border-r border-slate-100 font-black text-slate-400 text-[11px] bg-slate-50/30">${time}</td>
                ${days.map((day, dIdx) => {
            // Lunch Break Logic
            if (time === "12:00 - 01:00") {
                return dIdx === 0 ? `<td colspan="5" class="p-2 text-center bg-slate-50/50 font-black text-slate-300 text-[10px] tracking-[0.5em] uppercase">Lunch Break</td>` : '';
            }

            // Randomly assign subjects based on class/day/time for portfolio visual
            // In a real app, this would come from a database
            const seed = (selectedClass.charCodeAt(0) + tIdx + dIdx);
            const sub = subjects[seed % subjects.length];
            const isFree = seed % 7 === 0;

            return `
                        <td class="p-2 border-r border-slate-50 min-w-[140px]">
                            ${!isFree ? `
                                <div class="${sub.color} p-3 rounded-2xl shadow-lg shadow-slate-200 transform hover:scale-[1.02] transition-all cursor-pointer border-l-4 border-black/10">
                                    <p class="text-[9px] font-black ${sub.text} opacity-70 uppercase mb-1">Subject</p>
                                    <p class="text-white font-bold text-xs truncate">${sub.name}</p>
                                </div>
                            ` : `
                                <div class="h-12 border-2 border-dashed border-slate-100 rounded-2xl flex items-center justify-center">
                                    <span class="text-[9px] text-slate-200 font-bold uppercase tracking-tighter">Free Period</span>
                                </div>
                            `}
                        </td>
                    `;
        }).join('')}
            </tr>
        `).join('');
    }

    document.addEventListener("DOMContentLoaded", renderTimetable);
</script>

@endsection