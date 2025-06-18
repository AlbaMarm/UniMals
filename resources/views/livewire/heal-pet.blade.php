<div>
    <x-button wire:click="$set('openModal', true)">
        <i class="fa-solid fa-hospital mr-2"></i> Heal Pet
        <span class="text-xs font-bold text-green-200">[100%]</span>
    </x-button>

    <x-dialog-modal wire:model="openModal" class="z-70">
        <x-slot name="title">
            <span class="text-red-600 font-bold">Heal Pet</span>
        </x-slot>

        <x-slot name="content">
            <p>This will restore all states to <strong>100</strong>.</p>
            <p class="font-bold text-red-300 mt-2">Use only in extreme cases !!!</p>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <button wire:click="curar"
                    @disabled($hasHealed)
                    class=" inline-flex items-center px-4 py-2 text-white rounded transition
                      {{ $hasHealed
                          ? 'bg-gray-200 text-gray-500 cursor-not-allowed'
                          : 'bg-green-600 hover:bg-green-700'
                      }}">
                    <i class="fas fa-heart-pulse mr-2"></i> Accept
                </button>
                <button wire:click="cerrar"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-red-800 rounded hover:bg-gray-300">
                    <i class="fas fa-ban mr-2"></i> Cancel
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>