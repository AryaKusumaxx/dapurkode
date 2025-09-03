// Script untuk mengatasi masalah dengan TinyMCE
document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk membersihkan semua instance TinyMCE yang ada
    function cleanupTinyMCE() {
        if (typeof tinymce !== "undefined") {
            tinymce.remove();
        }
    }

    // Fungsi untuk menginisialisasi TinyMCE dengan konfigurasi bersih
    function initTinyMCE() {
        var editorIds = [
            "about_product",
            "advantages",
            "ideal_for",
            "system_requirements",
        ];

        editorIds.forEach(function (id) {
            var elem = document.getElementById(id);
            if (!elem) {
                console.warn("Element not found: " + id);
                return;
            }

            // Pastikan elemen memiliki ID yang benar dan dapat ditemukan
            console.log("Initializing editor for element: ", id, elem);

            tinymce.init({
                selector: "#" + id,
                height: 300,
                menubar: false,
                inline: false,
                plugins: "lists link image table code",
                toolbar:
                    "undo redo | formatselect | bold italic | bullist numlist | link image | code",
                promotion: false,
                branding: false,
                entity_encoding: "raw",
                convert_urls: false,
                relative_urls: false,
                remove_script_host: false,
                setup: function (editor) {
                    editor.on("init", function () {
                        console.log("Editor initialized: " + id);
                    });

                    // Menambahkan event handlers khusus untuk mengatasi masalah kursor
                    editor.on("mouseenter", function () {
                        var editorContainer = editor.getContainer();
                        editorContainer.style.pointerEvents = "auto";
                    });
                },
            });
        });
    }

    // Jalankan dengan delay untuk memastikan DOM sudah siap
    setTimeout(function () {
        cleanupTinyMCE();
        initTinyMCE();

        // Tambahkan handler untuk tombol reload jika diperlukan
        var reloadButton = document.getElementById("reload-tinymce");
        if (reloadButton) {
            reloadButton.addEventListener("click", function () {
                cleanupTinyMCE();
                initTinyMCE();
            });
        }
    }, 1000);
});
