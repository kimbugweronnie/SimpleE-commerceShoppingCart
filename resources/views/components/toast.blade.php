<div
    x-data="{ show: false, message: '' }"
    x-on:toast.window="
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 15000);
    "
    x-show="show"
    x-transition
    class="fixed top-5 right-5 z-50 bg-zinc-900 text-black px-4 py-3 rounded-lg shadow-lg"
>
    <span x-text="message"></span>
</div>
