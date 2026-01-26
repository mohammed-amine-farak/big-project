<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة الاختبار - {{ $exam->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info-item {
            text-align: center;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            .header {
                border-bottom: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            🖨️ طباعة
        </button>
        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">
            إغلاق
        </button>
    </div>

    <div class="header">
        <h1>{{ $exam->title }}</h1>
        <p>اختبار أسبوعي</p>
    </div>

    <div class="info">
        <div class="info-item">
            <div class="info-label">الصف الدراسي</div>
            <div class="info-value">{{ $exam->classroom->class_name ?? 'غير معروف' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">المادة</div>
            <div class="info-value">{{ $exam->subject->name ?? 'غير معروف' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">تاريخ الإنشاء</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($exam->created_at)->format('Y/m/d') }}</div>
        </div>
    </div>

    @if($exam->file_path)
    <div style="text-align: center; margin-top: 30px; padding: 20px; border: 2px dashed #ccc; border-radius: 5px;">
        <p style="margin-bottom: 10px;">الاختبار متوفر كملف مرفق</p>
        <p style="font-size: 12px; color: #666;">يمكن طباعة الملف من خلال فتحه</p>
    </div>
    @else
    <div style="text-align: center; margin-top: 50px; padding: 40px; border: 1px solid #ddd; border-radius: 5px;">
        <p>لا يوجد ملف مرفق للاختبار</p>
        <p style="font-size: 12px; color: #666; margin-top: 10px;">يمكن استخدام هذه الصفحة كنسخة من الاختبار</p>
    </div>
    @endif

    <div class="footer">
        <p>تم الطباعة في: {{ now()->format('Y/m/d H:i') }}</p>
        <p>نظام إدارة الاختبارات</p>
    </div>

    <script>
        window.onload = function() {
            // Optionally auto-print
            // window.print();
        }
    </script>
</body>
</html>