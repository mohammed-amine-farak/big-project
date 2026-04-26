{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إنشاء حساب جديد - مدرستي نور</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
            box-sizing: border-box;
        }
        .font-black {
            font-weight: 900;
        }
    </style>
</head>
<body>
    <div class="bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-200">
        <!-- Register Form Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-blue-900 mb-2">إنشاء حساب جديد</h1>
            <p class="text-gray-600 text-lg">أدخل بياناتك للتسجيل في المنصة</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm text-red-700 font-medium">يرجى تصحيح الأخطاء التالية:</p>
                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"class="space-y-6">
            @csrf

            <!-- User Type Selection -->
            <div class="mb-6">
                <label class="block text-lg font-semibold text-gray-700 mb-3 text-right">
                    نوع الحساب
                </label>
                <div class="grid grid-cols-5 gap-4">
                    <!-- Student -->
                    <label class="cursor-pointer">
                        <input type="radio" name="user_type" value="student" class="sr-only peer" {{ old('user_type') == 'student' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-300 rounded-xl p-4 text-center peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm font-medium">طالب</span>
                        </div>
                    </label>
                    
                    <!-- Teacher -->
                    <label class="cursor-pointer">
                        <input type="radio" name="user_type" value="teacher" class="sr-only peer" {{ old('user_type') == 'teacher' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-300 rounded-xl p-4 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-sm font-medium">معلم</span>
                        </div>
                    </label>
                    
                    <!-- Researcher -->
                    <label class="cursor-pointer">
                        <input type="radio" name="user_type" value="researcher" class="sr-only peer" {{ old('user_type') == 'researcher' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-300 rounded-xl p-4 text-center peer-checked:border-purple-600 peer-checked:bg-purple-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                            </svg>
                            <span class="text-sm font-medium">باحث</span>
                        </div>
                    </label>
                    
                    <!-- Admin -->
                    <label class="cursor-pointer">
                        <input type="radio" name="user_type" value="admin" class="sr-only peer" {{ old('user_type') == 'admin' ? 'selected' : '' }}>
                        <div class="border-2 border-gray-300 rounded-xl p-4 text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-emerald-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">مدير</span>
                        </div>
                    </label>

                    <!-- Video Creator -->
                    <label class="cursor-pointer">
                        <input type="radio" name="user_type" value="video_creator" class="sr-only peer" {{ old('user_type') == 'video_creator' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-300 rounded-xl p-4 text-center peer-checked:border-orange-600 peer-checked:bg-orange-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-medium">منشئ فيديو</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        الاسم الكامل
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           required
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                           placeholder="أدخل اسمك الكامل">
                </div>
                
                <div>
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        البريد الإلكتروني
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           required
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                           placeholder="example@email.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        كلمة المرور
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                           placeholder="أدخل كلمة المرور">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        تأكيد كلمة المرور
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           required
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                           placeholder="أعد إدخال كلمة المرور">
                </div>
            </div>

            <!-- Student Specific Fields -->
            {{-- resources/views/auth/register.blade.php --}}
<!-- Student Specific Fields -->
<div id="student-fields" class="space-y-6 hidden">
    <h3 class="text-xl font-bold text-gray-800 border-b pb-2">🎓 معلومات الطالب</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="school_level" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                المرحلة الدراسية <span class="text-red-500">*</span>
            </label>
            <select name="school_level" 
                    id="school_level"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base"
                    required>
                <option value="">اختر المرحلة الدراسية</option>
                <option value="الابتدائي" {{ old('school_level') == 'الابتدائي' ? 'selected' : '' }}>المرحلة الابتدائية</option>
                <option value="المتوسط" {{ old('school_level') == 'المتوسط' ? 'selected' : '' }}>المرحلة المتوسطة</option>
                <option value="الثانوي" {{ old('school_level') == 'الثانوي' ? 'selected' : '' }}>المرحلة الثانوية</option>
                <option value="الجامعي" {{ old('school_level') == 'الجامعي' ? 'selected' : '' }}>المرحلة الجامعية</option>
            </select>
        </div>
        
        <div>
            <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                تاريخ الميلاد
            </label>
            <input type="date" 
                   name="birth_date" 
                   id="birth_date" 
                   value="{{ old('birth_date') }}"
                   class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base">
        </div>
    </div>
    <label for="field_id" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                مجال الدراسة / الشعبة <span class="text-red-500">*</span>
            </label>
            <select name="fields_id" 
                    id="field_id"
                    class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 text-base"
                    required>
                <option value="">اختر مجال الدراسة</option>
                @foreach($fieldsOfStudy as $field)
                    <option value="{{ $field->id }}" {{ old('field_id') == $field->id ? 'selected' : '' }}>
                        {{ $field->name }} - {{ $field->study_level }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">مثال: العلوم الرياضية، العلوم التجريبية، الآداب</p>
    <!-- Documents -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="certificate" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                الشهادة المدرسية <span class="text-red-500">*</span>
            </label>
            <input type="file" 
                   name="certificate_schol" 
                   id="certificate" 
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                   required>
            <p class="text-xs text-gray-500 mt-1">الحد الأقصى 5 ميجابايت - PDF, JPG, PNG</p>
        </div>

        <div>
            <label for="transcript" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                كشف النقاط <span class="text-red-500">*</span>
            </label>
            <input type="file" 
                   name="transcript" 
                   id="transcript" 
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                   required>
            <p class="text-xs text-gray-500 mt-1">الحد الأقصى 5 ميجابايت - PDF, JPG, PNG</p>
        </div>
    </div>

    <!-- Parent Information Section -->
    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mt-6">👨‍👩‍👧‍👦 معلومات الأبوين</h3>
    
    <!-- Father Information -->
    <div class="bg-blue-50 rounded-xl p-4">
        <h4 class="text-lg font-semibold text-blue-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            معلومات الأب
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="father_name" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    اسم الأب الكامل
                </label>
                <input type="text" 
                       name="father_name" 
                       id="father_name" 
                       value="{{ old('father_name') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                       placeholder="أدخل اسم الأب">
            </div>
            <div>
                <label for="father_job" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    وظيفة الأب
                </label>
                <input type="text" 
                       name="father_job" 
                       id="father_job" 
                       value="{{ old('father_job') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                       placeholder="مثال: مهندس، طبيب، أستاذ">
            </div>
            <div>
                <label for="father_phone" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    رقم هاتف الأب
                </label>
                <input type="tel" 
                       name="father_phone" 
                       id="father_phone" 
                       value="{{ old('father_phone') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                       placeholder="رقم الهاتف">
            </div>
            <div>
                <label for="father_email" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    البريد الإلكتروني للأب
                </label>
                <input type="email" 
                       name="father_email" 
                       id="father_email" 
                       value="{{ old('father_email') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                       placeholder="example@email.com">
            </div>
        </div>
    </div>

    <!-- Mother Information -->
    <div class="bg-pink-50 rounded-xl p-4">
        <h4 class="text-lg font-semibold text-pink-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            معلومات الأم
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="mother_name" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    اسم الأم الكامل
                </label>
                <input type="text" 
                       name="mother_name" 
                       id="mother_name" 
                       value="{{ old('mother_name') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-base text-right"
                       placeholder="أدخل اسم الأم">
            </div>
            <div>
                <label for="mother_job" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    وظيفة الأم
                </label>
                <input type="text" 
                       name="mother_job" 
                       id="mother_job" 
                       value="{{ old('mother_job') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-base text-right"
                       placeholder="مثال: طبيبة، معلمة، ربة منزل">
            </div>
            <div>
                <label for="mother_phone" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    رقم هاتف الأم
                </label>
                <input type="tel" 
                       name="mother_phone" 
                       id="mother_phone" 
                       value="{{ old('mother_phone') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-base text-right"
                       placeholder="رقم الهاتف">
            </div>
            <div>
                <label for="mother_email" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    البريد الإلكتروني للأم
                </label>
                <input type="email" 
                       name="mother_email" 
                       id="mother_email" 
                       value="{{ old('mother_email') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-base text-right"
                       placeholder="example@email.com">
            </div>
        </div>
    </div>

    <!-- Family Information -->
    <div class="bg-green-50 rounded-xl p-4">
        <h4 class="text-lg font-semibold text-green-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-4H7v4M7 3v4h10V3"/>
            </svg>
            معلومات العائلة
        </h4>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="parent_address" class="block text-sm font-semibold text-gray-700 mb-2 text-right">
                    عنوان السكن
                </label>
                <textarea 
                    name="parent_address" 
                    id="parent_address" 
                    rows="2"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base text-right"
                    placeholder="العنوان الكامل">{{ old('parent_address') }}</textarea>
            </div>
            
        </div>
    </div>

    <!-- Note -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-yellow-800 mb-1">ملاحظة هامة</h4>
                <p class="text-sm text-yellow-700">
                    سيتم مراجعة المستندات المرفقة من قبل الإدارة. يرجى التأكد من وضوح جميع المعلومات قبل الإرسال.
                </p>
            </div>
        </div>
    </div>
</div>

            <!-- Researcher Specific Fields -->
            <div id="researcher-fields" class="space-y-6 hidden">
                <h3 class="text-xl font-bold text-gray-800 border-b pb-2">معلومات الباحث</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="field_of_study" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            مجال الدراسة
                        </label>
                        <input type="text" 
                               name="field_of_study" 
                               id="field_of_study" 
                               value="{{ old('field_of_study') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base text-right"
                               placeholder="مثال: الرياضيات">
                    </div>
                    
                    <div>
                        <label for="institution" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            المؤسسة التعليمية
                        </label>
                        <input type="text" 
                               name="institution" 
                               id="institution" 
                               value="{{ old('institution') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base text-right"
                               placeholder="اسم الجامعة أو المؤسسة">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="country" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            الدولة
                        </label>
                        <input type="text" 
                               name="country" 
                               id="country" 
                               value="{{ old('country') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base text-right"
                               placeholder="الدولة">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            المدينة
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city" 
                               value="{{ old('city') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base text-right"
                               placeholder="المدينة">
                    </div>
                    
                    <div>
                        <label for="degree" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            الدرجة العلمية
                        </label>
                        <select name="degree" 
                                id="degree"
                                class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base">
                            <option value="">اختر الدرجة</option>
                            <option value="Master" {{ old('degree') == 'Master' ? 'selected' : '' }}>ماجستير</option>
                            <option value="PhD" {{ old('degree') == 'PhD' ? 'selected' : '' }}>دكتوراه</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="certificate" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        الشهادة (PDF أو صورة)
                    </label>
                    <input type="file" 
                           name="certificate" 
                           id="certificate" 
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-base">
                    <p class="text-sm text-gray-500 mt-1">الحد الأقصى 2 ميجابايت - الصيغ المسموحة: PDF, JPG, PNG</p>
                </div>
            </div>

            <!-- Video Creator Specific Fields -->
            <div id="video-creator-fields" class="space-y-6 hidden">
                <h3 class="text-xl font-bold text-gray-800 border-b pb-2">معلومات منشئ الفيديو</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="specialization" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            التخصص <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="specialization" 
                               id="specialization" 
                               value="{{ old('specialization') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-base text-right"
                               placeholder="مثال: رياضيات، فيزياء، كيمياء"
                               data-required="video_creator">
                        <p class="text-sm text-gray-500 mt-1">التخصص الذي ستنتج فيه الفيديوهات</p>
                    </div>
                    
                    <div>
                        <label for="preferred_software" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                            البرامج المفضلة
                        </label>
                        <input type="text" 
                               name="preferred_software" 
                               id="preferred_software" 
                               value="{{ old('preferred_software') }}"
                               class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-base text-right"
                               placeholder="مثال: Adobe Premiere, After Effects, DaVinci Resolve">
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-3 text-right">
                        المهارات <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="مونتاج" {{ in_array('مونتاج', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">🎬 مونتاج</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="رسوم متحركة" {{ in_array('رسوم متحركة', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">✨ رسوم متحركة</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="تعليق صوتي" {{ in_array('تعليق صوتي', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">🎙️ تعليق صوتي</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="مؤثرات بصرية" {{ in_array('مؤثرات بصرية', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">✨ مؤثرات بصرية</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="كتابة سيناريو" {{ in_array('كتابة سيناريو', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">📝 كتابة سيناريو</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="تصوير" {{ in_array('تصوير', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">📹 تصوير</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="إضاءة" {{ in_array('إضاءة', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">💡 إضاءة</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="checkbox" name="skills[]" value="تلوين" {{ in_array('تلوين', old('skills', [])) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm">🎨 تلوين</span>
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">اختر المهارات التي تجيدها (يمكن اختيار أكثر من واحدة)</p>
                </div>

                <div>
                    <label for="portfolio_url" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                        رابط معرض الأعمال (اختياري)
                    </label>
                    <input type="url" 
                           name="portfolio_url" 
                           id="portfolio_url" 
                           value="{{ old('portfolio_url') }}"
                           class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-base text-right"
                           placeholder="https://youtube.com/... أو https://portfolio.com/...">
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-orange-800 mb-1">ملاحظة هامة</h4>
                            <p class="text-sm text-orange-700">
                                سيتم مراجعة طلب التسجيل الخاص بك من قبل الإدارة قبل تفعيل الحساب. سيتم إشعارك عبر البريد الإلكتروني عند التفعيل.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-[1.01] duration-200">
                    إنشاء حساب
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="mt-8 text-center text-base">
            <p class="text-gray-700">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 hover:underline transition-colors">
                    تسجيل الدخول
                </a>
            </p>
        </div>
    </div>

    <script>
        // Show/hide fields based on user type selection
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeRadios = document.querySelectorAll('input[name="user_type"]');
            const studentFields = document.getElementById('student-fields');
            const teacherFields = document.getElementById('teacher-fields');
            const researcherFields = document.getElementById('researcher-fields');
            const videoCreatorFields = document.getElementById('video-creator-fields');

            function toggleFields() {
                const selectedType = document.querySelector('input[name="user_type"]:checked')?.value;
                
                // Hide all fields first
                if (studentFields) studentFields.classList.add('hidden');
                if (teacherFields) teacherFields.classList.add('hidden');
                if (researcherFields) researcherFields.classList.add('hidden');
                if (videoCreatorFields) videoCreatorFields.classList.add('hidden');
                
                // Show appropriate fields
                if (selectedType === 'student') {
                    if (studentFields) studentFields.classList.remove('hidden');
                } else if (selectedType === 'teacher') {
                    if (teacherFields) teacherFields.classList.remove('hidden');
                } else if (selectedType === 'researcher') {
                    if (researcherFields) researcherFields.classList.remove('hidden');
                } else if (selectedType === 'video_creator') {
                    if (videoCreatorFields) videoCreatorFields.classList.remove('hidden');
                }
            }

            userTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleFields);
            });

            // Initial toggle based on old value
            toggleFields();
        });
    </script>
</body>
</html>