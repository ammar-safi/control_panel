<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;

class Settings extends Page
{
    // Livewire props
    public bool $confirmingGenerate = false;
    public bool $hasPublicKey = false;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';

    // mount lifecycle: set hasPublicKey
    public function mount(): void
    {
        $user = auth()->user();
        $this->hasPublicKey = ! empty($user->public_key);
    }

    public function openGenerateModal(): void
    {
        $this->confirmingGenerate = true;
    }

    public function performAction(): void
    {
        $this->confirmingGenerate = false; // close modal

        $user = auth()->user();

        // Prevent repeated generation
        if ($this->hasPublicKey || ! empty($user->public_key)) {
            Notification::make()
                ->warning()
                ->title('Key Exists')
                ->body('You already have a public key stored.')
                ->send();

            // ensure property synced
            $this->hasPublicKey = true;
            return;
        }

        if (! function_exists('openssl_pkey_new')) {
            Notification::make()
                ->danger()
                ->title('Server Error')
                ->body('OpenSSL is not available on the server.')
                ->send();
            return;
        }

        $config = [
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        $res = openssl_pkey_new($config);
        if (! $res) {
            Notification::make()
                ->danger()
                ->title('Generation Failed')
                ->body('Failed to generate keys.')
                ->send();
            return;
        }

        // get private PEM and public PEM
        openssl_pkey_export($res, $privateKeyPem);
        $details = openssl_pkey_get_details($res);
        $publicKeyPem = $details['key'] ?? null;

        if (! $publicKeyPem) {
            Notification::make()
                ->danger()
                ->title('Extraction Error')
                ->body('Failed to extract public key.')
                ->send();
            return;
        }

        // save public key only
        $user->public_key = $publicKeyPem;
        $user->save();

        // update flag so UI changes immediately
        $this->hasPublicKey = true;

        // dispatch private key to browser (base64)
        $this->dispatch('download-private-key', key: base64_encode($privateKeyPem), filename: 'private_key_user_' . $user->id . '.pem');

        Notification::make()
            ->success()
            ->title('Key Generated')
            ->body('Public key saved. Your private key will be downloaded now.')
            ->send();
    }
}
