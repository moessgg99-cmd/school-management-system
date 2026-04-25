@extends('layouts.app')

@section('title', 'Fees')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-8 font-sans" x-data="{ 
        students: JSON.parse(localStorage.getItem('myStudents')) || [],
        fees: JSON.parse(localStorage.getItem('myFees')) || {},
        searchTerm: '',
        
        // အမှတ်ရိုက်တာနဲ့ အလိုအလျောက် သိမ်းမယ့် logic
        updateFee(name, status) {
            this.fees[name] = status;
            localStorage.setItem('myFees', JSON.stringify(this.fees));
        },

        // Analytics တွက်ချက်ခြင်း
        get stats() {
            let paid = Object.values(this.fees).filter(v => v === 'Paid').length;
            let total = this.students.length;
            return {
                paid: paid,
                pending: total - paid,
                percent: total > 0 ? Math.round((paid / total) * 100) : 0
            };
        }
     }">

    <!-- Header & Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div
            class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase text-indigo-600">Student
                    Fees</h1>
                <p class="text-slate-400 font-medium text-sm mt-1">Financial status & tuition tracking</p>
            </div>
            <div class="text-right no-print">
                <span class="text-[10px] font-black text-emerald-500 uppercase block">Collection Rate</span>
                <span class="text-4xl font-black text-slate-800" x-text="stats.percent + '%'">0%</span>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div
            class="bg-indigo-600 p-6 rounded-[2.5rem] shadow-lg shadow-indigo-100 text-white flex justify-around items-center">
            <div class="text-center border-r border-indigo-400 pr-6">
                <p class="text-[9px] font-black uppercase opacity-70">Paid</p>
                <p class="text-2xl font-black" x-text="stats.paid">0</p>
            </div>
            <div class="text-center pl-6">
                <p class="text-[9px] font-black uppercase opacity-70">Pending</p>
                <p class="text-2xl font-black" x-text="stats.pending">0</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6 relative max-w-md">
        <input type="text" x-model="searchTerm" placeholder="Search student name..."
            class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all">
        <i class="fas fa-search absolute left-5 top-5 text-slate-300"></i>
    </div>

    <!-- Fees Table -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Student
                        Details</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Grade & Class
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                        Payment Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                        Quick Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <template
                    x-for="(student, index) in students.filter(s => s.name.toLowerCase().includes(searchTerm.toLowerCase()))"
                    :key="index">
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-xs"
                                    x-text="student.name.charAt(0)"></div>
                                <p class="font-bold text-slate-700" x-text="student.name"></p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-400 uppercase"
                                x-text="'Grade ' + student.grade + ' (' + student.class + ')'"></span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <!-- Dynamic Badge based on Status -->
                            <span
                                :class="fees[student.name] === 'Paid' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'"
                                class="text-[9px] font-black uppercase px-3 py-1.5 rounded-lg shadow-sm transition-all"
                                x-text="fees[student.name] || 'Pending'">
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button @click="updateFee(student.name, fees[student.name] === 'Paid' ? 'Pending' : 'Paid')"
                                class="bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-400 px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all active:scale-95">
                                Toggle Payment
                            </button>
                        </td>
                    </tr>
                </template>
                <!-- အကယ်၍ ကျောင်းသားမရှိရင် -->
                <template x-if="students.length === 0">
                    <tr>
                        <td colspan="4" class="py-20 text-center text-slate-300 font-medium italic">No students found.
                            Add them in Enrollment first.</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

@endsection