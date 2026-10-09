<?php

namespace App\Policies;

use App\Models\PatientFile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientFilePolicy
{
    // مساعد الطبيب ممنوع من الملفات الطبية كلها. غير كده بنرجّع id الدكتور صاحب العيادة.
    private function doctorId(User $user): ?int
    {
        if ($user->doctorAssistant) {
            return null;
        }

        return $user->clinicDoctor()?->id;
    }

    public function viewAny(User $user): bool
    {
        return $this->doctorId($user) !== null;
    }

    public function create(User $user): bool
    {
        return $this->doctorId($user) !== null;
    }

    // لو الملف مش بتاعه نرجّع 404 مش 403، عشان ما نكشفش إن الملف موجود أصلًا.
    public function view(User $user, PatientFile $file): Response
    {
        $id = $this->doctorId($user);

        return ($id !== null && (int) $file->doctor_id === $id)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, PatientFile $file): Response
    {
        return $this->view($user, $file);
    }
}
