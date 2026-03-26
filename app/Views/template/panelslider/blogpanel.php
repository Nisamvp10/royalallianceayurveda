
<!-- Sliding panel -->
<div id="slidePanel" class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="text-lg font-semibold">Create <?= $labels['menu'] ?? '' ?></h2>
        <button type="button" onclick="closePanel()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
    </div>

    <form id="blogForm" method="post" class="p-4 space-y-4">
        <div>
            <input type="hidden" name="client_id" value="<?=$clientId;?>" />
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" id="blogTitle" name="blogTitle" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-primary-500 focus:border-primary-500" required>
            <div class="invalid-feedback" id="blogTitle_error"></div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="blogdescription" id="blogdescription" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-primary-500 focus:border-primary-500" required></textarea>
            <div class="invalid-feedback" id="blogdescription_error"></div>
        </div>

        <div class="flex justify-end space-x-2 pt-4 border-t">
            <button type="button" onclick="closePanel()" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Close</button>
            <button type="submit" id="saveBtn" class="!ml-2 px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save</button>
        </div>
    </form>
</div>