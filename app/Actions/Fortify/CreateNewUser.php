<?php
// app/Actions/Fortify/CreateNewUser.php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Researcher;
use App\Models\Researchers;
use App\Models\video_creator;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        // قواعد التحقق الأساسية
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'user_type' => ['required', 'in:teacher,researcher,parent,student,admin,video_creator'],
        ];

        // إضافة قواعد حسب نوع المستخدم
        if ($input['user_type'] === 'teacher') {
            $rules['school_level'] = ['nullable', 'string'];
            $rules['school'] = ['nullable', 'string'];
            $rules['subject'] = ['nullable', 'string'];
        }

        if ($input['user_type'] === 'researcher') {
            $rules['field_of_study'] = ['nullable', 'string'];
            $rules['institution'] = ['nullable', 'string'];
            $rules['country'] = ['nullable', 'string'];
            $rules['city'] = ['nullable', 'string'];
            $rules['degree'] = ['nullable', 'in:Master,PhD'];
            $rules['certificate'] = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'];
        }

        // ✅ قواعد التحقق للطالب (Student)
        if ($input['user_type'] === 'student') {
            $rules['school_level'] = ['nullable', 'string', 'in:الابتدائي,المتوسط,الثانوي,الجامعي'];
            $rules['fields_id'] = ['required', 'exists:fields_of_studies,id'];
            $rules['birth_date'] = ['nullable', 'date', 'before:today'];
              $rules['certificate_schol'] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
            
               $rules['father_name'] = ['nullable', 'string', 'max:255'];
    $rules['father_job'] = ['nullable', 'string', 'max:255'];
    $rules['father_phone'] = ['nullable', 'string', 'max:20'];
    $rules['father_email'] = ['nullable', 'email', 'max:255'];
    $rules['mother_name'] = ['nullable', 'string', 'max:255'];
    $rules['mother_job'] = ['nullable', 'string', 'max:255'];
    $rules['mother_phone'] = ['nullable', 'string', 'max:20'];
    $rules['mother_email'] = ['nullable', 'email', 'max:255'];
    $rules['parent_address'] = ['nullable', 'string', 'max:500'];
   
        }

        // ✅ قواعد التحقق لمنشئ الفيديو
        if ($input['user_type'] === 'video_creator') {
            $rules['specialization'] = ['required', 'string', 'max:255'];
            $rules['skills'] = ['required', 'array', 'min:1'];
            $rules['skills.*'] = ['string'];
            $rules['preferred_software'] = ['nullable', 'string', 'max:255'];
            $rules['portfolio_url'] = ['nullable', 'url', 'max:255'];
        }

        // التحقق من صحة البيانات
        Validator::make($input, $rules)->validate();

        // رفع الشهادة إذا كانت موجودة (للباحثين)
        $certificatePath = null;
        
        if (isset($input['certificate']) && $input['certificate']) {
            $certificatePath = $input['certificate']->store('certificates', 'public');
        }

        // إنشاء المستخدم
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_type' => $input['user_type'],
        ]);

        // إنشاء الملف الشخصي حسب نوع المستخدم
        switch ($input['user_type']) {
            case 'teacher':
                Teacher::create([
                    'id' => $user->id,
                    'school_level' => $input['school_level'] ?? null,
                    'school' => $input['school'] ?? null,
                    'subject' => $input['subject'] ?? null,
                ]);
                break;

            case 'researcher':
                Researchers::create([
                    'id' => $user->id,
                    'field_of_study' => $input['field_of_study'] ?? null,
                    'institution' => $input['institution'] ?? null,
                    'country' => $input['country'] ?? null,
                    'city' => $input['city'] ?? null,
                    'degree' => $input['degree'] ?? null,
                    'certificate_path' => $certificatePath,
                ]);
                break;

            // ✅ إنشاء الطالب (Student)
            case 'student':
                Student::create([
                    'id' => $user->id,
                    'school_level' => $input['school_level'] ?? null,
                    'fields_id' => $input['fields_id'] ,
                    'birth_date' => $input['birth_date'] ?? null,
                     'certificate_path' => $certificatePath,
                   
                    'father_name' => $input['father_name'] ?? null,
        'father_job' => $input['father_job'] ?? null,
        'father_phone' => $input['father_phone'] ?? null,
        'father_email' => $input['father_email'] ?? null,
        'mother_name' => $input['mother_name'] ?? null,
        'mother_job' => $input['mother_job'] ?? null,
        'mother_phone' => $input['mother_phone'] ?? null,
        'mother_email' => $input['mother_email'] ?? null,
        'parent_address' => $input['parent_address'] ?? null,
                ]);
                break;

            // ✅ إنشاء منشئ الفيديو
            case 'video_creator':
                video_creator::create([
                    'id' => $user->id,
                    'specialization' => $input['specialization'],
                    'skills' => json_encode($input['skills']), // تحويل المصفوفة إلى JSON
                    'preferred_software' => $input['preferred_software'] ?? null,
                    'portfolio_url' => $input['portfolio_url'] ?? null,
                    'completed_videos' => 0,
                    'average_rating' => 0,
                    'total_ratings' => 0,
                    'total_rating_sum' => 0,
                    'status' => 'active',
                ]);
                break;

            case 'parent':
                // Parent::create([...]);
                break;

            case 'admin':
                // Admin لا يحتاج ملف شخصي إضافي
                break;
        }

        return $user;
    }
}