$('body').on('click', '.saveModeration', function () {
    var $this = this;
    var $form = $($this).closest('form');
    $.ajax({
        url: '/?module=Dashboard&action=saveModeration',
        type: 'POST',
        data: $form.serialize(),
        success: function (json) {
            Util.notifyFlash(json.title, json.message, json.type);
        },
        error: function (json) {
            Util.notifyFlash(json.title, json.message, json.type);
        }
    });
});