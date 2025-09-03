@push('styles')
<style>
    .ck-editor__editable {
        min-height: 250px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            try {
                // Inisialisasi CKEditor untuk semua field rich text
                var editorIds = ['about_product', 'advantages', 'ideal_for', 'system_requirements'];
                
                editorIds.forEach(function(id) {
                    var element = document.getElementById(id);
                    if (element) {
                        ClassicEditor
                            .create(element, {
                                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo'],
                                heading: {
                                    options: [
                                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                                    ]
                                }
                            })
                            .then(editor => {
                                console.log('CKEditor initialized for: ' + id);
                                
                                // Store editor reference for later use
                                window['editor_' + id] = editor;
                                
                                // Tambahkan event untuk memastikan data disimpan ke form sebelum submit
                                var form = element.closest('form');
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        // Prevent immediate submission
                                        e.preventDefault();
                                        
                                        // Update hidden textarea with CKEditor content
                                        try {
                                            // Create a hidden input to store CKEditor data
                                            var hiddenInput = document.createElement('input');
                                            hiddenInput.type = 'hidden';
                                            hiddenInput.name = id;
                                            hiddenInput.value = editor.getData();
                                            form.appendChild(hiddenInput);
                                            
                                            console.log('Saved data for: ' + id + ' = ' + hiddenInput.value);
                                            
                                            // Continue with form submission
                                            form.submit();
                                        } catch (err) {
                                            console.error('Error saving editor data', err);
                                            // Allow form to submit anyway
                                            form.submit();
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('CKEditor initialization error for ' + id + ':', error);
                            });
                    } else {
                        console.warn('Element not found: ' + id);
                    }
                });
                
                console.log('CKEditor initialization attempted');
            } catch (e) {
                console.error('CKEditor global error:', e);
            }
        }, 500);
    });
</script>
@endpush
