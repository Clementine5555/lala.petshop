@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
                <p class="mb-6">Selamat datang, <strong>{{ auth()->user()->name }}</strong>! (Role: {{ auth()->user()->role }})</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Card Example 1 -->
                    <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2">Total Users</h2>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">-</p>
                    </div>

                    <!-- Card Example 2 -->
                    <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-bold text-green-900 dark:text-green-100 mb-2">Total Products</h2>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-300">-</p>
                    </div>

                    <!-- Card Example 3 -->
                    <div class="bg-purple-100 dark:bg-purple-900 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-bold text-purple-900 dark:text-purple-100 mb-2">Total Orders</h2>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-300">-</p>
                    </div>

                    <!-- Card Example 4 -->
                    <div class="bg-orange-100 dark:bg-orange-900 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-bold text-orange-900 dark:text-orange-100 mb-2">Total Revenue</h2>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-300">Rp 0</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold mb-4">Menu Admin</h2>
                <ul class="list-disc list-inside space-y-2">
                    <li><a href="#" class="text-blue-600 hover:underline">Manage Users</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Manage Products</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Manage Suppliers</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Manage Orders</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">View Reports</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
