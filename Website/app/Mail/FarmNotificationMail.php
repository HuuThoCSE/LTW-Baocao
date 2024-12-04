<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FarmNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userDetails; // Thông tin tài khoản người dùng

    /**
     * Create a new message instance.
     *
     * @param array $userDetails Thông tin người dùng (tên, email, mật khẩu)
     */
    public function __construct(array $userDetails)
    {
        $this->userDetails = $userDetails; // Gán thông tin người dùng
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông Tin Tài Khoản Nông Trại', // Tiêu đề email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_details', // Giao diện email
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
