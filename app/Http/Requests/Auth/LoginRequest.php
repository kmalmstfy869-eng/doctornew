<?php
namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * تحديد صلاحية تنفيذ الطلب
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق من البيانات
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'email' => [
                'required',
                'string',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],

        ];
    }

    /**
     * رسائل التحقق
     */
    public function messages(): array
    {
        return [

            // البريد الإلكتروني
            'email.required' => 'البريد الإلكتروني مطلوب.',

            'email.string' => 'البريد الإلكتروني يجب أن يكون نصًا.',

            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',


            // كلمة المرور
            'password.required' => 'كلمة المرور مطلوبة.',

            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',

        ];
    }

    /**
     * محاولة تسجيل الدخول
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        )) {

            RateLimiter::hit(
                $this->throttleKey()
            );

            throw ValidationException::withMessages([

                'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',

            ]);
        }

        RateLimiter::clear(
            $this->throttleKey()
        );
    }

    /**
     * التأكد من عدم تجاوز عدد محاولات تسجيل الدخول
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            5
        )) {

            return;
        }

        event(
            new Lockout($this)
        );



        throw ValidationException::withMessages([
            'email' => 'لقد تجاوزت عدد محاولات تسجيل الدخول المسموح بها. يرجى المحاولة مرة أخرى بعد قليل.',
        ]);
    }

    /**
     * إنشاء المفتاح الخاص بتحديد محاولات تسجيل الدخول
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower(
                $this->string('email')
            ) . '|' . $this->ip()
        );
    }
}

