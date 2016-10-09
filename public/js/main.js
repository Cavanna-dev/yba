var lastId = 0;
var mesTimer = setInterval(getMessages, 2000);
var conTimer = setInterval(getConnected, 2000);

$(function () {
    scrollToBottom();
    $("#chat").submit(function () {
        showLoader("#contentMessages .msg");

        var message = $("#message").val();
        $.post("/home/addMessage", {message: message}, function (data) {
            if (data === 0) {
                alert('Vous devez entrer un message.');
            } else {
                $("#contentMessages").append(data.content);
                $("#message").val('');
                lastId = data.lastId;
            }
            scrollToBottom();
            hideLoader();
        }, "json");

        return false;
    });
});

function getMessages() {
    $.post("/home/getLastMessages", {lastId: lastId}, function (data) {
        if (data !== 0) {
            $("#contentMessages").append(data.content);

            scrollToBottom();
            lastId = data.lastId;
        }
    }, "json");
}

function getConnected() {
    $.post("/home/getLastConnectedUsers", {}, function (data) {
        if (data !== 0) {
            $("#connected").empty().append(data);
        }
    }, "json");
    return false;
}

function showLoader(div) {
    $(div).last().append('<div class="loader"></div>');
    ;
}
function hideLoader() {
    $(".loader").fadeOut(500, function () {
        $(".loader").remove();
    });
}
function scrollToBottom() {
    var wtf = $('#contentMessages');
    var height = wtf[0].scrollHeight;
    wtf.scrollTop(height);
}