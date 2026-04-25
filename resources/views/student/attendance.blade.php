@extends('layouts.app')

@section('title', 'Attendance')

@section('content')

 <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 border-b flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Daily Attendance Table</h1>
                <input type="date" id="datePicker" onchange="renderTable()" class="mt-1 border rounded px-2 py-1 text-indigo-600 font-bold outline-none">
            </div>
            <input type="text" id="searchInput" onkeyup="renderTable()" placeholder="Search Name..." class="border rounded-lg px-4 py-2 text-sm w-full md:w-64 outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <!-- Attendance Table -->
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4 border-b">ID / Name</th>
                    <th class="px-6 py-4 border-b">Grade - Class</th>
                    <th class="px-6 py-4 border-b text-center">Status (P / A / L)</th>
                    <th class="px-6 py-4 border-b text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="attendanceBody" class="divide-y divide-gray-100">
                <!-- Data syncs here -->
            </tbody>
        </table>
    </div>

    <script>
        // LocalStorage မှ Data များ ဆွဲယူခြင်း
        const getEnrollments = () => JSON.parse(localStorage.getItem('myStudents')) || [];
        const getAttendanceDB = () => JSON.parse(localStorage.getItem('attendanceDB')) || {};

        // Default Date (Today)
        document.getElementById('datePicker').valueAsDate = new Date();

        function renderTable() {
            const enrollments = getEnrollments();
            // let db = getAttendanceDB();
            let db = getEnrollments();

            const date = document.getElementById('datePicker').value;
            const term = document.getElementById('searchInput').value.toLowerCase();
            const tableBody = document.getElementById('attendanceBody');
            
            tableBody.innerHTML = '';

            // ဒီနေ့အတွက် record မရှိသေးရင် Enrollment ထဲကလူတွေကို ဆွဲယူမယ်
            if (!db[date]) {
                db[date] = enrollments.map(s => ({
                    name: s.name,
                    id: s.id || 'N/A',
                    grade: s.grade || '-',
                    class: s.class || '-',
                    status: 'P' // Default: Present
                }));
                localStorage.setItem('attendanceDB', JSON.stringify(db));
            }

            const filtered = db[date].filter(s => s.name.toLowerCase().includes(term));

            if (filtered.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="p-10 text-center text-gray-400">No records found.</td></tr>`;
                return;
            }

            filtered.forEach((student, index) => {
                const originalIndex = db[date].findIndex(s => s.name === student.name);

                tableBody.innerHTML += `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">${student.name}</div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">ID: ${student.id || student.name.charAt(0)}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">G-${student.grade} / C-${student.class}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-1">
                                ${['P', 'A', 'L'].map(s => `
                                    <button onclick="updateStatus('${date}', ${originalIndex}, '${s}')" 
                                    class="w-8 h-8 rounded font-black text-[10px] border 
                                    ${student.status === s ? getBtnColor(s) : 'bg-white text-gray-300 border-gray-200'}">${s}</button>
                                `).join('')}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="deleteRecord('${date}', ${originalIndex})" class="text-gray-300 hover:text-red-500 text-sm"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>`;
            });
        }

        function getBtnColor(s) {
            if (s === 'P') return 'bg-green-500 text-white border-green-500 shadow-sm';
            if (s === 'A') return 'bg-red-500 text-white border-red-500 shadow-sm';
            return 'bg-yellow-500 text-white border-yellow-500 shadow-sm';
        }

        function updateStatus(date, index, status) {
            let db = getAttendanceDB();
            db[date][index].status = status;
            localStorage.setItem('attendanceDB', JSON.stringify(db));
            renderTable();
        }

        function deleteRecord(date, index) {
            if (confirm("Remove this student from today's list?")) {
                let db = getAttendanceDB();
                db[date].splice(index, 1);
                localStorage.setItem('attendanceDB', JSON.stringify(db));
                renderTable();
            }
        }

        // Initial Start
        renderTable();
    </script>

    <!-- FontAwesome for icons -->
    <!-- <link rel="stylesheet" href="https://cloudflare.com"> -->

@endsection