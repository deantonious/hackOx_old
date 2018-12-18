var api = {
    module_id: document.getElementsByName('module_id')[0].content,

    request: function (action, parameters, callback) {
        var params = {
            "function": "module_request",
            "module_id": api.module_id,
            "action": action,
            "parameters": parameters
        };
        request(params, callback);
    }
}

var mui = {
    registerEvent: function (element_selector, event, fn) {
        var elements = document.querySelectorAll(element_selector);
        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener(event, fn);
        }
    },
    setOuput: function (response_json) {
        var response = JSON.parse(response_json);
        M.toast({ html: response["message"] });

        if (response['data'] != '' && response['data'] != undefined) {
            document.getElementsByClassName("module-output")[0].innerHTML = '<pre>' + response['data'] + '</pre>';
        } else {
            document.getElementsByClassName("module-output")[0].innerHTML = '<pre>' + response['message'] + '</pre>';
        }
    },
    showLoader: function (message) {
        gui.showLoader(message);
    },
    hideLoader: function () {
        gui.hideLoader();
    }
}