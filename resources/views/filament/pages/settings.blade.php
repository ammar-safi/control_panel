<x-filament::page>
    <x-filament::card>
        <div class="p-6" dir="ltr">
            <h2 class="text-xl font-bold mb-4">Generate Private Key</h2>

            <p class="mb-4">
                You can generate the key only once. The server will store the public key only.
                The private key will be downloaded to your browser — keep it safe and do not share it.
            </p>

            {{-- =========================
                 Option A: HIDE button if key exists
                 Uncomment this block to use "hide" behavior
                 ========================= --}}
            {{--
            @unless ($hasPublicKey)
                <button
                    wire:click="openGenerateModal"
                    type="button"
                    class="filament-button inline-flex items-center gap-2 px-4 py-2 rounded-lg"
                >
                    Generate Key
                </button>
            @endunless
            --}}

            {{-- =========================
                 Option B: DISABLE button and show small message
                 This is active by default.
                 ========================= --}}
            <div class="flex items-center gap-4">
                <button @if ($hasPublicKey) disabled aria-disabled="true" @endif
                    wire:click="openGenerateModal" wire:loading.attr="disabled" wire:target="performAction" type="button"
                    style="padding: 7px 0.75rem" style="padding: 7px 0.75rem"
                    @if(!$hasPublicKey) 
                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 text-white border-transparent focus:ring-white"
                    @endif
                    @if ($hasPublicKey)
                     class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-gray-400 hover:bg-gray-500 focus:bg-gray-600 text-white border-transparent focus:ring-white"
                    opacity-50 cursor-not-allowed @endif">
                    <!-- spinner while performing -->
                    <svg wire:loading wire:target="performAction" class="animate-spin h-5 w-5 -ml-1 mr-2"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <span wire:loading.remove wire:target="performAction">Generate Key</span>
                    <span wire:loading wire:target="performAction">Generating...</span>
                </button>

                {{-- small text indicating key already exists --}}
                @if ($hasPublicKey)
                    <span class="text-sm text-gray-600">A key has already been generated for your account.</span>
                @endif
            </div>
        </div>
    </x-filament::card>

    {{-- Confirmation modal (Alpine + Livewire entangle) --}}
    <div x-data="{ open: @entangle('confirmingGenerate') }" x-cloak>
        <template x-if="open">
            <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" aria-modal="true" role="dialog">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

                <div
                    class="relative w-full max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold">Confirm Key Generation</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Generating a new key will store the public key on the server and download the private key to
                            your browser.
                            You will not be able to retrieve the private key later. Do you want to continue?
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button @click="open = false" type="button"
                                class="inline-flex items-center px-4 py-2 rounded-lg border">
                                Cancel
                            </button>

                            <button wire:click="performAction" wire:loading.attr="disabled" wire:target="performAction"
                                type="button"
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-primary-600 text-white">
                                <svg wire:loading wire:target="performAction" class="animate-spin h-5 w-5 -ml-1 mr-2"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>

                                <span wire:loading.remove wire:target="performAction">Confirm and Generate</span>
                                <span wire:loading wire:target="performAction">Generating...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Livewire v3 download listener --}}
    @script
        <script>
            $wire.on('download-private-key', (event) => {
                try {
                    const payload = event.detail ?? event;
                    const keyBase64 = payload.key || payload.detail?.key;
                    const filename = payload.filename || payload.detail?.filename || 'private_key.pem';

                    if (!keyBase64) {
                        alert('Private key missing from response.');
                        return;
                    }

                    const raw = atob(keyBase64);
                    const arr = new Uint8Array(raw.length);
                    for (let i = 0; i < raw.length; i++) arr[i] = raw.charCodeAt(i);

                    const blob = new Blob([arr], {
                        type: 'application/x-pem-file'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    URL.revokeObjectURL(url);
                } catch (err) {
                    console.error('Error downloading private key:', err);
                    alert('Failed to download private key.');
                }
            });
        </script>
    @endscript
</x-filament::page>
