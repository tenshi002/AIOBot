$('body').on('click', '.saveModeration', function () {
    Util.saveConfig('/?module=Dashboard&action=saveModeration', 'POST', $(this).closest('form').serialize());
});

$('body').on('click', '.initBot', function() {
    Util.ajax('/index.php?module=Bot&action=InitSocket', 'GET', null, null);
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