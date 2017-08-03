$('body').on('click', '.saveModeration', function () {
    Util.saveConfig('/?module=Dashboard&action=saveModeration', 'POST', $(this).closest('form').serialize());
});