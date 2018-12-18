var loading = false;
var debug = true;

//NEW FANCY STUFF
var gui = {
    loading: false,
    showLoader: function(message) {
        gui.loading = true;
        document.getElementsByTagName('body')[0].innerHTML += '<div id="loading-overlay"><div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><br/><span class="loading-text">' + message + '</span></div>';
        window.onbeforeunload = function () {
            return true;
        };
    },
    hideLoader: function() {
        gui.loading = false;
        var element = document.getElementById('loading-overlay');
        element.parentNode.removeChild(element);
        window.onbeforeunload = function () { };
    }
}

//Initialization
document.addEventListener('DOMContentLoaded', function () {

    M.AutoInit();
    
    //Navbar
    var elems = document.getElementsByClassName('sidenav');
    for(var i = 0; i < elems.length; i++) {
        var instance = M.Sidenav.init(elems[i], { });
    }

    //Dropdowns
    var elems = document.getElementsByClassName('dropdown-trigger');
    for (var i = 0; i < elems.length; i++) {
        var instance = M.Dropdown.init(elems[i], { hover: false, coverTrigger: false });
    }

    //Collapsible
    var elems = document.getElementsByClassName('collapsible');
    for (var i = 0; i < elems.length; i++) {
        var instance = M.Collapsible.init(elems[i], { accordion: false });
        instance.open();
    }

    //Initialize selects
    var elems = document.getElementsByTagName('select');
    for (var i = 0; i < elems.length; i++) {
        var instances = M.FormSelect.init(elems[i], {});
    }
});

window.addEventListener('load', function() {
    //Action buttons
    var elems = document.getElementsByClassName('btn-action');
    for (var i = 0; i < elems.length; i++) {
        elems[i].addEventListener('click', function (event) {
            var target = event.currentTarget;
            var action = target.getAttribute('data-action');
            execute(target, action);
        }, true);
    }

    //Fill log blocks
    var elems = document.getElementsByClassName('log-block');
    for (var i = 0; i < elems.length; i++) { 
        loadLog(elems[i], elems[i].getAttribute('data-log'));
    }


}, false);

function loadLog(container, log) {
    var params = {
        'function': 'log_load',
        'log': log
    };
    request(params, function (response_json) {
        var response = JSON.parse(response_json);
        var preNode = document.createElement('pre');
        preNode.innerText = response['data'];
        container.appendChild(preNode);
        container.scrollTop = container.scrollHeight;
    });
}

function execute(clicked, action) {
    if (action == 'shutdown') {
        powerSystem('shutdown');
    }
    //Reboot
    if (action == 'reboot') {
        powerSystem('reboot');
    }
    //Update configuration
    if (action == 'config_update') {
        configUpdate(document.getElementById('dev_name').value, document.getElementById('dev_remote_url').value, document.getElementById('dev_id').value, document.getElementById('dev_key').value, document.getElementById('dev_admin_usr').value, document.getElementById('dev_password').value);
    }
    //Enable network interface
    if (action == 'interface_enable') {
        configInterface(clicked.getAttribute('data-interface'), 'enable');
    }
    //Disable network interface
    if (action == 'interface_disable') {
        configInterface(clicked.getAttribute('data-interface'), 'disable');
    }
    //--------------------[ APPLICATION ]--------------------
    //Run app
    if (action == 'app_run_normal') {
        M.toast({html: 'Running app...'});
        runApp(clicked.getAttribute('data-app-id'), 'normal');
    }
    //Run app as sudo
    if (action == 'app_run_sudo') {
        M.toast({html: 'Running app as root...'});
        runApp(clicked.getAttribute('data-app-id'), 'sudo');
    }
    //Remove app
    if (action == 'app_remove') {
        M.toast({html: 'Uninstalling app...'});
        removeApp(clicked.getAttribute('data-app-id'));
    }
    //Download app
    if (action == 'app_download') {
        M.toast({html: 'Downloading app...'});
        downloadApp(clicked.getAttribute('data-app-url'));
    }
    //Upload app
    if (action == 'app_upload') {
        if (document.getElementById('app-file-upload').files[0] != null) {
            M.toast({html: 'Uploading app...'});
            uploadApp();
        } else {
            M.toast({html: 'No file selected'});
        }
    }
    //--------------------[ MODULE ]--------------------
    //Download module
    if (action == 'module_download') {
        M.toast({html: 'Downloading module...'});
        downloadModule(clicked.getAttribute('data-module-url'));
    }
    //Upload module
    if (action == 'module_upload') {
        if (document.getElementById('module-file-upload')[0].files[0] != null) {
            M.toast({html: 'Installing module (can take a while)...'});
            uploadModule();
        } else {
            M.toast({html: 'No file selected'});
        }
    }
    //Remove module
    if (action == 'module_remove') {
        M.toast({html: 'Uninstalling module...'});
        removeModule(clicked.getAttribute('data-module-id'));
    }
}

