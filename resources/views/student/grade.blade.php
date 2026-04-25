@extends('layouts.app')

@section('title', 'Grade')

@section('content')

 <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight italic">ACADEMIC GRADING</h1>
                <p class="text-slate-400 font-medium">Professional Frontend Performance Module</p>
            </div>
            <div class="flex items-center gap-4">
                <select id="studentSelect" onchange="resetInputs()" class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-3 font-bold text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                    <option value="">-- Select Student --</option>
                </select>
                <button onclick="alert('Grading report saved to database!')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-95">
                    Save Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Subjects Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Subject Details</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Score Control</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Result</th>
                            </tr>
                        </thead>
                        <tbody id="gradeTableBody" class="divide-y divide-slate-50">
                            <!-- JS will inject rows here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Performance Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl border-4 border-white sticky top-10">
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-10 text-center">Performance Analytics</p>
                    
                    <div class="flex flex-col items-center mb-10">
                        <div id="gradeCircle" class="w-32 h-32 rounded-full border-[10px] border-slate-800 flex items-center justify-center bg-slate-800/30 transition-all duration-500">
                            <span id="finalGrade" class="text-4xl font-black italic text-slate-600">?</span>
                        </div>
                        <h2 id="finalStatus" class="mt-6 text-xl font-bold tracking-tight text-slate-300">Awaiting Entry</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/10">
                            <div><p class="text-[9px] font-black text-slate-500 uppercase">Total Marks</p><p id="totalDisplay" class="text-xl font-black">0 / 800</p></div>
                            <i class="fas fa-check-circle text-slate-700"></i>
                        </div>
                        <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/10">
                            <div><p class="text-[9px] font-black text-slate-500 uppercase">Average Percentage</p><p id="avgDisplay" class="text-xl font-black">0%</p></div>
                            <i class="fas fa-chart-line text-slate-700"></i>
                        </div>
                    </div>

                    <div class="mt-8">
                         <div class="flex justify-between text-[10px] font-black uppercase mb-2">
                             <span class="text-slate-500">Passing Progress</span>
                             <span id="progressText" class="text-indigo-400">0%</span>
                         </div>
                         <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                             <div id="progressBar" class="bg-indigo-500 h-full transition-all duration-700 shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: 0%"></div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const subjects = [
            { name: 'Myanmar', code: 'MYA', icon: 'fa-book-open', color: 'text-orange-500', bg: 'bg-orange-100' },
            { name: 'English', code: 'ENG', icon: 'fa-language', color: 'text-blue-500', bg: 'bg-blue-100' },
            { name: 'Mathematics', code: 'MAT', icon: 'fa-calculator', color: 'text-indigo-500', bg: 'bg-indigo-100' },
            { name: 'Chemistry', code: 'CHE', icon: 'fa-flask', color: 'text-emerald-500', bg: 'bg-emerald-100' },
            { name: 'Physics', code: 'PHY', icon: 'fa-atom', color: 'text-purple-500', bg: 'bg-purple-100' },
            { name: 'Biology', code: 'BIO', icon: 'fa-dna', color: 'text-rose-500', bg: 'bg-rose-100' },
            { name: 'History', code: 'HIS', icon: 'fa-monument', color: 'text-amber-500', bg: 'bg-amber-100' },
            { name: 'Geography', code: 'GEO', icon: 'fa-globe-asia', color: 'text-cyan-500', bg: 'bg-cyan-100' }
        ];

        window.onload = () => {
            const students = JSON.parse(localStorage.getItem('myStudents')) || [];
            const select = document.getElementById('studentSelect');
            students.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.name; opt.textContent = s.name; select.appendChild(opt);
            });
            renderRows();
        };

        function renderRows() {
            const tbody = document.getElementById('gradeTableBody');
            tbody.innerHTML = subjects.map((sub, i) => `
                <tr class="hover:bg-slate-50 transition group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl ${sub.bg} ${sub.color} flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas ${sub.icon}"></i></div>
                            <div><p class="font-bold text-slate-800">${sub.name}</p><p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">${sub.code}</p></div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="stepMark(${i}, -1)" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:bg-rose-500 hover:text-white transition-colors flex items-center justify-center active:scale-90"><i class="fas fa-minus text-[10px]"></i></button>
                            <input type="number" id="input-${i}" value="0" min="0" max="100" oninput="handleInput(this)" onkeydown="handleKeyDown(event, ${i})"
                                class="mark-input w-16 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-xl py-2 text-center font-black text-slate-700 outline-none transition-all">
                            <button onclick="stepMark(${i}, 1)" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center active:scale-90"><i class="fas fa-plus text-[10px]"></i></button>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right"><span id="badge-${i}" class="text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 shadow-sm transition-all">Pending</span></td>
                </tr>`).join('');
        }

        function stepMark(i, amt) {
            const input = document.getElementById(`input-${i}`);
            if (!document.getElementById('studentSelect').value) return alert("Select student!");
            let val = (parseInt(input.value) || 0) + amt;
            if (val >= 0 && val <= 100) { input.value = val; calculate(); }
        }

        function handleInput(el) {
            if (el.value > 100) el.value = 100;
            if (el.value < 0) el.value = 0;
            calculate();
        }

        function handleKeyDown(e, i) {
            if (e.key === "Enter") {
                const inputs = document.querySelectorAll('.mark-input');
                if (i < inputs.length - 1) inputs[i + 1].focus();
            }
        }

        function calculate() {
            const inputs = document.querySelectorAll('.mark-input');
            let total = 0, isFailed = false, filledCount = 0;

            inputs.forEach((input, i) => {
                const valStr = input.value;
                const val = parseInt(valStr) || 0;
                if (valStr !== "" && valStr !== "0") filledCount++;
                total += val;
                
                const badge = document.getElementById(`badge-${i}`);
                if (valStr === "" || val === 0) { badge.textContent = "Pending"; badge.className = "text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400"; }
                else if (val >= 40) { badge.textContent = "Pass"; badge.className = "text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-600 scale-in"; }
                else { badge.textContent = "Fail"; badge.className = "text-[9px] font-black uppercase px-3 py-1.5 rounded-lg bg-rose-100 text-rose-600 scale-in"; isFailed = true; }
            });

            const avg = Math.round(total / subjects.length);
            document.getElementById('totalDisplay').textContent = `${total} / 800`;
            document.getElementById('avgDisplay').textContent = `${avg}%`;
            document.getElementById('progressText').textContent = `${avg}%`;
            document.getElementById('progressBar').style.width = `${avg}%`;

            const gradeCircle = document.getElementById('gradeCircle'), finalGrade = document.getElementById('finalGrade'), finalStatus = document.getElementById('finalStatus');

            if (filledCount === 0) {
                finalGrade.textContent = "?"; finalGrade.className = "text-4xl font-black italic text-slate-600";
                finalStatus.textContent = "Awaiting Entry"; gradeCircle.className = "w-32 h-32 rounded-full border-[10px] border-slate-800 flex items-center justify-center bg-slate-800/30 transition-all";
            } else if (isFailed) {
                finalGrade.textContent = "F"; finalGrade.className = "text-4xl font-black italic text-rose-500 scale-in";
                finalStatus.textContent = "Result: Failed"; gradeCircle.className = "w-32 h-32 rounded-full border-[10px] border-rose-900/30 flex items-center justify-center bg-rose-900/10 scale-110 transition-all shadow-[0_0_20px_rgba(244,63,94,0.2)]";
            } else if (filledCount < subjects.length) {
                finalGrade.textContent = "..."; finalStatus.textContent = "In Progress";
                gradeCircle.className = "w-32 h-32 rounded-full border-[10px] border-indigo-900/30 flex items-center justify-center bg-indigo-900/10 transition-all";
            } else {
                let g = avg >= 80 ? 'A' : avg >= 70 ? 'B' : avg >= 60 ? 'C' : 'D';
                finalGrade.textContent = g; finalGrade.className = "text-4xl font-black italic text-emerald-400 scale-in";
                finalStatus.textContent = "Result: Passed"; gradeCircle.className = "w-32 h-32 rounded-full border-[10px] border-emerald-900/30 flex items-center justify-center bg-emerald-900/10 scale-110 transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)]";
            }
        }

        function resetInputs() {
            document.querySelectorAll('.mark-input').forEach(input => input.value = 0);
            calculate();
        }
    </script>

@endsection