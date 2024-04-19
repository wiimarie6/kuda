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
})