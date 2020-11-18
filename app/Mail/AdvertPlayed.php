<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Advert\AdvertFile;
use App\Models\Advert\AdvertSchedule;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertPlayed extends Mailable
{
    use Queueable, SerializesModels;
    public $slots;
    public $total_played;
    public $name;
    public $date_played;
    public $time_played;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AdvertSchedule $schedule)
    {
        $allSlots = AdvertSchedule::where('advert_id', $schedule->advert_id);
        $file = AdvertFile::where('id', $schedule->file_id)->first();

        $this->slots = $allSlots->count();
        $this->total_played = $allSlots->where('played', 1)->count();
        $this->name = $file->name;
        $this->date_played = date('d-m-Y', strtotime($schedule->play_date));
        $this->time_played = date('h:i A', strtotime($schedule->play_time));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.advert-played')->with([
            'slots'             => $this->slots,
            'total_played'      => $this->total_played,
            'name'              => $this->name,
            'date_played'       => $this->date_played,
            'time_played'       => $this->time_played
        ]);
    }
}
