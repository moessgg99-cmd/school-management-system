@extends('layouts.app')

@section('title', 'Teacher Directory')

@section('content')

<!-- Teacher Directory Container -->
<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header Section -->
    <div
        class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase">Teacher Directory</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Total Faculty: <span id="teacherCount"
                    class="text-indigo-600 font-bold">0</span> Members</p>
        </div>
        <button onclick="openAddModal()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-95 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add New Faculty
        </button>
    </div>

    <!-- Search Bar -->
    <div class="mb-6 relative max-w-md">
        <input type="text" id="teacherSearch" onkeyup="renderTeachers()" placeholder="Search name, subject or class..."
            class="w-full pl-12 pr-4 py-3 bg-white border-none rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all">
        <i class="fas fa-search absolute left-4 top-4 text-slate-300"></i>
    </div>

    <!-- Main Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Instructor
                        Name</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                        Assigned Classes</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                        Experience</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody id="teacherTableBody" class="divide-y divide-slate-50 font-medium"></tbody>
        </table>
    </div>
</div>

<!-- 1. Entry Modal (Add/Edit) -->
<div id="teacherModal"
    class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 transition-all">
    <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-lg shadow-2xl">
        <h2 id="modalTitle" class="text-2xl font-black text-slate-800 mb-6 italic uppercase">Add Faculty</h2>
        <form id="teacherForm" class="space-y-4">
            <input type="hidden" id="teacherIndex">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1 tracking-widest">Profile
                        Image URL</label>
                    <input type="text" id="tImg" placeholder="https://example.com"
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1 tracking-widest">Full
                        Name</label>
                    <input type="text" id="tName" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1 tracking-widest">Department</label>
                    <select id="tSubject" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                        <option value="Mathematics">Mathematics</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                        <option value="English">English</option>
                        <option value="Myanmar">Myanmar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1 tracking-widest">Exp
                        (Yrs)</label>
                    <input type="number" id="tExp" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="col-span-2">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1 tracking-widest">Assigned
                        Classes (e.g. 10-A, 9-B)</label>
                    <input type="text" id="tClasses" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500"
                        placeholder="10-A, 9-B">
                </div>
            </div>
            <div class="flex gap-4 mt-8">
                <button type="button" onclick="closeEntryModal()"
                    class="flex-1 py-3 font-bold text-slate-400 hover:text-slate-600 uppercase text-[10px]">Cancel</button>
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-2xl font-bold shadow-lg hover:bg-indigo-700 uppercase text-[10px] transition-all">Save
                    Record</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Profile View Modal -->
<div id="profileModal"
    class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div
        class="bg-white rounded-[3rem] w-full max-w-md overflow-hidden shadow-2xl scale-in transform transition-all duration-300">
        <div class="relative h-32 bg-indigo-600">
            <button onclick="closeProfileModal()"
                class="absolute top-6 right-6 text-white/50 hover:text-white transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="px-8 pb-10">
            <div class="relative -mt-16 mb-6 text-center">
                <div
                    class="w-32 h-32 rounded-[2.5rem] bg-white border-4 border-white shadow-xl mx-auto overflow-hidden">
                    <img id="viewImg" src="" class="w-full h-full object-cover hidden">
                    <div id="viewInitial"
                        class="w-full h-full flex items-center justify-center text-5xl font-black text-indigo-600 italic">
                        ?</div>
                </div>
                <div
                    class="absolute bottom-2 right-1/3 bg-emerald-500 w-6 h-6 rounded-full border-4 border-white shadow-sm">
                </div>
            </div>

            <div class="text-center mb-8">
                <h2 id="viewName" class="text-2xl font-black text-slate-800 tracking-tight">Teacher Name</h2>
                <p id="viewSubject" class="text-indigo-500 font-bold text-xs uppercase tracking-[0.2em] mt-1">Department
                </p>
            </div>

            <div class="space-y-5">
                <div
                    class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex justify-between items-center transition-all">
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Teaching
                        Experience</span>
                    <span id="viewExp" class="text-slate-700 font-black text-sm">0 Years</span>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-3 ml-2 tracking-widest">Classroom
                        Responsibilities</p>
                    <div id="viewClasses" class="flex flex-wrap gap-2"></div>
                </div>
            </div>

            <button onclick="closeProfileModal()"
                class="w-full mt-10 bg-slate-800 text-white py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg">
                Close Information
            </button>
        </div>
    </div>
</div>

