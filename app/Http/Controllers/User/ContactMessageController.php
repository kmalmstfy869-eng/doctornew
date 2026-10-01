<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(){
        return view('home.contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ], [
            'name.string' => 'الاسم يجب أن يكون نصًا صحيحًا.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا.',

            'phone.regex' => 'من فضلك أدخل رقم هاتف مصري صحيح.',

            'message.required' => 'من فضلك اكتب رسالتك.',
            'message.string' => 'الرسالة يجب أن تكون نصًا صحيحًا.',
            'message.min' => 'الرسالة يجب ألا تقل عن 10 أحرف.',
            'message.max' => 'الرسالة يجب ألا تتجاوز 5000 حرف.',
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->back()
            ->with('success', 'تم إرسال رسالتك بنجاح، شكرًا لتواصلك معنا.');
    }
    public function messages()
    {
       $messages=ContactMessage::query()->latest()->paginate(15);

        return view('admin.contact.index',compact('messages'));
    }
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->back()
            ->with('success', 'تم حذف رسالة التواصل بنجاح.');
    }

}
