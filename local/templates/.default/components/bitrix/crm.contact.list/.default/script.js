function openContactExportPopup() {
    alert('popup');
}

BX.ready(function () {


    $('.ui-toolbar-right-buttons').prepend('<button class="ui-btn ui-btn-primary" onclick="openContactExportPopup()">Export Contacts</button>');


})