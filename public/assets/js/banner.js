
function openBannerModal(e = false) {
    toggleModal('bannerModal', true);
    let id = e;
    let webForm = $('#bannerForm');
    const modal = document.getElementById('bannerForm');
    $('#bannerModal').find('.head').text('Add New Banner')
    $('#edit_id').val('');
    modal.querySelector('#banner_title').value = '';
    modal.querySelector('#highlight').value = '';
    modal.querySelector('#description').value = '';
    modal.querySelector('#button_title').value = '';
    modal.querySelector('#url').value = '';
    $('#selectedPreview').addClass('hidden');
    modal.querySelector('#previewImg').src = '';
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    if (id) {

        fetch(App.getSiteurl() + 'admin/banner-edit/' + `${id}`)
            .then(res => res.json())
            .then(banner => {
                if (banner) {
                    $('#bannerModal').find('.head').text('Edit Banner');

                    modal.querySelector('#edit_id').value = `${id}`;
                    modal.querySelector('#banner_title').value = banner.title;

                    // 3. Set values in modal fields
                    modal.querySelector('#highlight').value = banner.highlight;
                    modal.querySelector('#description').value = banner.subtitle;
                    modal.querySelector('#button_title').value = banner.button_title;
                    modal.querySelector('#url').value = banner.url;
                    if (banner.image) {
                        $('#selectedPreview').removeClass('hidden');
                        modal.querySelector('#previewImg').src = banner.image
                            ? banner.image
                            : App.getSiteurl() + 'uploads/slider/default.jpg';
                    }

                }
            });
    } else {
        $('#selectedPreview').addClass('hidden');
        webForm[0].reset();
    }
}