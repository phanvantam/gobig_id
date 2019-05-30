<?php

namespace App\Http\Controllers;

use App\Helpers\FacebookMessages;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // protected $script;

    // public function __construct(
    //     ScriptRepositoryInterface $script
    // ) {
    //     $this->script = $script;
    // }

    public function index()
    {
        $a = new FacebookMessages();
        $a->sendMessage(66);
        return 'Hello !';
    }
    //
}
