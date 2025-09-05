<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleFormWebhookController extends Controller
{
    public function handleWebhook () {
        \Log::info("hi");
    }
}
