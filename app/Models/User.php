<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\researchers;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'account_status',
    'rejection_reason',
    'approved_at',
    'approved_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function studentProfile() // Defines the One-to-One relationship
    {
        
        return $this->hasOne(Student::class,'id');
    }
    public function researcherProfile()
    {
        // Tell Eloquent that the foreign key on the 'researchers' table
        // that links back to 'users' is 'id' (its primary key), not 'user_id'.
        return $this->hasOne(researchers::class, 'id');
    }

    public function authoredLessons()
    {
        // This remains correct based on lessonss.researcher_id pointing to users.id
        return $this->hasMany(Lessonss::class, 'researcher_id');
    }
   public function teacherProfile()
    {
        return $this->hasOne(Teacher::class,'id');
    }   
     public function videoCreatorProfile()
    {
        return $this->hasOne(video_creator::class,'id');
    }   
    public function adminProfile()
    {
        return $this->hasOne(Admin::class,'id');
    }
    public function isTeacher()
    {
        return $this->user_type === 'teacher';
    }
    public function isStudent()
    {
        return $this->user_type === 'student';
    }
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isVideoCreator()
    {
        return $this->user_type === 'video_creator';
    }
     public function isParent()
    {
        return $this->user_type === 'parent';
    }
    public function isResearcher()
    {
        return $this->user_type === 'researcher';
    }
 public function getUserTypeArabicAttribute()
    {
        return match($this->user_type) {
            'teacher' => 'معلم',
            'researcher' => 'باحث',
            'parent' => 'ولي أمر',
            'student' => 'طالب',
            'admin' => 'مدير',
            'video_creator' => 'منشئ فيديوهات',
            default => 'غير محدد',
        };
    }
     public function getDashboardRoute()
    {
        return match($this->user_type) {
            'teacher' => route('teacher.dashboard'),
            'researcher' => route('lessons.index'),
           // 'parent' => route('parent.dashboard'),
            //'student' => route('student.dashboard'),
            //'admin' => route('admin.dashboard'),
            //'video_creator' => route('video-creator.dashboard'),
            default => route('dashboard'),
        };

    }
    public function isPending()
{
    return $this->account_status === 'pending';
}

public function isApproved()
{
    return $this->account_status === 'approved';
}

public function isRejected()
{
    return $this->account_status === 'rejected';
}

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

public function canAccessDashboard()
{
    return $this->isApproved() || $this->user_type === 'admin';
}

public function getAccountStatusArabicAttribute()
{
    return match($this->account_status) {
        'pending' => '⏳ قيد المراجعة',
        'approved' => '✅ مقبول',
        'rejected' => '❌ مرفوض',
        default => 'غير معروف',
    };
}

public function getAccountStatusColorAttribute()
{
    return match($this->account_status) {
        'pending' => 'yellow',
        'approved' => 'green',
        'rejected' => 'red',
        default => 'gray',
    };
}
}
