<?php

namespace App\Widgets;

use App\Models\Benefit;
use App\Models\Job;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Service;
use App\Models\User;
use App\Resources\Subscribe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class MessagesDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        if (!isAdmin()) {
            $count = Message::count();
        } else {
            $count = Message::count();
        }

        $string = trans('messages.Messages');
        $string2 = trans('messages.Messages');

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-group',
            'title' => "{$count} {$string}",
            'text' => trans('messages.You have') . " {$count} {$string2} " . trans('messages.In the database'),
            'button' => [
                'text' => trans('messages.Show All') . $string2,
                'link' => route('voyager.messages.index'),
            ],
            'image' => asset('widgets/back.png'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        $data = Message::first();
        return Auth::user()->can('browse', $data);
    }
}
