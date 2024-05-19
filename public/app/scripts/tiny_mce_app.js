tinymce.init({
    selector: '.field-tiny-editor textarea',
    menubar: '',
    plugins: 'anchor autolink code fullscreen charmap preview codesample image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'code fullscreen | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | checklist numlist bullist indent outdent',
    images_upload_url: '/upload-files',
    relative_urls: false,
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
});