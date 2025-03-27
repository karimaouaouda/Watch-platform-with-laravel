<div class="w-full mt-6">
    <div class="w-full h-96 bg-slate-300 flex justify-center items-center">
        <video class="w-full h-full" controls>
            <source src="{{ $film->generateSignedUrlForUser(auth()->id()) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="w-full mt-6">
        <h1 class="text-2xl font-semibold">{{ $film->title }}</h1>
        <p class="text-lg">{{ $film->description }}</p>
    </div>
    <div class="w-full mt-6">
        <h1 class="text-2xl font-semibold">Comments</h1>
        <div class="w-full mt-4">
            <form wire:submit.prevent="addComment">
                <div class="w-full flex">
                    <input type="text" wire:model="comment" class="w-full h-10 px-4 border border-slate-200 rounded-md" placeholder="Add a comment...">
                    <button type="submit" class="h-10 px-4 bg-slate-200 text-white font-semibold rounded-md ml-2">Add</button>
                </div>
            </form>
        </div>
        <div class="w-full mt-4">
            <div class="w-full mt-2">
                <p class="text-lg font-semibold">karim aouaouda</p>
                <p class="text-lg">hi there</p>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementsByTagName('video')[0].disablePictureInPicture = true;
</script>