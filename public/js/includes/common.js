var alertError = function(content, title = '') {
    swal.fire({
        "title": title,
        "html": content,
        "type": "error",
        "confirmButtonClass": "btn btn-secondary"
    });
};
var alertSuccess = function(content, title = "Great Job!", callback = null) {
    swal.fire(title, content, "success").then(function(result) {
        if (callback) {
            callback(result);
        }
    });
};

var alertInfo = function(content, title = "", callback = null) {
    swal.fire(title, content, "info").then(function(result) {
        if (callback) {
            callback(result);
        }
    });
};

var alertSuccess2 = function(content, title = "Great Job!", callback = null) {
    swal.fire({
        title: title,
        buttonsStyling: false,

        html: content,
        type: "success",

        confirmButtonText: "OK",
        confirmButtonClass: "btn btn-sm btn-bold btn-brand",

        showCancelButton: false,
        cancelButtonText: "No, cancel",
        cancelButtonClass: "btn btn-sm btn-bold btn-default"
    }).then(function(result) {
        if (callback) {
            callback(result);
        }
    });
};

var alertConfirm = function(content, confirmFunc) {
    swal.fire({
        buttonsStyling: false,

        text: content,
        type: "warning",

        confirmButtonText: "Yes, delete!",
        confirmButtonClass: "btn btn-sm btn-bold btn-danger",

        showCancelButton: true,
        cancelButtonText: "No, cancel",
        cancelButtonClass: "btn btn-sm btn-bold btn-brand"
    }).then(function(result) {
        if (result.value) {
            confirmFunc();
        } else if (result.dismiss === 'cancel') {}
    });
}

function setHeight(target, height) {
    target.css('max_height', height);
    target.css('height', height);
    target.css('overflow-y', 'auto');
}

function formatDateNumber(val) {
    if (val < 10) {
        return '0' + val;
    }

    return val;
}

function showWait(target) {
    KTApp.block(target, {
        type: 'loader',
        state: 'brand',
        message: 'Por favor, espere...',
        opacity: 0.2,
        size: 'lg'
    });
}

function closeWait(target) {
    KTApp.unblock(target);
}