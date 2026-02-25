{{-- resources/views/teacher-dashboard/dashboard.blade.php --}}
@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen" dir="rtl">
    <div class="max-w-7xl mx-auto">
        
        <!-- Welcome Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">مرحباً بك في لوحة التحكم</h1>
                            <p class="text-gray-600 mt-1">نظرة شاملة على أدائك التعليمي وإحصائيات الطلاب</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-xl text-sm font-medium">
                            {{ now()->format('Y/m/d') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">إجمالي الطلاب</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                            <span>▲</span> +{{ $newStudentsThisMonth ?? 0 }} هذا الشهر
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Classrooms -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">الصفوف الدراسية</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalClassrooms ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $activeClassrooms ?? 0 }} صف نشط</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Exams -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">الاختبارات</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalExams ?? 0 }}</p>
                        <p class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                            <span>📊</span> {{ $examsThisMonth ?? 0 }} هذا الشهر
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reports Sent -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">التقارير المرسلة</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalReports ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                            <span>✓</span> {{ $pendingReports ?? 0 }} قيد المراجعة
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Student Performance Chart -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">📊 أداء الطلاب في الاختبارات</h3>
                </div>
                <div style="height: 300px; width: 100%;">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>

            <!-- Reports Status Chart -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">📋 حالة التقارير النفسية</h3>
                </div>
                <div style="height: 300px; width: 100%;">
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Second Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Student Mood Distribution -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">😊 توزيع الحالة المزاجية للطلاب</h3>
                </div>
                <div style="height: 250px; width: 100%;">
                    <canvas id="moodChart"></canvas>
                </div>
            </div>

            <!-- Lesson Reports by Type -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">📝 تقارير الدروس حسب النوع</h3>
                </div>
                <div style="height: 250px; width: 100%;">
                    <canvas id="lessonReportsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recent Exams -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">📝 أحدث الاختبارات</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($recentExams ?? [] as $exam)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $exam->title ?? 'اختبار' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $exam->classroom->class_name ?? 'غير محدد' }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $exam->created_at ? $exam->created_at->diffForHumans() : '' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        لا توجد اختبارات حديثة
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Psychology Reports -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">🧠 أحدث التقارير النفسية</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($recentPsychologyReports ?? [] as $report)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->student->user->name ?? 'طالب' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    المزاج: {{ $report->mood ?? 'غير محدد' }} | السلوك: {{ $report->behavior ?? 'غير محدد' }}
                                </p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ ($report->status ?? '') == 'مسودة' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                {{ $report->status ?? 'مسودة' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        لا توجد تقارير نفسية حديثة
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Lesson Reports -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">📚 أحدث تقارير الدروس</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($recentLessonReports ?? [] as $report)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->title ?? 'تقرير' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $report->lesson->title ?? 'درس' }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ ($report->priority ?? '') == 'high' ? 'bg-red-100 text-red-700' : 
                                   (($report->priority ?? '') == 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $report->priority ?? 'low' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        لا توجد تقارير دروس حديثة
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ إجراءات سريعة</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="" class="bg-blue-50 hover:bg-blue-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-blue-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">إضافة اختبار</span>
                </a>
                
                <a href="" class="bg-purple-50 hover:bg-purple-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-purple-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">تقرير نفسي</span>
                </a>
                
                <a href="" class="bg-emerald-50 hover:bg-emerald-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-emerald-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">تقرير درس</span>
                </a>
                
                <a href="" class="bg-amber-50 hover:bg-amber-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-amber-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">الاختبارات</span>
                </a>
                
                <a href="" class="bg-red-50 hover:bg-red-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-red-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">الدروس</span>
                </a>
                
                <a href="" class="bg-indigo-50 hover:bg-indigo-100 rounded-xl p-4 text-center transition group">
                    <svg class="w-8 h-8 mx-auto text-indigo-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">التقارير</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure chart containers exist before creating charts
        const performanceCanvas = document.getElementById('performanceChart');
        const reportsCanvas = document.getElementById('reportsChart');
        const moodCanvas = document.getElementById('moodChart');
        const lessonReportsCanvas = document.getElementById('lessonReportsChart');

        // 1. Performance Chart
        if (performanceCanvas) {
            const performanceCtx = performanceCanvas.getContext('2d');
            new Chart(performanceCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($performanceLabels ?? ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4']) !!},
                    datasets: [{
                        label: 'متوسط الدرجات',
                        data: {!! json_encode(array_map(function($value) {
                            return min(100, max(0, $value)); // Limit between 0-100
                        }, $performanceData ?? [85, 78, 92, 88])) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { 
                            rtl: true,
                            callbacks: {
                                label: function(context) {
                                    return `المتوسط: ${context.raw}%`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: 100,
                            grid: { color: '#e5e7eb' },
                            title: { display: true, text: 'النسبة المئوية' }
                        }
                    }
                }
            });
        }

        // 2. Reports Status Chart
        if (reportsCanvas) {
            const reportsCtx = reportsCanvas.getContext('2d');
            new Chart(reportsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['مسودة', 'مرسل للإدارة', 'تم الرد'],
                    datasets: [{
                        data: [
                            {{ min(100, $draftReports ?? 5) }},
                            {{ min(100, $sentReports ?? 8) }},
                            {{ min(100, $respondedReports ?? 3) }}
                        ],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', rtl: true },
                        tooltip: { 
                            rtl: true,
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }

        // 3. Mood Distribution Chart
        if (moodCanvas) {
            const moodCtx = moodCanvas.getContext('2d');
            const moodData = {!! json_encode(array_map(function($value) {
                return min(100, max(0, $value)); // Limit data
            }, $moodData ?? [12, 25, 8, 5, 3, 15])) !!};
            
            new Chart(moodCtx, {
                type: 'bar',
                data: {
                    labels: ['😊 مبتهج', '😐 هادئ', '😟 قلق', '😢 حزين', '😠 غاضب', '🤩 متحمس'],
                    datasets: [{
                        label: 'عدد الطلاب',
                        data: moodData,
                        backgroundColor: [
                            '#fbbf24', '#94a3b8', '#f87171', '#60a5fa', '#f97316', '#c084fc'
                        ],
                        borderRadius: 8,
                        barPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { 
                            rtl: true,
                            callbacks: {
                                label: function(context) {
                                    return `${context.raw} طالب`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: '#e5e7eb' },
                            title: { display: true, text: 'عدد الطلاب' }
                        }
                    }
                }
            });
        }

        // 4. Lesson Reports Chart
        if (lessonReportsCanvas) {
            const lessonReportsCtx = lessonReportsCanvas.getContext('2d');
            const lessonData = {!! json_encode(array_map(function($value) {
                return min(100, max(0, $value)); // Limit data
            }, $lessonReportData ?? [10, 15, 5, 8, 3])) !!};
            
            new Chart(lessonReportsCtx, {
                type: 'pie',
                data: {
                    labels: ['محتوى', 'صعوبة', 'تقني', 'لغة', 'أخرى'],
                    datasets: [{
                        data: lessonData,
                        backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#10b981', '#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', rtl: true },
                        tooltip: { 
                            rtl: true,
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<style>
    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Chart containers */
    canvas {
        max-height: 100%;
        max-width: 100%;
    }
    
    /* RTL adjustments */
    [dir="rtl"] .mr-3 {
        margin-left: 0.75rem;
        margin-right: 0;
    }
</style>
@endsection