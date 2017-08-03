var Util = {
    notifyFlash: function(title, text, type) {
        //var listType = ['success', 'info', 'warning', 'danger'];
        var $div = $('.flashmessages');
        //if ($.inArray(type, listType) == false) {
        //    type = 'info';
        //}
        var content = '<div class="alert alert-' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<strong>' + title + '</strong><p>' + text + '</p></div>';
        var currentContent = $div.html();
        var newContent = currentContent + content;
        if (currentContent.indexOf(title) >= 0) {
            newContent = currentContent;
        }
        $div.html(newContent);
        $div.fadeIn(1);
    }
};