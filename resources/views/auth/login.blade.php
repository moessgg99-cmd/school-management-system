@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-slate-50 p-4" x-data="{ email: '', password: '' }">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 shadow-2xl border border-white">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-800 italic uppercase">Admin Login</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-2">Nexus Portal Access</p>
        </div>

        <form @submit.prevent="handleLogin(email, password)" class="space-y-5">
            <input type="email" x-model="email" placeholder="Email" required
                class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold outline-none focus:ring-2 focus:ring-indigo-500">
            <input type="password" x-model="password" placeholder="Password" required
                class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold outline-none focus:ring-2 focus:ring-indigo-500">

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all">
                Sign In
            </button>
        </form>
        <p class="mt-6 text-center text-xs font-bold text-slate-400">Testing? Use any email/pass after register.</p>
    </div>
</div>

<script>
    function handleLogin(email, password) {
        let users = JSON.parse(localStorage.getItem('users')) || [];
        let user = users.find(u => u.email === email && u.password === password);

        if (user) {
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('currentUser', JSON.stringify(user));
            window.location.href = '/'; // မင်းရဲ့ Home Route ကို သေချာစစ်ပါ
        } else {
            alert('Invalid Credentials! Please register first.');
        }
    }
</script>

@endsection