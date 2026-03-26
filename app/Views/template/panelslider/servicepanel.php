
<!-- Sliding panel -->
<div id="slidePanel" class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="text-lg font-semibold">Create <?= $labels['products'] ?? '' ?></h2>
        <button type="button" onclick="closePanel()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
    </div>

    <form id="blogForm" method="post" class="p-4 space-y-4" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="client_id" value="<?=$clientId;?>" />
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-primary-500 focus:border-primary-500" required>
            <div class="invalid-feedback" id="title_error"></div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <div class="relative ">
                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-image text-xl text-gray-400"></i></div>
                <input type="file" name="file"  id="file" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Choose Image">
               
                <div class="invalid-feedback" id="file_error"></div>
            </div>
        </div>

        <div class="flex justify-end space-x-2 pt-4 border-t">
            <button type="button" onclick="closePanel()" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Close</button>
            <button type="submit" id="saveBtn" class="!ml-2 px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save</button>
        </div>
    </form>
</div>