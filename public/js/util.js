var Util = {
    checkSession: function () {
        $.ajax({
            url: '/?module=Auth&action=check',
            type: 'GET',
            success: function (json) {
                if (json.session !== true) {
                    Util.redirect(json.url);
                }
            }
        });
    },
    checkSessionFlashMessage: function () {
        $.ajax({
            url: '/?module=Request&action=checkSessionFlashMessage',
            type: 'GET',
            success: function (json) {
                if (json.flashMessage !== false) {
                    Util.displayFlashMessage(json.title, json.message, json.type);
                }
            }
        });
    },
    saveConfig: function ($url, $type, $data) {
        Util.checkSession();
        $.ajax({
            url: $url,
            type: $type,
            data: $data,
            success: function (json) {
                Util.notifySuccess(json.title, json.message);
            },
            error: function (json) {
                Util.notifyError(json.title, json.message);
            }
        });
    },
    redirect: function (url) {
        window.location.replace(url);
    },
    notifySuccess: function (title, msg) {
        Util.displayFlashMessage(title, msg, 'success');
    },
    notifyInfo: function (title, msg) {
        Util.displayFlashMessage(title, msg, 'info');
    },
    notifyWarning: function (title, msg) {
        Util.displayFlashMessage(title, msg, 'warning');
    },
    notifyError: function (title, msg) {
        Util.displayFlashMessage(title, msg, 'danger');
    },
    displayFlashMessage: function (title, message, type) {
        var $content = '';
        var $div = $('.flashmessages');
        $.ajax({
            url: '/?module=Request&action=getFlashMessageHTML',
            type: 'POST',
            data: {title: title, message: message, type: type},
            success: function (response) {
                //console.log('response : ' + response);
                $content = response;
            },
            complete: function () {
                $div.html($content);
                $div.fadeIn(100);
            }
        });
    },
    displayModal: function (title, content) {
        var $title = $('.modal-title');
        var $content = $('.modal-body');
        $title.text(title);
        $content.html(content);
        $('.modal').modal();
    },
    ajax: function (url, method, data, loaderDiv) {
        Util.waiting(loaderDiv);
        var $result = '';
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function (response) {
                $result = response;
            },
            error: function (json) {
                Util.notifyError(json.title, json.message);
            },
            complete: function (response) {
                return $result;
            }
        })
    },
    waiting: function (element) {
    },
    waitingStop: function (element) {
    }
};

var Twitch = {
    getViewerListJSON: function () {
        return Util.ajax('/?module=Request&action=getJSONViewerList', 'GET');
    },
    getViewerListHTML: function() {
        return Util.ajax('/?module=Request&action=getHTMLViewerList', 'GET')
    }
};


Util.checkSessionFlashMessage();