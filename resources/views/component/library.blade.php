@extends('layouts.app')

@section('title', 'Library')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans">
    <!-- Header Section -->
    <div
        class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase text-indigo-600">Library
                Assets</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Manage school books and digital resources</p>
        </div>
        <button onclick="toggleModal()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-95 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add New Book
        </button>
    </div>

    <!-- Stats & Search Bar -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="md:col-span-3 relative">
            <input type="text" id="bookSearch" onkeyup="renderBooks()" placeholder="Search by book title or author..."
                class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-[1.5rem] shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all">
            <i class="fas fa-search absolute left-5 top-5 text-slate-300"></i>
        </div>
        <div
            class="bg-indigo-50 p-4 rounded-[1.5rem] border border-indigo-100 flex flex-col justify-center text-center">
            <span class="text-[10px] font-black text-indigo-400 uppercase">Total Resources</span>
            <span id="bookCount" class="text-2xl font-black text-indigo-600">0</span>
        </div>
    </div>

    <!-- Books Grid -->
    <div id="bookGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- JS will render book cards here -->
    </div>
</div>

<!-- Add Book Modal -->
<div id="bookModal"
    class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 transition-all">
    <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-lg shadow-2xl scale-in transform">
        <h2 class="text-2xl font-black text-slate-800 mb-6 italic uppercase">Register New Book</h2>
        <form id="bookForm" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Book Title</label>
                    <input type="text" id="bTitle" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Author</label>
                    <input type="text" id="bAuthor" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Category</label>
                    <select id="bCategory"
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 outline-none font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                        <option>Science</option>
                        <option>Language</option>
                        <option>History</option>
                        <option>Fiction</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-4 mt-8">
                <button type="button" onclick="toggleModal()"
                    class="flex-1 py-3 font-bold text-slate-400 hover:text-slate-600 uppercase text-[10px]">Cancel</button>
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-2xl font-bold shadow-lg hover:bg-indigo-700 uppercase text-[10px]">Add
                    to Library</button>
            </div>
        </form>
    </div>
</div>

<script>
    let books = JSON.parse(localStorage.getItem('myBooks')) || [
        { title: "Advanced Mathematics", author: "Dr. Newton", category: "Science", status: "Available" },
        { title: "English Grammar Pro", author: "Sarah Jenkins", category: "Language", status: "Borrowed" }
    ];

    function renderBooks() {
        const grid = document.getElementById('bookGrid');
        const searchTerm = document.getElementById('bookSearch').value.toLowerCase();
        const filtered = books.filter(b => b.title.toLowerCase().includes(searchTerm) || b.author.toLowerCase().includes(searchTerm));

        document.getElementById('bookCount').innerText = books.length;

        grid.innerHTML = filtered.length === 0 ? `<div class="col-span-full py-20 text-center text-slate-300 font-medium italic">No books found in the archive.</div>` :
            filtered.map((b, i) => `
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                        <i class="fas fa-book"></i>
                    </div>
                    <button onclick="deleteBook(${i})" class="text-slate-200 hover:text-rose-500 transition-colors">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <div class="mb-6">
                    <span class="text-[9px] font-black uppercase px-2 py-1 rounded-lg bg-indigo-50 text-indigo-500 mb-2 inline-block tracking-tighter">${b.category}</span>
                    <h3 class="text-lg font-black text-slate-800 leading-tight mb-1">${b.title}</h3>
                    <p class="text-xs text-slate-400 font-bold">By ${b.author}</p>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full ${b.status === 'Available' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500'}"></div>
                        <span class="text-[10px] font-black uppercase ${b.status === 'Available' ? 'text-emerald-600' : 'text-rose-600'}">${b.status}</span>
                    </div>
                    <button onclick="toggleStatus(${i})" class="text-[9px] font-black uppercase text-indigo-600 hover:underline">Update Status</button>
                </div>
            </div>
        `).join('');

        localStorage.setItem('myBooks', JSON.stringify(books));
    }

    document.getElementById('bookForm').onsubmit = (e) => {
        e.preventDefault();
        const newBook = {
            title: document.getElementById('bTitle').value,
            author: document.getElementById('bAuthor').value,
            category: document.getElementById('bCategory').value,
            status: "Available"
        };
        books.push(newBook);
        toggleModal();
        renderBooks();
    };

    function toggleStatus(index) {
        books[index].status = books[index].status === "Available" ? "Borrowed" : "Available";
        renderBooks();
    }

    function deleteBook(index) {
        if (confirm("Remove this book from database?")) {
            books.splice(index, 1);
            renderBooks();
        }
    }

    function toggleModal() {
        document.getElementById('bookModal').classList.toggle('hidden');
        document.getElementById('bookForm').reset();
    }

    renderBooks();
</script>

@endsection