<script>
    let teachers = JSON.parse(localStorage.getItem('myTeachers')) || [];

    function renderTeachers() {
        const tbody = document.getElementById('teacherTableBody');
        const searchTerm = document.getElementById('teacherSearch').value.toLowerCase();
        document.getElementById('teacherCount').innerText = teachers.length;

        const filtered = teachers.filter(t =>
            t.name.toLowerCase().includes(searchTerm) ||
            t.subject.toLowerCase().includes(searchTerm) ||
            t.classes.toLowerCase().includes(searchTerm)
        );

        tbody.innerHTML = filtered.length === 0 ? `<tr><td colspan="4" class="py-20 text-center text-slate-400 font-medium">No records found.</td></tr>` :
            filtered.map((t, i) => {
                const realIndex = teachers.indexOf(t);
                const classBadges = t.classes.split(',').map(c =>
                    `<span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black border border-indigo-100 uppercase mr-1 mb-1 inline-block">${c.trim()}</span>`
                ).join('');

                const avatar = `https://ui-avatars.com{encodeURIComponent(t.name)}&background=random&color=fff`;

                return `
                <tr onclick="viewProfile(${realIndex})" class="hover:bg-slate-50 transition border-b border-slate-50 group cursor-pointer">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <img src="${t.img || avatar}" class="w-12 h-12 rounded-2xl object-cover shadow-sm group-hover:scale-110 transition-transform">
                            <div>
                                <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-all">${t.name}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">${t.subject}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex flex-wrap justify-center max-w-[200px] mx-auto">${classBadges}</div>
                    </td>
                    <td class="px-8 py-5 text-center font-bold text-slate-600 text-sm">
                        ${t.exp} <span class="text-[10px] text-slate-300 font-black">YRS</span>
                    </td>
                    <td class="px-8 py-5 text-right" onclick="event.stopPropagation()">
                        <div class="flex justify-end gap-3 text-slate-300">
                            <button onclick="editTeacher(${realIndex})" class="hover:text-indigo-600 transition-colors p-2"><i class="fas fa-edit"></i></button>
                            <button onclick="deleteTeacher(${realIndex})" class="hover:text-rose-500 transition-colors p-2"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
            }).join('');

        localStorage.setItem('myTeachers', JSON.stringify(teachers));
    }

    document.getElementById('teacherForm').onsubmit = (e) => {
        e.preventDefault();
        const index = document.getElementById('teacherIndex').value;
        const data = {
            img: document.getElementById('tImg').value,
            name: document.getElementById('tName').value,
            subject: document.getElementById('tSubject').value,
            exp: document.getElementById('tExp').value,
            classes: document.getElementById('tClasses').value
        };

        if (index === "") teachers.push(data); else teachers[index] = data;
        closeEntryModal(); renderTeachers();
    };

    function editTeacher(index) {
        const t = teachers[index];
        document.getElementById('teacherIndex').value = index;
        document.getElementById('tImg').value = t.img || "";
        document.getElementById('tName').value = t.name;
        document.getElementById('tSubject').value = t.subject;
        document.getElementById('tExp').value = t.exp;
        document.getElementById('tClasses').value = t.classes;
        document.getElementById('modalTitle').innerText = "Edit Faculty";
        document.getElementById('teacherModal').classList.remove('hidden');
    }

    function viewProfile(index) {
        const t = teachers[index];
        document.getElementById('viewName').innerText = t.name;
        document.getElementById('viewSubject').innerText = t.subject + " Dept.";
        document.getElementById('viewExp').innerText = t.exp + " Years Exp";

        const imgTag = document.getElementById('viewImg');
        const initialDiv = document.getElementById('viewInitial');
        const avatar = `https://ui-avatars.com{encodeURIComponent(t.name)}&background=6366f1&color=fff&size=200`;

        if (t.img) {
            imgTag.src = t.img;
            imgTag.classList.remove('hidden'); initialDiv.classList.add('hidden');
        } else {
            initialDiv.innerText = t.name.charAt(0).toUpperCase();
            imgTag.classList.add('hidden'); initialDiv.classList.remove('hidden');
        }

        document.getElementById('viewClasses').innerHTML = t.classes.split(',').map(c =>
            `<span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black shadow-md uppercase tracking-wider">${c.trim()}</span>`
        ).join('');

        document.getElementById('profileModal').classList.remove('hidden');
    }

    function deleteTeacher(index) {
        if (confirm("Delete this faculty record?")) { teachers.splice(index, 1); renderTeachers(); }
    }

    function openAddModal() { document.getElementById('teacherForm').reset(); document.getElementById('teacherIndex').value = ""; document.getElementById('modalTitle').innerText = "Add Faculty"; document.getElementById('teacherModal').classList.remove('hidden'); }
    function closeEntryModal() { document.getElementById('teacherModal').classList.add('hidden'); }
    function closeProfileModal() { document.getElementById('profileModal').classList.add('hidden'); }

    renderTeachers();
</script>

@endsection