function removeModule(module_id) {
    gui.showLoader('Removing module and packages installed...');
    var params = {
        'function': 'module_remove',
        'module_id': module_id
    };
    
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        gui.hideLoader();
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
        document.getElementById('module-' + module_id).remove();
    });
}

function powerSystem(action) {

    var params = {
        'function': 'power_system',
        'action': action
    };
    request(params, function (response_json) {
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
    });
}

function uploadModule() {
    gui.showLoader('Uploading and installing module... Please wait.');
    var form_data = new FormData();
    form_data.append('function', 'module_upload');
    form_data.append('module_file', document.getElementById('module-file-upload').files[0]);

    fetch('core/action.ajax.php', {
        method: 'POST',
        body: params
    }).then(function (response) {
        return response.text();
    }).then(function (response_json) {
        if (debug)
            console.log(response_json);
        var response = JSON.parse(response_json);
        M.toast({ html: response['message'] });
        location.reload();
    });
}

function downloadModule(module_url) {
    gui.showLoader('Downloading and installing module... Please wait.');
    var params = {
        'function': 'module_download',
        'module_url': module_url
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        gui.hideLoader();
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
        location.reload();
    });
}

function configUpdate(dev_name, dev_remote_url, dev_id, dev_key, dev_admin_usr, dev_password) {
    var params = {
        'function': 'config_update',
        'dev_name': dev_name,
        'dev_remote_url': dev_remote_url,
        'dev_id': dev_id,
        'dev_key': dev_key,
        'dev_admin_usr': dev_admin_usr,
        'dev_password': dev_password
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
    });
}

function uploadApp() {
    var params = new FormData();
    params.append('function', 'app_upload');
    params.append('app_file', document.getElementById('app-file-upload').files[0]);

    fetch('core/action.ajax.php', {
        method: 'POST',
        body: params
    }).then(function (response) {
        return response.text();
    }).then(function (response_json) {
        if (debug)
            console.log(response_json);
        var response = JSON.parse(response_json);
        M.toast({ html: response['message'] });
        location.reload();
    });
}

function downloadApp(app_url) {
    gui.showLoader('Downloading and installing module... Please wait until this message disappears.');
    var params = {
        'function': 'app_download',
        'app_url': app_url
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        gui.hideLoader();
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
        location.reload();
    });
}

function removeApp(app_id) {
    var params = {
        'function': 'app_remove',
        'app_id': app_id
    };
    
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
        location.reload();
    });
}

function runApp(app_id, app_run_mode) {
    loading = true;
    var params = {
        'function': 'app_run',
        'app_id': app_id,
        'app_args': document.getElementById('app_args').value,
        'app_run_mode': app_run_mode
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        loading = false;
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});

        var preNode = document.createElement('pre');
        preNode.innerText = response['data'];
        document.getElementsByClassName('app-output')[0].appendChild(preNode);
        container.scrollTop = container.scrollHeight;
    });
}

function connectWifi(interface_name, wifi_ssid, wifi_password) {
    gui.showLoader('Wifi connecting... Please wait.');
    var params = {
        'function': 'wifi_connect',
        'interface_name': interface_name,
        'wifi_ssid': wifi_ssid,
        'wifi_password': wifi_password
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        gui.hideLoader();
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
    });
}

function disconnectWifi(interface_name) {
    gui.showLoader('Wifi disconnecting... Please wait.');
    var params = {
        'function': 'wifi_disconnect',
        'interface_name': interface_name
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        gui.hideLoader();
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
    });
}

function configInterface(interface_name, interface_action) {
    M.toast({ html: 'Configuring interface ' + interface_name });
    var params = {
        'function': 'config_interface',
        'interface_name': interface_name,
        'interface_action': interface_action
    };
    request(params, function (response_json) {
        if (debug)
            console.log(response_json);
        var response = JSON.parse(response_json);
        M.toast({html: response['message']});
        var interface_panel = document.querySelectorAll('*[data-interface="' + interface_name + '"]')[0];
        if (interface_panel.classList.contains('red')) {
            interface_panel.innerHTML = '<i class=\"material-icons left\">wifi_tethering</i>enable';
            interface_panel.classList.remove('red');
            interface_panel.classList.add('green');
        } else {
            interface_panel.innerHTML = '<i class=\"material-icons left\">portable_wifi_off</i>disable';
            interface_panel.classList.remove('green');
            interface_panel.classList.add('red');
        }
    });
}

function request(params, callback) {
    if (callback === undefined)
        callback = function (output) { };

    fetch('core/action.ajax.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }).then(function (response) {
        return response.text();
    }).then(function (output) {
        callback(output);
    });
}