<?php

namespace App\Mail;

use App\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogPosted extends Mailable
{
    use Queueable, SerializesModels;
    public $blog;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
      //receive param
      $this->blog = $blog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      //parameter from
      return $this->from('admin@gmail.com')->view('email');
    }
}
