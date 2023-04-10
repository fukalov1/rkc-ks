    function removePhoto (id) {
        console.log('remove photo', id);
        $.ajax({
            url: "/admin/remove_photo",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "Get",
            data: {id: id},
            success: function (data) {
                $('.photo'+id).remove();
            },
            error: function (data) {
                console.log('Фото не удалено.', id);
            },
            complete: function (data) {
            }
        });
    }


$(document).ready(function() {

    });
