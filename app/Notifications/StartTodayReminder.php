<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\StudentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StartTodayReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $record;
    public $student;
    public $milestone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student,
        StudentRecord $record, Milestone $milestone)
    {
        $this->record = $record;
        $this->student = $student;
        $this->milestone = $milestone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('student.record.milestone.show', [
            $this->student->university_id,
            $this->record->slug(),
            $this->milestone->slug(),
        ]);

        $duediff = Carbon::today()->diffForHumans(
            $this->milestone->due_date->copy()
            ->addDay(1)->startOfDay(), true);

        return (new MailMessage)
            ->line('Student: '.$this->student->name.' ('.$this->student->university_id.')')
            ->line('Programme: '.$this->record->programme->name)
            ->line('Milestone: '.$this->milestone->name)
            ->line('')
            ->line('This email is to remind you that the milestone "'.$this->milestone->name.'" is due in '.$duediff.'.')
            ->action('View Milestone', $url)
            ->line('Please ensure timely submission of the requested documentation. '.
                'If you have any questions, please contact your school\'s PGR administrator '.
                'or refer to the "Postgraduate Research Degrees Regulations" at https://secretariat.blogs.lincoln.ac.uk/university-regulations/. '.
                'Failure to submit documentation for PGR milestones by the set deadline can ultimately result in '.
                'withdrawal from your PGR studies.')
            ->line('')
            ->line('Thanks!')
            ->subject('[PGR] Reminder: '.$this->milestone->name.' is due in '.$duediff);
    }
}
