{{-- resources/views/admin/fields_of_study/edit.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">✏️ تعديل مجال الدراسة</h1>
            <p class="text-gray-600 text-sm mt-1">تعديل بيانات مجال الدراسة</p>
        </div>

        <form action="{{ route('admin.fields-of-study.update', $fields_of_study) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        اسم المجال <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $fields_of_study->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="مثال: العلوم الرياضية"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="study_level" class="block text-sm font-semibold text-gray-700 mb-2">
                        المستوى الدراسي <span class="text-red-500">*</span>
                    </label>
                    <select name="study_level" 
                            id="study_level" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">اختر المستوى الدراسي</option>
                        <option value="Common Core" {{ old('study_level', $fields_of_study->study_level) == 'Common Core' ? 'selected' : '' }}>السنة الأولى إعدادي (Common Core)</option>
                        <option value="First Baccalaureate" {{ old('study_level', $fields_of_study->study_level) == 'First Baccalaureate' ? 'selected' : '' }}>السنة الأولى باكالوريا (First Baccalaureate)</option>
                        <option value="Second Baccalaureate" {{ old('study_level', $fields_of_study->study_level) == 'Second Baccalaureate' ? 'selected' : '' }}>السنة الثانية باكالوريا (Second Baccalaureate)</option>
                    </select>
                    @error('study_level')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        الوصف
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="وصف مختصر عن مجال الدراسة...">{{ old('description', $fields_of_study->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.fields-of-study.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    إلغاء
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    تحديث المجال
                </button>
            </div>
        </form>
    </div>
</div>
@endsection