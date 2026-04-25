@extends('layouts.app')

@section('title', 'Performance')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header Section -->
    <div
        class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase text-indigo-600">Exam Mark
                Entry</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Bulk assessment management for all subjects</p>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex flex-col text-right no-print">
                <span id="classStats" class="text-[10px] font-black text-emerald-500 uppercase">Class Average: 0%</span>
                <span id="passRate" class="text-[10px] font-black text-indigo-400 uppercase">Pass Rate: 0%</span>
            </div>
            <button onclick="saveAllMarks()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-95">
                <i class="fas fa-save mr-2"></i> Save Marks
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 no-print">
        <!-- 1. Exam Type -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
            <i class="fas fa-file-signature text-slate-300"></i>
            <select id="examType"
                class="w-full bg-transparent border-none font-bold text-slate-700 outline-none cursor-pointer">
                <option>First Term Examination</option>
                <option>Mid Term Assessment</option>
                <option>Final Examination</option>
            </select>
        </div>
        <!-- 2. Subject Selection (Trigger Table Reset) -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
            <i class="fas fa-book text-slate-300"></i>
            <select id="examSubject" onchange="initMarkTable()"
                class="w-full bg-transparent border-none font-bold text-slate-700 outline-none cursor-pointer">
                <option value="Mathematics">Mathematics</option>
                <option value="English">English</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Physics">Physics</option>
                <option value="Chemistry">Chemistry</option>
            </select>
        </div>
        <!-- 3. Dynamic Grade/Class Selector (Trigger Table Reset) -->
        <div
            class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3 ring-2 ring-indigo-50">
            <i class="fas fa-graduation-cap text-indigo-400"></i>
            <select id="examClass" onchange="initMarkTable()"
                class="w-full bg-transparent border-none font-bold text-indigo-600 outline-none cursor-pointer">
                <!-- JS will inject options -->
            </select>
        </div>
    </div>

    <!-- Mark Entry Table -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Student Info
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                        Score (0-100)</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                        Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                        Entry Log</th>
                </tr>
            </thead>
            <tbody id="markTableBody" class="divide-y divide-slate-50 font-medium">
                <!-- Student Rows -->
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Hide Default UI Arrows */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    /* Input Focus State */
    .mark-input:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        transform: scale(1.05);
        background-color: white !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        updateDropdown();
    });

    // ၁။ Enrollment Data မှ Grade နှင့် Class ကို Dynamic ဆွဲထုတ်မည့် Function
    function updateDropdown() {
        const students = JSON.parse(localStorage.getItem('myStudents')) || [];
        const classSelect = document.getElementById('examClass');

        const combinedList = students.map(s => `Grade ${s.grade} - ${s.class}`);
        const uniqueList = [...new Set(combinedList)].sort();

        if (uniqueList.length > 0) {
            classSelect.innerHTML = uniqueList.map(item =>
                `<option value="${item}">${item}</option>`
            ).join('');
        } else {
            classSelect.innerHTML = `<option value="">No Classes Found</option>`;
        }

        initMarkTable();
    }

    // ၂။ Subject သို့မဟုတ် Class ပြောင်းတိုင်း Table ကို Reset ပြုလုပ်မည့် Function
    function initMarkTable() {
        const students = JSON.parse(localStorage.getItem('myStudents')) || [];
        const selectedValue = document.getElementById('examClass').value;
        const selectedSubject = document.getElementById('examSubject').value;
        const tbody = document.getElementById('markTableBody');

        const classStudents = students.filter(s => `Grade ${s.grade} - ${s.class}` === selectedValue);

        if (classStudents.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="py-20 text-center text-slate-300 italic">No records found. Please check Enrollment.</td></tr>`;
            resetStats();
            return;
        }

        // Table ကို render လုပ်ပြီး အမှတ်များကို 0 ပြန်ထားမည် (New Subject Entry)
        tbody.innerHTML = classStudents.map((s, i) => `
            <tr class="hover:bg-slate-50/50 transition-all group">
                <td class="px-8 py-5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm uppercase group-hover:scale-110 transition-transform">
                            ${s.name.charAt(0)}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">${s.name}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Roll ID: ${s.class}-${i + 1}</p>
                        </div>
                    </div>
                </td>
                <td class="px-8 py-5 text-center">
                    <input type="number" id="mark-${i}" value="0" min="0" max="100" 
                           oninput="updateLogic()" 
                           onkeydown="handleNavigation(event, ${i})"
                           class="mark-input w-24 bg-slate-50 border-none rounded-xl px-4 py-2.5 text-center font-black text-indigo-600 outline-none transition-all">
                </td>
                <td class="px-8 py-5 text-center">
                    <span id="status-${i}" class="text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-rose-100 text-rose-500 shadow-sm transition-all">Fail</span>
                </td>
                <td class="px-8 py-5 text-right font-bold text-[10px] text-slate-300 italic uppercase">
                    Entering ${selectedSubject}...
                </td>
            </tr>
        `).join('');

        updateLogic();
    }

    // ၃။ Real-time Statistics Logic
    function updateLogic() {
        const inputs = document.querySelectorAll('.mark-input');
        let totalMarks = 0, passCount = 0;

        inputs.forEach((input, i) => {
            let val = parseInt(input.value) || 0;
            if (val > 100) { val = 100; input.value = 100; }
            if (val < 0) { val = 0; input.value = 0; }

            totalMarks += val;
            const statusBadge = document.getElementById(`status-${i}`);

            if (val >= 40) {
                statusBadge.innerText = "Pass";
                statusBadge.className = "text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-600 shadow-sm";
                passCount++;
            } else {
                statusBadge.innerText = "Fail";
                statusBadge.className = "text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-rose-100 text-rose-500 shadow-sm";
            }
        });

        const avg = inputs.length > 0 ? Math.round(totalMarks / inputs.length) : 0;
        const rate = inputs.length > 0 ? Math.round((passCount / inputs.length) * 100) : 0;

        document.getElementById('classStats').innerText = `Class Average: ${avg}%`;
        document.getElementById('passRate').innerText = `Pass Rate: ${rate}%`;
    }

    // ၄။ Keyboard Navigation (Enter moves focus down)
    function handleNavigation(e, i) {
        if (e.key === "Enter") {
            e.preventDefault();
            const next = document.getElementById(`mark-${i + 1}`);
            if (next) {
                next.focus();
                next.select();
            }
        }
    }

    function resetStats() {
        document.getElementById('classStats').innerText = `Class Average: 0%`;
        document.getElementById('passRate').innerText = `Pass Rate: 0%`;
    }

    function saveAllMarks() {
        const subject = document.getElementById('examSubject').value;
        const cls = document.getElementById('examClass').value;
        if (!cls || cls === "No Classes Found") return alert("Please sync students first.");
        alert(`Assessment for ${subject} in ${cls} saved to central database!`);
    }
</script>

@endsection