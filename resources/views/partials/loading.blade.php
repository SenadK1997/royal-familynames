<div class="loading fixed inset-0 flex items-center justify-center bg-white bg-opacity-90 z-50">
    <div class="animate-zoom-out">
        <img src="{{ asset('storage/images/loadingroyal.png')}}" alt="">
    </div>
</div>

<style>
    @keyframes zoom-out {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(5);
            opacity: 0;
        }
    }
    .animate-zoom-out {
        animation: zoom-out 1s forwards;
    }
</style>
