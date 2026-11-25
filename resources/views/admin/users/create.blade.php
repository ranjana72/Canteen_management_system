@extends('layouts.app')
@section('title', 'Add User')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Users</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Add New User</h1>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                       {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300' }}">
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                       {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }}">
            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                Create User
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection