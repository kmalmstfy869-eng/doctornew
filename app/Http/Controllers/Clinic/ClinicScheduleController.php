<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\ClinicSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicScheduleController extends Controller
{
    /**
     * عرض جدول العيادة
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $schedules = $doctor->clinicSchedules()
            ->orderBy('day_of_week')
            ->get();

        $usedDays = $schedules
            ->pluck('day_of_week')
            ->toArray();

        return view('doctor.clinic.schedules.index', compact(
            'doctor',
            'schedules',
            'usedDays'
        ));
    }

    /**
     * إضافة يوم جديد
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $validated = $request->validate(
            [
                'day_of_week' => [
                    'required',
                    'integer',
                    'between:0,6',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'slot_duration' => [
                    'required',
                    'integer',
                    'min:5',
                    'max:240',
                ],

                'is_active' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'day_of_week.required' => 'يجب تحديد اليوم.',
                'day_of_week.integer' => 'رقم اليوم غير صحيح.',
                'day_of_week.between' => 'اليوم المحدد غير صحيح.',

                'start_time.required' => 'يجب تحديد وقت البداية.',
                'start_time.date_format' => 'صيغة وقت البداية غير صحيحة.',

                'end_time.required' => 'يجب تحديد وقت النهاية.',
                'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة.',

                'slot_duration.required' => 'يجب تحديد مدة الموعد.',
                'slot_duration.integer' => 'مدة الموعد يجب أن تكون رقمًا صحيحًا.',
                'slot_duration.min' => 'مدة الموعد يجب ألا تقل عن 5 دقائق.',
                'slot_duration.max' => 'مدة الموعد يجب ألا تزيد عن 240 دقيقة.',

                'is_active.boolean' => 'حالة اليوم غير صحيحة.',
            ]
        );

        if ($validated['start_time'] >= $validated['end_time']) {
            return back()
                ->withErrors([
                    'end_time' => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
                ])
                ->withInput();
        }

        $exists = $doctor->clinicSchedules()
            ->where('day_of_week', $validated['day_of_week'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'day_of_week' => 'هذا اليوم موجود بالفعل في جدول العيادة.',
                ])
                ->withInput();
        }

        $doctor->clinicSchedules()->create([
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'slot_duration' => $validated['slot_duration'],
            'is_active' => !empty($validated['is_active']),
        ]);

        return back()->with(
            'success',
            'تمت إضافة اليوم إلى جدول العيادة بنجاح.'
        );
    }

    /**
     * تعديل يوم
     */
    public function update(Request $request, ClinicSchedule $schedule)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $schedule = $doctor->clinicSchedules()
            ->findOrFail($schedule->id);

        $validated = $request->validate(
            [
                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'slot_duration' => [
                    'required',
                    'integer',
                    'min:5',
                    'max:240',
                ],

                'is_active' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'start_time.required' => 'يجب تحديد وقت البداية.',
                'start_time.date_format' => 'صيغة وقت البداية غير صحيحة.',

                'end_time.required' => 'يجب تحديد وقت النهاية.',
                'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة.',

                'slot_duration.required' => 'يجب تحديد مدة الموعد.',
                'slot_duration.integer' => 'مدة الموعد يجب أن تكون رقمًا صحيحًا.',
                'slot_duration.min' => 'مدة الموعد يجب ألا تقل عن 5 دقائق.',
                'slot_duration.max' => 'مدة الموعد يجب ألا تزيد عن 240 دقيقة.',

                'is_active.boolean' => 'حالة اليوم غير صحيحة.',
            ]
        );

        if ($validated['start_time'] >= $validated['end_time']) {
            return back()
                ->withErrors([
                    'end_time' => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
                ])
                ->withInput();
        }

        $schedule->update([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'slot_duration' => $validated['slot_duration'],
            'is_active' => !empty($validated['is_active']),
        ]);

        return back()->with(
            'success',
            'تم تعديل جدول اليوم بنجاح.'
        );
    }

    /**
     * حذف يوم
     */
    public function destroy(ClinicSchedule $schedule)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $schedule = $doctor->clinicSchedules()
            ->findOrFail($schedule->id);

        $schedule->delete();

        return back()->with(
            'success',
            'تم حذف اليوم من جدول العيادة.'
        );
    }
}
