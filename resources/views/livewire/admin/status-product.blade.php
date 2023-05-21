<div class="bg-white shadow-xl rounded-lg p-6 mb-4">
    <p class="text-2xl text-center font-semibold mb-2">Estado del producto</p>
    
    <div class="flex">

        <label class="mr-6" >
            <input wire:model.defer="status" type="radio" name="status" value="1" > Marcar como Borrador
        </label>
        <label class="mr-6" >
            <input wire:model.defer="status" type="radio" name="status" value="2" > Marcar como Publicado
        </label>
    </div>

    <div class="flex justify-end items-center">

        <x-jet-action-message class="mr-3" on="saved">¡Actualizado!</x-jet-action-message>
        <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="saved">Actualizar</x-jet-button>
    </div>
</div>
