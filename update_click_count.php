$('body').on('click', '.link-input', function() {
    var id = $(this).data('id');
    $.post('update_click_count.php', {id: id}, function(response) {
        // handle response
    });
});
