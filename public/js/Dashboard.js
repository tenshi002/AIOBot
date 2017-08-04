$('body').on('click', '.saveModeration', function () {
    Util.saveConfig('/?module=Dashboard&action=saveModeration', 'POST', $(this).closest('form').serialize());
});
var DashBoard = {
    refreshViewerList: function () {
        $.ajax({
            url: '/?module=Request&action=getHTMLViewerList',
            type: 'GET',
            success: function (html) {
                $('.viewer-list').html(html);
            },
            error: function (html) {
            }
        });
    }
};
setInterval(DashBoard.refreshViewerList(), 5000/*300000*/);