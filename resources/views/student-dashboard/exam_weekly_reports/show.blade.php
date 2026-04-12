@extends('layouts.student_dashboard')

@section('content')
<style>
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 800px; margin: 0 auto; }

.page-header { margin-bottom: 1.5rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; margin-top: 5px; }
.breadcrumb a { color: #6b6b6b; text-decoration: none; }
.breadcrumb a:hover { color: #1D9E75; }

.report-card { background: #fff; border-radius: 16px; overflow: hidden; border: 0.5px solid rgba(0,0,0,0.1); }
.card-header { background: linear-gradient(135deg, #1D9E75, #0F6E56); padding: 1.5rem; }
.card-header h2 { color: #fff; font-size: 20px; font-weight: 600; margin: 0; }

.card-body { padding: 1.5rem; }
.score-section { text-align: center; padding: 1.5rem; background: #f8f8f6; border-radius: 12px; margin-bottom: 1.5rem; }
.score-circle { width: 120px; height: 120px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
.score-value { font-size: 48px; font-weight: 700; }
.score-label { font-size: 14px; color: #6b6b6b; margin-top: 8px; }

.info-row { display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 0.5px solid rgba(0,0,0,0.08); }
.info-label { width: 120px; font-size: 13px; color: #6b6b6b; font-weight: 500; }
.info-value { flex: 1; font-size: 14px; color: #1a1a1a; }

.note-box { background: #f8f8f6; border-radius: 12px; padding: 1.5rem; margin: 1.5rem 0; }
.note-box h4 { font-size: 14px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.note-box p { font-size: 14px; color: #4a4a4a; line-height: 1.6; margin: 0; }

.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; background: transparent; border: 0.5px solid rgba(0,0,0,0.2); border-radius: 8px; text-decoration: none; color: #6b6b6b; font-size: 13px; margin-top: 1rem; }
.btn-back:hover { background: #f5f5f3; border-color: #1D9E75; color: #1D9E75; }

@media(max-width: 640px) {
    .info-row { flex-direction: column; align-items: flex-start; gap: 4px; }
    .info-label { width: auto; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-title">📄 تفاصيل نتيجة الاختبار</div>
        <div class="breadcrumb">
            <a href="">الرئيسية</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('student.exam_weekly_reports.index') }}">نتائج الاختبارات</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span style="color: #1a1a1a;">تفاصيل النتيجة</span>
        </div>
    </div>

    {{-- Report Card --}}
    <div class="report-card">
        <div class="card-header">
            <h2>{{ $report->examWeekly->title ?? 'تقرير الاختبار الأسبوعي' }}</h2>
        </div>
        <div class="card-body">
            
            {{-- Score Section --}}
            <div class="score-section">
                @php
                    $score = $report->exam_total_point;
                    if ($score >= 16) {
                        $scoreColor = '#1D9E75';
                        $scoreMessage = '🎉 ممتاز! نتيجة رائعة';
                    } elseif ($score >= 14) {
                        $scoreColor = '#1D9E75';
                        $scoreMessage = '👍 جيد جداً، استمر';
                    } elseif ($score >= 12) {
                        $scoreColor = '#D97706';
                        $scoreMessage = '📚 جيد، يمكنك التحسن أكثر';
                    } elseif ($score >= 10) {
                        $scoreColor = '#D97706';
                        $scoreMessage = '📖 مقبول، تحتاج إلى مزيد من التركيز';
                    } else {
                        $scoreColor = '#DC2626';
                        $scoreMessage = '⚠️ ضعيف، يجب بذل المزيد من الجهد';
                    }
                @endphp
                
                <div class="score-circle">
                    <div class="score-value" style="color: {{ $scoreColor }}">
                        {{ $score }}/20
                    </div>
                </div>
                <div class="score-label">
                    {{ $scoreMessage }}
                </div>
            </div>
            
            {{-- Info Rows --}}
            <div class="info-row">
                <div class="info-label">اسم الاختبار:</div>
                <div class="info-value">{{ $report->examWeekly->title ?? 'اختبار أسبوعي' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">المعلم:</div>
                <div class="info-value">{{ $report->teacher->user->name ?? 'المعلم' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">تاريخ الاختبار:</div>
                <div class="info-value">{{ $report->created_at->format('Y-m-d') }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">النقطة المستحقة:</div>
                <div class="info-value">{{ $report->exam_total_point }} من 20</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">التقدير:</div>
                <div class="info-value">
                    @if($score >= 16)
                        <span style="color: #1D9E75; font-weight: 500;">ممتاز</span>
                    @elseif($score >= 14)
                        <span style="color: #1D9E75; font-weight: 500;">جيد جداً</span>
                    @elseif($score >= 12)
                        <span style="color: #D97706; font-weight: 500;">جيد</span>
                    @elseif($score >= 10)
                        <span style="color: #D97706; font-weight: 500;">مقبول</span>
                    @else
                        <span style="color: #DC2626; font-weight: 500;">ضعيف</span>
                    @endif
                </div>
            </div>
            
            {{-- Note Box --}}
            <div class="note-box">
                <h4>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    ملاحظة المعلم
                </h4>
                <p>{{ $report->exam_note }}</p>
            </div>
            
            {{-- Back Button --}}
            <a href="{{ route('student.exam_weekly_reports.index') }}" class="btn-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة إلى قائمة النتائج
            </a>
            
        </div>
    </div>

</div>
</div>
@endsection