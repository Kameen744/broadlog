<?php

namespace App\Notifications;

use App\Models\Advert\AdvertFile;
use Illuminate\Bus\Queueable;
use App\Models\Advert\AdvertSchedule;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertPlayed extends Notification implements ShouldQueue
{
    use Queueable;

    public $slots;
    public $total_played;
    public $name;
    public $date_played;
    public $time_played;
    public $phone;
    public $remaining;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AdvertSchedule $schedule, $phone)
    {
        $allSlots = AdvertSchedule::where('advert_id', $schedule->advert_id);
        $file = AdvertFile::where('id', $schedule->file_id)->first();
        $this->phone = $phone;
        $this->slots = $allSlots->count();
        $this->total_played = $allSlots->where('played', 1)->count();
        $this->name = $file->name;
        // $this->date_played = date('d-m-Y', strtotime($schedule->play_date));
        // $this->time_played = date('h:i A', strtotime($schedule->play_time));
        $this->time_played =  date_format(now(), 'h:i A');
        $this->date_played = date_format(now(), 'D d m Y');

        $this->remaining = $this->slots - $this->total_played;

        // $this->sendEmail();
        if (env('SMS_NOTIFICATION')) {
            $this->sendSMS();
        }
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
        if (env('EMAIL_NOTIFICATION')) {
            return (new MailMessage)
                ->markdown('emails.advert-played', [
                    'slots'             => $this->slots,
                    'total_played'      => $this->total_played,
                    'name'              => $this->name,
                    'date_played'       => $this->date_played,
                    'time_played'       => $this->time_played
                ]);
        }
    }

    public function sendSMS()
    {
        $sms = env('STATION_NAME') . " " . env('STATION_LOCATION') . " notification for {$this->name} campaign \nSlots: {$this->slots} Played: {$this->total_played} Remaining: {$this->remaining} \nDate Played: {$this->date_played} \nTime Played: {$this->time_played}";
        $message = urlencode($sms);
        $sender = urlencode('Broad-Ad');
        $to = $this->phone;
        $token = 'IBoNvO0KmFkSg1UxPrV6PPCLjTFUuvdzafmODhr8J8ggrymJpG0SUcKxGkU6Whk1flgWqq2HBqdmIReNIm81WuijS4RoVkFtUhiw';
        $routing = 3;
        $type = 0;
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';
        $sendsms = $baseurl . 'message=' . $message . '&to=' . $to . '&sender=' . $sender . '&type=' . $type . '&routing=' . $routing . '&token=' . $token;

        try {
            file_get_contents($sendsms);
        } catch (\Throwable $th) {
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
