<!-- Popup Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-9999">
  <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-3xl relative">
    <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-black text-2xl">&times;</button>
    <h3 class="text-xl font-bold mb-4">Select Existing Image</h3>
    <div id="imageGallery" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4 mb-4">
      <p class="text-gray-500 col-span-full text-center">Loading images...</p>
    </div>
    <div class="text-center mt-4">
      <button id="addNewImage" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Add New Image</button>
    </div>
  </div>
</div>

<!-- close image gallery -->