toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 3000
};

//wrapModal

function toggleModal(modalId, show = true) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  
  if (show) {
    modal.classList.remove('hidden');
  } else {
    modal.classList.add('hidden');
  }
}

// Global event delegation for closing modals
document.addEventListener('click', function (e) {
  // Close button clicked
  if (e.target.closest('[data-close]')) {
    const modalId = e.target.closest('[data-close]').getAttribute('data-close');
    toggleModal(modalId, false);
  }

  // Click outside modal content (backdrop)
  if (e.target.classList.contains('wrapModal')) {
    //e.target.classList.add('hidden');
  }
});



// image fetch on server
$(function() {
  const modal = $('#imageModal');
  const gallery = $('#imageGallery');
  const fileInput = $('#imageInput');
  const preview = $('#selectedPreview');
  const previewImg = $('#previewImg');

  // Open popup
  $('#openUploader').click(function() {
    let fol = $(this).data('folder');
    modal.removeClass('hidden').addClass('flex');
    gallery.html('<p class="text-gray-500 col-span-full text-center">Loading images...</p>');
    $.getJSON(App.getSiteurl() + "admin/slider/getUploadedImages",{folder:fol}, 
    function(images) {
      if (images.length === 0) {
        gallery.html('<p class="text-gray-500 col-span-full text-center">No images found.</p>');
      } else {
        gallery.html('');
        images.forEach(url => {
          const imgEl = $(`<img src="${url}" class="border rounded cursor-pointer hover:opacity-80 transition" />`);
          imgEl.click(() => {
            $('#selected_image').val(url);
            previewImg.attr('src', url);
            preview.removeClass('hidden');
            modal.addClass('hidden');
          });
          gallery.append(imgEl);
        });
      }
    });
  });

  // Close modal
  $('#closeModal').click(() => modal.addClass('hidden'));

  // Add New → open file input
  $('#addNewImage').click(() => {
    fileInput.trigger('click');
  });

  // When file selected
  fileInput.change(function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        previewImg.attr('src', e.target.result);
        preview.removeClass('hidden');
        modal.addClass('hidden');
        $('#selected_image').val(''); // reset selected_image if uploading new
      };
      reader.readAsDataURL(file);
    }
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('bannerImage');
  const preview = document.getElementById('bannerPreview');
  const selectedImage = document.getElementById('selected_image');
  const openUploader = document.getElementById('openUploader');

  // Open file selector on button click
  openUploader.addEventListener('click', () => input.click());

  // When new image selected
  input.addEventListener('change', (event) => {
    const file = event.target.files[0];
    preview.innerHTML = ''; // Clear preview

    if (!file) {
      preview.innerHTML = '<span class="text-gray-400 text-sm">No image selected</span>';
      return;
    }

    if (!file.type.startsWith('image/')) {
      preview.innerHTML = '<span class="text-red-500 text-sm">Please upload a valid image file.</span>';
      input.value = '';
      return;
    }

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.className = 'w-full max-h-60 object-contain border rounded';
    preview.appendChild(img);

    // Clear old image value since a new one was selected
    selectedImage.value = '';
  });
});

//muti images
$(function() {
  const modal = $('#multiImageModal');
  const gallery = $('#multiImageGallery');
  const fileInput = $('#mediaImageInput');
  const preview = $('#selectedMultiPreview');
  let selectedImages = [];

  // Open popup
  $('#openultiUploader').click(function() {
    let folder = $(this).data('folder');
    modal.removeClass('hidden').addClass('flex');
    gallery.html('<p class="text-gray-500 col-span-full text-center">Loading images...</p>');

    $.getJSON(App.getSiteurl() + "admin/slider/getMultiUploadedImages", { folder: folder }, function(images) {
      if (!images || images.length === 0) {
        gallery.html('<p class="text-gray-500 col-span-full text-center">No images found.</p>');
      } else {
        gallery.html('');
        images.forEach(url => {
          // Check if already selected
          const isSelected = selectedImages.includes(url);
          const imgEl = $(`
            <div class="relative inline-block m-1 cursor-pointer rounded border-2 ${isSelected ? 'border-blue-500' : 'border-transparent'} hover:border-gray-300 transition">
              <img src="${url}" class="object-cover h-24 w-100 rounded w-full">
              <div class="absolute inset-0 ${isSelected ? 'bg-blue-500 bg-opacity-0.5' : ''} rounded"></div>
            </div>
          `);

          // Click → toggle select/unselect
          imgEl.click(function() {
            const index = selectedImages.indexOf(url);
            if (index === -1) {
              selectedImages.push(url);
            } else {
              selectedImages.splice(index, 1);
            }
            updatePreview();
            $(this).toggleClass('border-blue-500 border-transparent');
            $(this).find('div').toggleClass('bg-blue-500 bg-opacity-30');
          });

          gallery.append(imgEl);
        });
      }
    });
  });

  // Close modal
  $('#closeMultModal').click(() => modal.addClass('hidden'));

  // Add New → open file input
  $('#addNewImagefromPc').click(() => fileInput.trigger('click'));

  // When files selected (upload new)
  fileInput.change(function() {
    Array.from(this.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        selectedImages.push(e.target.result);
        updatePreview();
      };
      reader.readAsDataURL(file);
    });
    modal.addClass('hidden');
  });

  // Update preview section
  function updatePreview() {
    preview.html('');
    selectedImages.forEach((img, i) => {
      preview.append(`
        <div class="relative group inline-block m-1">
          <img src="${img}" class="w-100 h-24 object-cover border rounded">
          <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs hidden group-hover:block" data-index="${i}">✕</button>
        </div>
      `);
    });
    $('#selected_images').val(JSON.stringify(selectedImages));
  }

  // Remove image from preview
  preview.on('click', 'button', function() {
    const index = $(this).data('index');
    selectedImages.splice(index, 1);
    updatePreview();
  });
});




