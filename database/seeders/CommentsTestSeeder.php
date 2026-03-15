<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Video;
use App\Models\User;
use Carbon\Carbon;

class CommentsTestSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على أول فيديو (أو إنشاء واحد إذا لم يكن موجوداً)
        $video = Video::first();
        
        if (!$video) {
            $this->command->error('❌ لا يوجد فيديو في قاعدة البيانات');
            return;
        }

        // الحصول على بعض المستخدمين (طلاب)
        $users = User::where('user_type', 'student')->limit(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('⚠️ لا يوجد طلاب، سنستخدم أي مستخدمين متاحين');
            $users = User::limit(5)->get();
        }

        $this->command->info('✅ جاري إنشاء تعليقات تجريبية...');

        // =========================================================
        // التعليق 1: تعليق عادي
        // =========================================================
        $comment1 = Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[0]->id,
            'content' => 'فيديو رائع! الشرح واضح ومفصل. شكراً جزيلاً.',
            'parent_id' => null,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5)
        ]);

        // =========================================================
        // التعليق 2: رد على التعليق 1
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[1]->id,
            'content' => 'فعلاً، استفدت كتير من الشرح. بارك الله فيك.',
            'parent_id' => $comment1->id,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(4),
            'updated_at' => Carbon::now()->subDays(4)
        ]);

        // =========================================================
        // التعليق 3: تعليق جديد
        // =========================================================
        $comment3 = Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[2]->id,
            'content' => 'عندي سؤال بخصوص الجزء الثاني من الشرح. هل يمكن توضيح أكثر؟',
            'parent_id' => null,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(3)
        ]);

        // =========================================================
        // التعليق 4: رد على التعليق 3
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[0]->id,
            'content' => 'أنا أيضاً نفس السؤال. ياريت توضيح أكثر.',
            'parent_id' => $comment3->id,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        // =========================================================
        // التعليق 5: رد آخر على التعليق 3
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[3]->id,
            'content' => 'الجزء الثاني يحتاج تركيز، لكن الشرح ممتاز.',
            'parent_id' => $comment3->id,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1)
        ]);

        // =========================================================
        // التعليق 6: تعليق جديد (غير مقروء)
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[4]->id,
            'content' => 'فيديو ممتاز! استمر في هذا العمل الرائع.',
            'parent_id' => null,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subHours(5),
            'updated_at' => Carbon::now()->subHours(5)
        ]);

        // =========================================================
        // التعليق 7: تعليق جديد (مقروء)
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[1]->id,
            'content' => 'شكراً على المجهود الكبير. نتمنى المزيد من هذه الفيديوهات.',
            'parent_id' => null,
            'is_approved' => true,
            'read_at' => Carbon::now()->subHours(2),
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        // =========================================================
        // التعليق 8: تعليق طويل لاختبار العرض
        // =========================================================
        $comment8 = Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[2]->id,
            'content' => 'أريد أن أشكرك على هذا المحتوى القيم. لقد ساعدني كثيراً في فهم المفاهيم الصعبة. أتمنى أن تستمر في تقديم هذه الدروس لأنها مفيدة جداً للطلاب. خصوصاً أن أسلوبك في الشرح سلس ومبسط. جزاك الله خيراً.',
            'parent_id' => null,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(6),
            'updated_at' => Carbon::now()->subDays(6)
        ]);

        // =========================================================
        // التعليق 9: رد على التعليق 8
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[3]->id,
            'content' => 'بالفعل، هذا أفضل فيديو شاهدته في هذا الموضوع.',
            'parent_id' => $comment8->id,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5)
        ]);

        // =========================================================
        // التعليق 10: رد على رد
        // =========================================================
        Comment::create([
            'commentable_type' => 'App\Models\Video',
            'commentable_id' => $video->id,
            'user_id' => $users[4]->id,
            'content' => 'اتفق معك تماماً. الشرح رائع.',
            'parent_id' => $comment8->id,
            'is_approved' => true,
            'read_at' => null,
            'created_at' => Carbon::now()->subDays(4),
            'updated_at' => Carbon::now()->subDays(4)
        ]);

        $this->command->info('✅ تم إنشاء 10 تعليقات تجريبية بنجاح!');
    }
}