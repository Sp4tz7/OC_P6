var Trick = function () {
    var initTrick = function (maxTricks, maxComments) {
        $('.delete_trick').on('click', function () {
            $('#deleteTrick').attr('data-id', $(this).data('id')).attr(
                'data-url',
                '/admin/trick/delete/' + $(this).data('id') + '/' + $(this).data('csrf_token') + '/');
        });

        $('#deleteTrick').on('click', function () {
            var id = '#trick-' + $(this).attr('data-id');
            $.ajax({
                method: "DELETE",
                url: $(this).attr('data-url'),
            })
                .done(function (response) {
                    if (response.success == 1) {
                        Command: toastr.success("The trick has been deleted", "SUCCESS");
                        $(id).slideUp();
                    } else {
                        Command: toastr.error("The was a problem while trying to delete your trick", "ERROR");
                    }
                    $('#snowtrickModal').modal('toggle');
                });
        });

        // Tricks pagination
        $(".trick-box").slice(0, maxTricks).show();
        $("#loadMoreTricks").on('click', function (e) {
            e.preventDefault();
            $(".trick-box:hidden").slice(0, maxTricks).slideDown();
            if ($(".trick-box:hidden").length == 0) {
               $("#loadMoreTricks").fadeOut('slow');
            }
        });

        // Comment pagination
        $(".comment-box").slice(0, maxComments).css('display', 'flex');
        $("#loadMoreComments").on('click', function (e) {
            e.preventDefault();
            $(".comment-box:hidden").slice(0, maxComments).slideDown().css('display', 'flex');
            if ($(".comment-box:hidden").length == 0) {
                $("#loadMoreComments").fadeOut('slow');
            }
        });

    }

    return {
        init: function (maxTricks, maxComments) {
            initTrick(maxTricks, maxComments);

        }

    };


}();

