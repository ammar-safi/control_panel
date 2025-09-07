<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\BlockchainService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddToBlockchain
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $userId;
    public string $url;
    protected $blockchain;
    public function __construct(int $userId , string $url)
    {
        $this->userId = $userId;
        $this->url = env('APP_URL') . "/storage" . $url;
        $this->blockchain = new BlockchainService;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        $params = [];
        $url = "" ;
        $this->blockchain->postCall($url, $params);

        // مؤقت: سجل للـ debug
        \Log::info("NotifyStatusChanged job running for user {$this->userId} -> {$this->url}");

        // ضع هنا منطق الاتصال بالبلوك تشين، التأكيد والتعامل مع الأخطاء والـ retries
    }
}
