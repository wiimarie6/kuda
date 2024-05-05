$(()=>{




    const url = location.pathname;
    $(".btn-panel-link[href='"+url+"'").addClass('current');
    $(".btn-panel-link[href='"+url+"'").addClass('current');
    $("#pjax-account").on("click", ".btn-delete", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("show");
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
    $("#pjax-event").on("click", "#delete-btn-cancel", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("hide");
    })

    $("#main").on("click", ".btn-delete-genre", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("show");
        const href = $(this).attr("href");
        $("#delete-btn-confirm").attr("href", href);
    })
    $("#main").on("click", "#delete-btn-cancel", function(e) {
        e.preventDefault();
        $("#delete-modal").modal("hide");
    })

    $("#main").on("click", ".btn-change-role", function(e) {
        e.preventDefault();
        $("#change-modal").modal("show");
        const link = $(this).attr("href");
        $("#change-form").attr("action", link);
    })
    $("#main").on("click", "#change-btn-cancel", function(e) {
        e.preventDefault();
        $("#change-modal").modal("hide");
    })

    $("#main").on("click", ".btn-update-genre", function(e) {
        e.preventDefault();
        $("#update-modal").modal("show");
        const href = $(this).attr("href");
        $("#form-upload").attr("action", href);
    })
    $("#main").on("click", "#update-btn-cancel", function(e) {
        e.preventDefault();
        $("#update-modal").modal("hide");
    })

    $("#main").on("click", "#btn-create-genre", function(e) {
        e.preventDefault();
        $("#create-modal").modal("show");
        const href = $(this).attr("href");
        $("#form-create").attr("action", href);
    })
    $("#main").on("click", "#create-btn-cancel", function(e) {
        e.preventDefault();
        $("#create-modal").modal("hide");
    })



    $('#genreuser-selectedgenres .genre-checkbox').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('genre-checked')
        $(this).find('input').attr('checked', !$(this).find('input').is(':checked'))
    });

    $('#genre-select-all').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();
        $('#genreuser-selectedgenres .genre-checkbox').each(function(){
            $(this).removeClass('genre-checked')
            $(this).addClass('genre-checked')
             $(this).find('input').attr("checked", true);
        })
    })
})