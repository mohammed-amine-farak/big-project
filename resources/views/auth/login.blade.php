<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - مدرستي نور</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts (Cairo for Arabic, Inter for Modern UI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Apply Cairo font for Arabic and Inter as a fallback for general UI */
        body {
            font-family: 'Cairo', 'Inter', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            background-color: #f0f4f8; /* Light blue-gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full viewport height */
            margin: 0;
            padding: 1rem; /* Add some padding for small screens */
            box-sizing: border-box; /* Ensures padding doesn't affect width calculations */
        }
        .font-black {
            font-weight: 900;
        }
    </style>
</head>
<body>
    <div class="bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md border border-gray-200">
        <!-- Login Form Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-blue-900 mb-2">تسجيل الدخول</h1>
            <p class="text-gray-600 text-lg">أدخل بياناتك للمتابعة</p>
        </div>

        <!-- Login Form -->
        <form action="#" method="POST" class="space-y-6">
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                    البريد الإلكتروني
                </label>
                <input type="email" id="email" name="email"
                    class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                    placeholder="example@email.com" required>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-lg font-semibold text-gray-700 mb-2 text-right">
                    كلمة المرور
                </label>
                <input type="password" id="password" name="password"
                    class="block w-full px-5 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base text-right"
                    placeholder="أدخل كلمة المرور الخاصة بك" required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        style="transform: scale(1.2); margin-left: 0.5rem;"> <!-- Adjusted for RTL checkbox -->
                    <label for="remember-me" class="mr-2 block text-base text-gray-900">
                        تذكرني
                    </label>
                </div>
                <div class="text-base">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500 hover:underline transition-colors">
                        نسيت كلمة المرور؟
                    </a>
                </div>
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-[1.01] duration-200">
                    تسجيل الدخول
                </button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-8 text-center text-base">
            <p class="text-gray-700">
                ليس لديك حساب؟
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500 hover:underline transition-colors">
                    سجل حساب جديد الآن!
                </a>
            </p>
        </div>
    </div>
</body>
</html>
