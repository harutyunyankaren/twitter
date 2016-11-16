<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Massege;
class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(Auth::check())
        {
            $countMessages = Massege::where('read', 0)->where('getter_id', Auth::user()->id)->get();
            $a = $countMessages->groupBy('room_id');
            $countUserMessage = $a->count();
        }else{
            $countUserMessage = 0;
        }

        $view->with('countMessages', $countUserMessage);
    }

}