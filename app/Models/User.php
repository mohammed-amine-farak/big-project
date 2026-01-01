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
    public function adminProfile()
    {
        return $this->hasOne(Admin::class,'id');
    }
}
