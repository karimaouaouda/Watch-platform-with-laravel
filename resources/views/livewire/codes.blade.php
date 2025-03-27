<div>
    <h1 class="mb-0.5 truncate leading-none font-semibold text-xl">Manage Films & Series</h1>

    <!-- div containing button to generate a token -->
    <div class="flex items-center gap-2 mt-10 justify-end px-10">
        <button
            wire:click="generateToken"
            class="flex items-center gap-1 px-2 py-1 text-sm font-semibold text-white bg-accent-content rounded-md"
        >
            
            <span>Generate Token</span>
        </button>
    </div>

    <!-- three tabs to filter table data each tab represent the status of codes (new / working / expired) -->
    <div class="flex items-center justify-center gap-2 mt-10">
        <button
            wire:click="setFilter('new')"
            class="flex items-center gap-1 px-2 py-1 text-sm font-semibold text-white bg-accent-content rounded-md"
        >
            <span>New</span>
            <span class="text-xs font-normal">{{ 10 }}</span>
        </button>

        <button
            wire:click="setFilter('working')"
            class="flex items-center gap-1 px-2 py-1 text-sm font-semibold text-white bg-accent-content rounded-md"
        >
            <span>Working</span>
            <span class="text-xs font-normal">{{ 10 }}</span>
        </button>

        <button
            wire:click="setFilter('expired')"
            class="flex items-center gap-1 px-2 py-1 text-sm font-semibold text-white bg-accent-content rounded-md"
        >
            <span>Expired</span>
            <span class="text-xs font-normal">{{ 10 }}</span>
        </button>
    </div>

    <!-- table to display codes data with header has search input and filter and bulk actions -->
    <div class="overflow-x-auto mt-10">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Code</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Expiration Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop through codes data and display each code in a row -->
                <tr>
                        <td class="px-4 py-2">afeafeafeafea</td>
                        <td class="px-4 py-2">working</td>
                        <td class="px-4 py-2">12/12/2025</td>
                        <td class="px-4 py-2">
                            <button
                                wire:click=""
                                class="px-2 py-1 text-sm font-semibold text-white bg-accent-content rounded-md"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
    
</div>
