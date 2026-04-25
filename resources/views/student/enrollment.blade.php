@extends('layouts.app')

@section('title', 'Enrollment')

@section('content')

<div class="max-w-[1400px] mx-auto">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Enrollment</h1>
        <button onclick="toggleModal()"
            class="bg-indigo-500 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-indigo-600 transition">+ Add
            Student</button>
    </header>

    <!-- Search Bar -->
    <div class="mb-6 relative max-w-md">
        <input type="text" id="searchInput" onkeyup="searchStudents()" placeholder="Search students..."
            class="w-full pl-10 pr-4 py-2 rounded-xl border-none shadow-sm focus:ring-2 focus:ring-indigo-300 outline-none text-sm">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left Side: Table -->
        <div class="flex-1 overflow-x-auto">
            <div class="grid grid-cols-6 px-6 py-4 text-sm font-semibold text-gray-400">
                <div>Name & Class</div>
                <div class="text-center">Grade</div>
                <div class="text-center">Enrollment Date</div>
                <div class="text-center">Performance</div>
                <div class="text-center">Tutor</div>
                <div class="text-right">Actions</div>
            </div>
            <div id="studentList" class="space-y-3"></div>
        </div>

        <!-- Right Side: Profile Detail Panel -->
        <div id="profilePanel"
            class="w-full lg:w-80 bg-white rounded-3xl p-6 shadow-sm sticky top-8 h-fit border border-indigo-50 min-h-[400px]">
            <div id="profileContent" class="text-center">
                <div class="py-10 text-gray-400 italic">Select a student to view profile</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-2xl overflow-y-auto max-h-[90vh]">
        <h2 id="modalTitle" class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Student Form</h2>
        <form id="studentForm" class="space-y-4">
            <input type="hidden" id="studentIndex">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Image URL</label>
                <input type="text" id="imgUrl" placeholder="https://..."
                    class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Full Name</label>
                <input type="text" id="name" required class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
            </div>

            <!-- ဖြည့်စွက်ထားသော Fields များ -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Parent Name</label>
                    <input type="text" id="parentName" required
                        class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Occupation</label>
                    <input type="text" id="parentJob" required
                        class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Address</label>
                <textarea id="address" required
                    class="w-full bg-gray-50 border rounded-lg p-2 outline-none h-16"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 border-t pt-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Enrollment Date</label>
                    <input type="date" id="enroll" required
                        class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Class</label>
                    <input type="text" id="class" required placeholder="X-A"
                        class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Grade (1-10)</label>
                    <input type="number" id="grade" required
                        class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tutor</label>
                    <input type="text" id="tutor" required class="w-full bg-gray-50 border rounded-lg p-2 outline-none">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="toggleModal()"
                    class="flex-1 bg-gray-100 py-2 rounded-lg font-bold text-gray-400">Cancel</button>
                <button type="submit"
                    class="flex-1 bg-indigo-500 text-white py-2 rounded-lg font-bold shadow-md hover:bg-indigo-600 transition">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    let students = JSON.parse(localStorage.getItem('myStudents')) || [];

    function render(dataToDisplay = students) {
        const list = document.getElementById('studentList');
        list.innerHTML = dataToDisplay.length === 0 ? '<div class="text-center py-10 text-gray-400">No records.</div>' :
            dataToDisplay.map((s) => {
                const realIndex = students.indexOf(s);
                return `
                <div onclick="showProfile(${realIndex})" class="grid grid-cols-6 items-center bg-white p-4 rounded-2xl shadow-sm hover:ring-2 hover:ring-indigo-100 transition cursor-pointer group">
                    <div class="flex items-center space-x-3">
                        ${s.img ? `<img src="${s.img}" class="w-10 h-10 rounded-full object-cover">` :
                        `<div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center font-bold uppercase">${s.name.charAt(0)}</div>`}
                        <div>
                            <p class="font-bold text-sm text-gray-800">${s.name}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">${s.class}</p>
                        </div>
                    </div>
                    <div class="text-center font-bold text-indigo-600">${s.grade}</div>
                    <div class="text-center text-sm text-gray-500">${new Date(s.enroll).toLocaleDateString('en-GB')}</div>
                    <div class="px-4">
                        <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-500 h-full" style="width: ${Math.min(s.grade * 10, 100)}%"></div>
                        </div>
                    </div>
                    <div class="text-center text-sm text-gray-500">${s.tutor}</div>
                    <div class="text-right flex justify-end gap-3 text-gray-300">
                        <button onclick="event.stopPropagation(); editStudent(${realIndex})"><i class="fas fa-edit hover:text-indigo-500"></i></button>
                        <button onclick="event.stopPropagation(); deleteStudent(${realIndex})"><i class="fas fa-trash hover:text-red-500"></i></button>
                    </div>
                </div>`;
            }).join('');
        localStorage.setItem('myStudents', JSON.stringify(students));
    }

    function searchStudents() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        const filtered = students.filter(s => s.name.toLowerCase().includes(term) || s.tutor.toLowerCase().includes(term));
        render(filtered);
    }

    window.showProfile = (i) => {
        const s = students[i];
        document.getElementById('profileContent').innerHTML = `
                <div class="flex flex-col items-center">
    <img src="${s.img || 'https://pravatar.cc'}" class="w-20 h-20 rounded-2xl object-cover shadow-lg mb-4">
    <h3 class="font-bold text-gray-800">${s.name}</h3>
    <p class="text-indigo-500 text-xs font-bold mb-6 uppercase">${s.class}</p>
    <div class="w-full space-y-3 text-left">
        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
            <p class="text-[9px] font-bold text-gray-400 uppercase">Parent Info</p>
            <p class="text-xs font-bold text-gray-700">${s.parentName} (${s.parentJob})</p>
        </div>
        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
            <p class="text-[9px] font-bold text-gray-400 uppercase">Current Address</p>
            <p class="text-xs font-medium text-gray-600 leading-tight">${s.address}</p>
        </div>
        <div class="flex justify-between bg-indigo-50 p-3 rounded-xl">
             <div>
                <p class="text-[9px] font-bold text-indigo-400 uppercase">Tutor</p>
                <p class="text-xs font-bold text-indigo-700">${s.tutor}</p>
             </div>
             <div class="text-right">
                <p class="text-[9px] font-bold text-indigo-400 uppercase">Grade</p>
                <p class="text-xs font-bold">${s.grade}</p>
             </div>
        </div>
    </div>
</div>`;
    };

    document.getElementById('studentForm').onsubmit = (e) => {
        e.preventDefault();
        const i = document.getElementById('studentIndex').value;
        const newData = {
            img: document.getElementById('imgUrl').value,
            name: document.getElementById('name').value,
            parentName: document.getElementById('parentName').value,
            parentJob: document.getElementById('parentJob').value,
            address: document.getElementById('address').value,
            enroll: document.getElementById('enroll').value,
            class: document.getElementById('class').value,
            grade: document.getElementById('grade').value,
            tutor: document.getElementById('tutor').value
        };
        if (i === "") students.push(newData); else students[i] = newData;
        toggleModal(); render();
    };

    window.editStudent = (i) => {
        const s = students[i];
        document.getElementById('studentIndex').value = i;
        ["imgUrl", "name", "parentName", "parentJob", "address", "enroll", "class", "grade", "tutor"].forEach(f => {
            document.getElementById(f).value = s[f === "imgUrl" ? "img" : f] || "";
        });
        document.getElementById('modalTitle').innerText = "Edit Student";
        toggleModal();
    };

    window.deleteStudent = (i) => { if (confirm("Are you sure?")) { students.splice(i, 1); render(); document.getElementById('profileContent').innerHTML = '<div class="py-10 text-gray-400 italic">Select a student</div>'; } };
    window.toggleModal = () => { document.getElementById('modal').classList.toggle('hidden'); if (document.getElementById('modal').classList.contains('hidden')) document.getElementById('studentForm').reset(); };

    render();
</script>

@endsection