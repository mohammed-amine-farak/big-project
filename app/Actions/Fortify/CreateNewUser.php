<?php
// app/Actions/Fortify/CreateNewUser.php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\teacher;

use App\Models\Researchers;
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

            // يمكن إضافة أنواع أخرى لاحقاً
            case 'parent':
                // Parent::create([...]);
                break;

            case 'student':
                // Student::create([...]);
                break;

            case 'video_creator':
                // VideoCreator::create([...]);
                break;

            case 'admin':
                // Admin لا يحتاج ملف شخصي إضافي
                break;
        }

        return $user;
    }
}