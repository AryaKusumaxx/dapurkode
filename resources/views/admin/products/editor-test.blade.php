@extends('layouts.admin.app')

@section('title', 'Coba Rich Text Editor')

@section('header', 'Test Rich Text Editor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">TinyMCE (Versi 5)</h2>
                
                <textarea id="tinymce-test" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <p>Ini adalah <strong>teks contoh</strong> untuk <em>TinyMCE</em>!</p>
                </textarea>
                
                <hr class="my-8">
                
                <h2 class="text-lg font-medium text-gray-900 mb-4">CKEditor 5</h2>
                
                <div id="ckeditor-test" class="mt-1 block w-full">
                    <p>Ini adalah <strong>teks contoh</strong> untuk <em>CKEditor</em>!</p>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" id="get-content" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tampilkan Konten
                    </button>
                </div>
                
                <div class="mt-6 p-4 border border-gray-300 rounded">
                    <h3 class="text-md font-medium text-gray-900 mb-2">TinyMCE Content:</h3>
                    <div id="tinymce-output" class="p-2 bg-gray-100 rounded"></div>
                    
                    <h3 class="text-md font-medium text-gray-900 mb-2 mt-4">CKEditor Content:</h3>
                    <div id="ckeditor-output" class="p-2 bg-gray-100 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 300px;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/3on5zoa6ldeoztscvrb25z0nzdeodt3itjyr25hmmb4ivn86/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi TinyMCE
        tinymce.init({
            selector: '#tinymce-test',
            height: 300,
            menubar: false,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | formatselect | bold italic | bullist numlist | link image | code',
            promotion: false,
            branding: false
        });
        
        // Inisialisasi CKEditor
        let ckeditorInstance;
        ClassicEditor
            .create(document.querySelector('#ckeditor-test'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo']
            })
            .then(editor => {
                ckeditorInstance = editor;
                console.log('CKEditor initialized successfully');
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
        
        // Button event handler
        document.getElementById('get-content').addEventListener('click', function() {
            // Get content from TinyMCE
            const tinymceContent = tinymce.get('tinymce-test').getContent();
            document.getElementById('tinymce-output').innerHTML = tinymceContent;
            
            // Get content from CKEditor
            if (ckeditorInstance) {
                const ckeditorContent = ckeditorInstance.getData();
                document.getElementById('ckeditor-output').innerHTML = ckeditorContent;
            }
        });
    });
</script>
@endpush
