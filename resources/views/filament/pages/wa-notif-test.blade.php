<x-filament-panels::page>
   <b>Send Notification whatsapp test</b>
   <div>
    <form wire:submit="create">
        {{ $this->form }}
        
    </form>
    
    <br>
    

    <x-filament-actions::modals />
</div>

</x-filament-panels::page>
