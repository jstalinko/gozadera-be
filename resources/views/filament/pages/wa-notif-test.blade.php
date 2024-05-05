<x-filament-panels::page>
   <b>Send Notification whatsapp test</b>
    <form method="POST" action="#">
        @csrf
        <input type="tel" name="number" placeholder="Title" class="w-full p-2 border border-blue-300 rounded-md mb-4 bg-transparent">
        <textarea name="message" placeholder="Message" class="w-full p-2 border border-blue-300 rounded-md mb-4 bg-transparent"></textarea>
        <button type="submit" class="bg-danger text-white px-4 py-2 rounded-md">Send</button>

    </form>

</x-filament-panels::page>
