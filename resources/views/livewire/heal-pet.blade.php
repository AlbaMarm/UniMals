<div>
    <x-button wire:click="$set('openModal', true)">
        <i class="fa-solid fa-hospital mr-2"></i> Curar Mascota
    </x-button>

    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            <span class="text-red-600 font-bold">Curar a la mascota</span>
        </x-slot>

        <x-slot name="content">
            <p>Esto restaurará todos los estados a <strong>100</strong>.</p>
            <p class="font-bold text-red-300 mt-2">¡¡¡ Usar solo en caso extremo !!!</p>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <button wire:click="curar"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <i class="fas fa-heart-pulse mr-2"></i> Aceptar
                </button>
                <button wire:click="cerrar"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-red-800 rounded hover:bg-gray-300">
                    <i class="fas fa-ban mr-2"></i> Cancelar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
