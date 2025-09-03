// File untuk menghandle rich text editor
document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk menginisialisasi CKEditor
    function initCKEditor() {
        // Array dari ID elemen yang akan diubah menjadi CKEditor
        const editorIDs = [
            "about_product",
            "advantages",
            "ideal_for",
            "system_requirements",
        ];
        const editorInstances = {};

        // Loop melalui setiap ID dan inisialisasi CKEditor
        editorIDs.forEach(function (id) {
            const element = document.getElementById(id);
            if (!element) {
                console.warn(`Element with id ${id} not found.`);
                return;
            }

            // Buat hidden input untuk menyimpan data CKEditor
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = id;
            hiddenInput.id = `${id}_hidden`;
            hiddenInput.value = element.value || "";
            element.parentNode.appendChild(hiddenInput);

            // Inisialisasi CKEditor
            ClassicEditor.create(element, {
                toolbar: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "link",
                    "bulletedList",
                    "numberedList",
                    "|",
                    "insertTable",
                    "|",
                    "undo",
                    "redo",
                ],
                heading: {
                    options: [
                        {
                            model: "paragraph",
                            title: "Paragraph",
                            class: "ck-heading_paragraph",
                        },
                        {
                            model: "heading2",
                            view: "h2",
                            title: "Heading 2",
                            class: "ck-heading_heading2",
                        },
                        {
                            model: "heading3",
                            view: "h3",
                            title: "Heading 3",
                            class: "ck-heading_heading3",
                        },
                        {
                            model: "heading4",
                            view: "h4",
                            title: "Heading 4",
                            class: "ck-heading_heading4",
                        },
                    ],
                },
            })
                .then((editor) => {
                    console.log(`CKEditor initialized for ${id}`);
                    editorInstances[id] = editor;

                    // Update hidden input saat konten berubah
                    editor.model.document.on("change:data", () => {
                        const data = editor.getData();
                        document.getElementById(`${id}_hidden`).value = data;
                        console.log(
                            `Updated ${id}_hidden with: ${data.substring(
                                0,
                                30
                            )}...`
                        );
                    });
                })
                .catch((error) => {
                    console.error(
                        `Error initializing CKEditor for ${id}:`,
                        error
                    );
                });
        });

        // Tambahkan handler untuk form submission
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener("submit", function (e) {
                // Update semua hidden input dengan data terbaru dari CKEditor
                Object.keys(editorInstances).forEach((id) => {
                    const data = editorInstances[id].getData();
                    document.getElementById(`${id}_hidden`).value = data;
                    console.log(`Form submit: Updated ${id}_hidden with data.`);
                });
            });
        }
    }

    // Periksa apakah CKEditor telah dimuat
    if (typeof ClassicEditor !== "undefined") {
        initCKEditor();
    } else {
        // Muat CKEditor jika belum dimuat
        const script = document.createElement("script");
        script.src =
            "https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js";
        script.onload = initCKEditor;
        document.head.appendChild(script);
    }
});
