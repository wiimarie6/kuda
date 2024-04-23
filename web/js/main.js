$(()=>{
    $("#pjax-account").on("click", ".btn-delete", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("show");
        const href = $(this).attr("href");
    })
    $("#pjax-account").on("click", "delete-btn-cancel", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("hide");
    })

    $("#pjax-event").on("click", ".btn-delete-event", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("show");
        const href = $(this).attr("href");
        $("#delete-btn-confirm").attr("href", href);
    })
    $("#pjax-event").on("click", "delete-btn-cancel", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("hide");
    })

    $("#pjax-genre").on("click", ".btn-delete-genre", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("show");
        const href = $(this).attr("href");
        $("#delete-btn-confirm").attr("href", href);
    })
    $("#pjax-genre").on("click", "delete-btn-cancel", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("hide");
    })

    $("#pjax-genre").on("click", ".btn-update-genre", function(e) {
        e.preventDefault();
        $("#update-modal").modal("show");
        const href = $(this).attr("href");
        $("#form-upload").attr("action", href);
    })
    $("#pjax-genre").on("click", "update-btn-cancel", function(e) {
        e.preventDefault();
        $("#update-modal").modal("hide");
    })

    $("#pjax-genre").on("click", ".btn-create-genre", function(e) {
        e.preventDefault();
        $("#create-modal").modal("show");
        const href = $(this).attr("href");
        $("#form-create").attr("action", href);
    })
    $("#pjax-genre").on("click", "create-btn-cancel", function(e) {
        e.preventDefault();
        $("#create-modal").modal("hide");
    })
})