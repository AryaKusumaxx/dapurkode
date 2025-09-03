@push('styles')
<style>
    /* Menyembunyikan peringatan TinyMCE secara paksa */
    .tox-notification--warning {
        display: none !important;
    }
    
    /* Fix untuk masalah kursor silang */
    .tox-tinymce {
        z-index: 0 !important;
    }
    
    .tinymce-editor {
        min-height: 200px;
    }
    
    /* Perbaikan untuk elemen yang tidak dapat diklik */
    .tox-editor-container {
        pointer-events: auto !important;
    }
    
    .tox-toolbar__group {
        pointer-events: auto !important;
    }
    
    .tox-tbtn {
        pointer-events: auto !important;
    }
    
    /* Pastikan tidak ada overlay yang menghalangi */
    .tox-tinymce-inline {
        z-index: 10000 !important;
    }
    
    /* Pastikan elemen dapat menerima klik */
    .tox .tox-toolbar, 
    .tox .tox-toolbar__group, 
    .tox .tox-tbtn,
    .tox .tox-menubar,
    .tox .tox-mbtn {
        pointer-events: auto !important;
        cursor: pointer !important;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/3on5zoa6ldeoztscvrb25z0nzdeodt3itjyr25hmmb4ivn86/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            try {
                // Hapus instans TinyMCE yang mungkin sudah ada
                tinymce.remove();
                
                // Inisialisasi TinyMCE
                tinymce.init({
                    selector: '.tinymce-editor',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat code',
                    menubar: false,
                    height: 350,
                    promotion: false,
                    branding: false,
                    content_css: false,
                    statusbar: true,
                    resize: true,
                    browser_spellcheck: true,
                    paste_data_images: true,
                    convert_urls: false,
                    entity_encoding: 'raw',
                    verify_html: false,
                    paste_preprocess: function(plugin, args) {
                        // Memastikan konten yang di-paste tidak kehilangan format
                    },
                    setup: function(editor) {
                        editor.on('init', function() {
                            // Hapus peringatan domain
                            var notifications = document.querySelectorAll('.tox-notification--warning');
                            notifications.forEach(function(notification) {
                                notification.style.display = 'none';
                            });
                            
                            // Fix untuk Z-index
                            var tinyElements = document.querySelectorAll('.tox-tinymce');
                            tinyElements.forEach(function(elem) {
                                elem.style.zIndex = "0";
                            });
                            
                            // Console log untuk debugging
                            console.log('TinyMCE initialized successfully');
                        });
                    }
                });
                
                // Debug info
                console.log('Editor count:', document.querySelectorAll('.tinymce-editor').length);
            } catch (e) {
                console.error('TinyMCE initialization error:', e);
            }
        }, 500); // Tambahkan delay untuk memastikan DOM sudah siap
    });
</script>
@endpush
