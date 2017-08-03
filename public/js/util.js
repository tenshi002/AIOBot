var Util = {
    checkSession: function() {
        $.ajax({
            url: '/?module=Auth&action=check',
            type: 'GET',
            success: function (json) {
                if(json.session !== true) {
                    Util.redirect(json.url);
                }
            }
        });
    },
    saveConfig: function($url, $type, $data) {
        Util.checkSession();
        $.ajax({
            url: $url,
            type: $type,
            data: $data,
            success: function (json) {
                Util.notifyFlash(json.title, json.message, json.type);
            },
            error: function (json) {
                Util.notifyError(json.message);
            }
        });
    },
    redirect: function(url) {
        window.location.replace(url);
    },
    notifyError: function(message) {
        Util.notifyFlash('Une erreur est survenue !', message, 'danger');
    },
    notifyFlash: function(title, msg, type) {
        var $div = $('.flashmessages');
        var content = '<div class="alert alert-' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<strong>' + title + '</strong><p>' + msg + '</p></div>';
        var currentContent = $div.html();
        var newContent = currentContent + content;
        if (currentContent.indexOf(title) >= 0) {
            newContent = currentContent;
        }
        $div.html(newContent);
        $div.fadeIn(1);
    },
    showModal: function(title, html, saveButton) {
        var $title = $('.modal-title');
        var $content = $('.modal-body');
        var htmlSauvegarder = '';
        if(saveButton) {
            htmlSauvegarder = '<button type="button" class="btn btn-primary">Sauvegarder</button>';
        }
        $title.text(title);
        $content.html(hmtl);
        $('.modal').modal();
    }
};