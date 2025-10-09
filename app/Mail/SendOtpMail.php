<?php
namespace App\Mail;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
use Queueable, SerializesModels;

public $otp;

public function __construct(Otp $otp)
{
$this->otp = $otp;
}

// عنوان البريد
public function envelope(): Envelope
{
return new Envelope(
subject: 'Your OTP Verification Code',
);
}

// محتوى البريد: نستخدم view موجودة
public function content(): Content
{
return new Content(
view: 'emails.send_otp', // أنشئ هذه الـ view
);
}

public function attachments(): array
{
return [];
}
}
