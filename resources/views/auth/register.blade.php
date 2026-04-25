@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-[#f0f2f5] p-4" x-data="{ 
        name: '', email: '', password: '',
        doRegister() {
            let users = JSON.parse(localStorage.getItem('users')) || [];
            if(users.find(u => u.email === this.email)) return alert('Email already exists!');
            
            users.push({ name: this.name, email: this.email, password: this.password });
            localStorage.setItem('users', JSON.stringify(users));
            alert('Registration Success! Going to Login...');
            window.location.href = '/login';
        }
     }">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 shadow-2xl border border-white">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-800 italic uppercase">Register</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-2">Create your faculty account
            </p>
        </div>
        <form @submit.prevent="doRegister()" class="space-y-5">
            <input type="text" x-model="name" placeholder="Full Name" required
                class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold outline-none focus:ring-2 focus:ring-indigo-500">
            <input type="email" x-model="email" placeholder="Email Address" required
                class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold outline-none focus:ring-2 focus:ring-indigo-500">
            <input type="password" x-model="password" placeholder="Password" required
                class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all">Sign
                Up</button>
        </form>
        <p class="mt-6 text-center text-xs font-bold text-slate-400">Back to <a href="/login"
                class="text-indigo-600">Login</a></p>
    </div>
</div>

@endsection