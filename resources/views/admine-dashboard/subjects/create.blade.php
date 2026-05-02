{{-- resources/views/admin/subjects/create.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">➕ إضافة مادة جديدة</h1>
            <p class="text-gray-600 text-sm mt-1">أدخل بيانات المادة الدراسية</p>
        </div>

        <form action="{{ route('admin.subjects.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        اسم المادة <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="مثال: الرياضيات"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="fields_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        مجال الدراسة <span class="text-red-500">*</span>
                    </label>
                    <select name="fields_id" 
                            id="fields_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">اختر مجال الدراسة</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" {{ old('fields_id') == $field->id ? 'selected' : '' }}>
                                {{ $field->name }} ({{ $field->study_level }})
                            </option>
                        @endforeach
                    </select>
                    @error('fields_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    إلغاء
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    حفظ المادة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection