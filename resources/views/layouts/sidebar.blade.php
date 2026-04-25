<aside class="w-64 bg-gray-900 text-white flex flex-col min-h-screen">
    <!-- Sidebar User Profile Section -->
    <div class="p-4 mb-6 flex items-center gap-3 bg-slate-800/40 rounded-[2rem] mx-2 border border-slate-700/50 group transition-all"
        x-data="{ 
        userName: 'Admin User',
        userImg: 'https://randomuser.me/api/portraits/men/1.jpg', // Default ပုံ (ပုံမရှိရင်ပြဖို့)
        
     }">

        <!-- Dynamic User Photo -->
        <div class="relative flex-shrink-0">
            <img :src="userImg"
                class="w-11 h-11 rounded-2xl border-2 border-slate-600 object-cover shadow-lg group-hover:scale-105 transition-transform"
                alt="User Profile">

            <!-- Online Status Dot -->
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-slate-900 rounded-full flex items-center justify-center">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(16,185,129,0.6)]">
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="overflow-hidden">
            <p class="text-white font-black text-[11px] truncate uppercase tracking-tight" x-text="userName"></p>
            <p class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest">Authorized User</p>
        </div>
    </div>

    <!-- Brand Section -->
    <div class="flex items-center justify-between pl-4 border-b border-gray-700">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-school text-sm text-orange-300 ml-2"></i>
            <span class="text-sm font-bold pl-1 text-yellow-400">School Admin</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <!-- Home -->
            <li>
                <a href="{{ route('home') }}"
                    class="nav-link flex items-center px-3 py-2 rounded-xl transition-all hover:bg-gray-800 text-gray-400">
                    <i class="fa-solid fa-house-chimney-user mr-2 text-green-400"></i> Home
                </a>
            </li>

            <!-- Students Dropdown -->
            <li>
                <button onclick="toggleMenu('studentsMenu')"
                    class="flex items-center w-full px-3 py-2 rounded-xl hover:bg-gray-800 transition text-gray-400">
                    <i class="fa-solid fa-user-graduate mr-2 text-green-400"></i> Students <span
                        class="ml-auto text-[10px]">▼</span>
                </button>
                <ul id="studentsMenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li><a href="{{ route('student.enroll') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Enrollment</a>
                    </li>
                    <li><a href="{{ route('student.attend') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Attendance</a>
                    </li>
                    <li><a href="{{ route('student.grade') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Grades</a>
                    </li>
                </ul>
            </li>

            <!-- Teachers Dropdown -->
            <li>
                <button onclick="toggleMenu('teachersMenu')"
                    class="flex items-center w-full px-3 py-2 rounded-xl hover:bg-gray-800 transition text-gray-400">
                    <i class="fa-solid fa-chalkboard-teacher mr-2 text-green-400"></i> Teachers <span
                        class="ml-auto text-[10px]">▼</span>
                </button>
                <ul id="teachersMenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li><a href="{{ route('teacher.directory') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Directory</a>
                    </li>
                    <li><a href="{{ route('teacher.schedule') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Schedules</a>
                    </li>
                    <li><a href="{{ route('teacher.performance') }}"
                            class="nav-link block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-white">Performance</a>
                    </li>
                </ul>
            </li>

            <!-- Timetable & Exams (Simple Links) -->
            <li><a href="{{ route('timetable.index') }}"
                    class="nav-link flex items-center px-3 py-2 rounded-xl hover:bg-gray-800 text-gray-400"><i
                        class="fa-solid fa-calendar-days mr-2 text-green-400"></i> Timetable</a></li>
            <li><a href="{{ route('timetable.exams') }}"
                    class="nav-link flex items-center px-3 py-2 rounded-xl hover:bg-gray-800 text-gray-400"><i
                        class="fa-solid fa-file-signature mr-2 text-green-400"></i> Exams</a></li>
            <li><a href="{{ route('library') }}"
                    class="nav-link flex items-center px-3 py-2 rounded-xl hover:bg-gray-800 text-gray-400"><i
                        class="fa-solid fa-book mr-2 text-green-400"></i> Library</a></li>
            <li><a href="{{ route('fees') }}"
                    class="nav-link flex items-center px-3 py-2 rounded-xl hover:bg-gray-800 text-gray-400"><i
                        class="fa-solid fa-hand-holding-dollar mr-2 text-green-400"></i> Fees</a></li>

        </ul>

        <!-- Logout as List Item (Perfectly Aligned with Above Menus) -->
        <div class="mt-auto pt-4" x-data="{}">
            <!-- မျဉ်းကြောင်း - အပေါ်က menu တွေနဲ့ ခြားထားတယ် -->
            <div class="border-t border-slate-700/30 mb-2"></div>

            <ul class="space-y-2">
                <li>
                    <button @click="logoutUser()"
                        class="nav-link flex items-center w-full px-3 py-2 rounded-xl transition-all hover:bg-gray-800 text-rose-400 hover:text-rose-300">
                        <i class="fas fa-power-off mr-2 text-sm"></i>
                        <span class="text-sm">Logout</span>
                    </button>
                </li>
            </ul>
        </div>

    </nav>

</aside>

<script>
    // Page load ဖြစ်တာနဲ့ Login ဝင်ထားလား အရင်စစ်မယ်
    document.addEventListener('DOMContentLoaded', () => {
        const isLoggedIn = localStorage.getItem('isLoggedIn');
        // လက်ရှိရောက်နေတဲ့ page က login/register မဟုတ်ရင် ပြန်ကန်ထုတ်မယ်
        if (isLoggedIn !== 'true' && !window.location.pathname.includes('/login') && !window.location.pathname.includes('/register')) {
            window.location.href = '/login';
        }
    });

    function logoutUser() {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('currentUser');
        window.location.href = '/login';
    }

    // Toggle Dropdown Function
    function toggleMenu(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Highlight & Auto-Open Logic
    document.addEventListener("DOMContentLoaded", function () {
        const currentUrl = window.location.href;
        const links = document.querySelectorAll('.nav-link');

        links.forEach(link => {
            if (link.href === currentUrl) {
                // Highlight active link
                link.classList.add('bg-indigo-600', 'text-white', 'font-bold');
                link.classList.remove('text-gray-400', 'hover:bg-gray-800');

                // Auto-open parent dropdown
                const parentUl = link.closest('ul');
                if (parentUl && parentUl.id.includes('Menu')) {
                    parentUl.classList.remove('hidden');
                    const btn = parentUl.previousElementSibling;
                    if (btn) btn.classList.add('text-indigo-400');
                }
            }
        });
    });
</script>