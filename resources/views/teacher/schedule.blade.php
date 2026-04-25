@extends('layouts.app')

@section('title', 'Teacher Schedule')

@section('content')

<!-- === 1. HTML Section === -->
<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase">FACULTY SCHEDULES</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Weekly Academic Timetable Management</p>
        </div>
        
        <!-- Teacher Filter -->
        <div class="flex items-center gap-4">
            <div class="relative">
                <select id="teacherSelect" onchange="loadSchedule()" class="appearance-none bg-slate-50 border-none rounded-2xl pl-12 pr-10 py-3 font-bold text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer transition-all shadow-sm">
                    <option value="">Select Instructor</option>
                </select>
                <i class="fas fa-user-tie absolute left-4 top-4 text-slate-300"></i>
            </div>
            <button onclick="window.print()" class="bg-slate-800 text-white p-3 rounded-2xl hover:bg-slate-900 transition-all shadow-lg active:scale-95">
                <i class="fas fa-print"></i>
            </button>
        </div>
    </div>

    <!-- Schedule Grid Table -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 w-32 border-r border-slate-100/50">TIME SLOTS</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">MONDAY</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">TUESDAY</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">WEDNESDAY</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">THURSDAY</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-800">FRIDAY</th>
                    </tr>
                </thead>
                <tbody id="scheduleBody" class="divide-y divide-slate-50">
                    <!-- Data will be injected here via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- === 2. STYLE Section === -->
<style>
    /* Keyboard Arrows ဖျောက်ရန် */
    input::-webkit-outer-spin-button, 
    input::-webkit-inner-spin-button {
        -webkit-appearance: none; margin: 0;
    }
    input[type=number] { -moz-appearance: textfield; }

    /* Print လုပ်တဲ့အခါ Sidebar တွေနဲ့ ခလုတ်တွေကို ဖျောက်ဖို့ */
    @media print {
        aside, nav, .no-print, button, select, i {
            display: none !important;
        }
        body {
            background-color: white !important;
            padding: 0 !important;
        }
        .max-w-7xl {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        /* .rounded-[2.5rem], .shadow-xl {
            border-radius: 0 !important;
            box-shadow: none !important;
            border: 1px solid #e2e8f0 !important;
        } */
    }
</style>

<!-- === 3. SCRIPT Section === -->
<script>
    const timeSlots = ["09:00 - 10:00", "10:00 - 11:00", "11:00 - 12:00", "12:00 - 01:00", "01:00 - 02:00", "02:00 - 03:00", "03:00 - 04:00"];
    const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

    document.addEventListener("DOMContentLoaded", () => {
        // ၁။ LocalStorage ကနေ ဆရာမစာရင်းကို ယူမယ်
        const teacherList = JSON.parse(localStorage.getItem('myTeachers')) || [];
        const select = document.getElementById('teacherSelect');
        
        teacherList.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.name;
            opt.textContent = t.name;
            select.appendChild(opt);
        });
        
        renderGrid(); // အစမှာ အလွတ်ပြထားမယ်
    });

    function renderGrid(teacherName = "") {
        const tbody = document.getElementById('scheduleBody');
        const teacherList = JSON.parse(localStorage.getItem('myTeachers')) || [];
        const teacher = teacherList.find(t => t.name === teacherName);

        tbody.innerHTML = timeSlots.map((time, timeIdx) => `
            <tr class="group hover:bg-slate-50/50 transition-all">
                <td class="p-6 text-center border-r border-slate-100 font-black text-slate-400 text-[11px] bg-slate-50/30 group-hover:text-indigo-500">${time}</td>
                ${days.map((day, dayIdx) => {
                    // --- Portfolio Logic: ဆရာမတစ်ယောက်စီအတွက် အတန်းတွေ အလိုအလျောက် ခွဲဝေပေးမယ် ---
                    // နာမည်ရွေးထားမှသာ အတန်းတွေ ပြပေးမယ်
                    let classInfo = "";
                    if (teacher && teacher.classes) {
                        const classArray = teacher.classes.split(',');
                        // Random ဆန်ဆန် အတန်းတွေ ဖြန့်ချပေးတဲ့ logic (Portfolio အတွက် အရမ်းမိုက်ပါတယ်)
                        if ((timeIdx + dayIdx) % 3 === 0 && time !== "12:00 - 01:00") {
                            classInfo = classArray[(timeIdx + dayIdx) % classArray.length].trim();
                        }
                    }

                    return `
                        <td class="p-2 border-r border-slate-50 min-h-[80px]">
                            ${classInfo !== "" ? `
                                <div class="bg-indigo-600 p-3 rounded-2xl shadow-lg shadow-indigo-200 transform hover:scale-105 transition-all cursor-pointer border-l-4 border-indigo-400">
                                    <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-1">${teacher.subject}</p>
                                    <p class="text-white font-bold text-xs">Class: ${classInfo}</p>
                                </div>
                            ` : `
                                <div class="h-12 border-2 border-dashed border-slate-100 rounded-2xl flex items-center justify-center">
                                     <span class="text-[9px] text-slate-200 font-bold uppercase">No Class</span>
                                </div>
                            `}
                        </td>
                    `;
                }).join('')}
            </tr>
        `).join('');
    }

    function loadSchedule() {
        const name = document.getElementById('teacherSelect').value;
        renderGrid(name);
    }
</script>

@endsection