function openContactExportPopup() {
    let html = `
        <div style="margin: auto">
            <div class="bx-crm-edit-content-block-element">
                <span class="bx-crm-edit-content-block-element-name">Choose export format:</span>
                <select id="export_format" class="bx-crm-edit-input">
                    <option value="csv">CSV</option>
                    <option value="xlsx">XLSX</option>
                </select>
            </div>
        </div>
    `;

    const popup = BX.UI.Dialogs.MessageBox.show({
        title: 'Export Contacts',
        message: html,
        buttons: BX.UI.Dialogs.MessageBoxButtons.OK_CANCEL,
        onOk: () => {
            const format = $('#export_format').find(":selected").val();
            downloadFile(`/local/templates/.default/components/bitrix/crm.contact.list/.default/ajax/export_contacts.php?format=${format}`);
            return true; // closes popup
        },
    });
}

// hack to seamlessly download file
function downloadFile(filePath) {
    var link = document.createElement('a');
    link.href = filePath;
    link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
    link.click();
}

BX.ready(function () {
    $('.ui-toolbar-right-buttons').prepend('<button class="ui-btn ui-btn-primary" onclick="openContactExportPopup()">Export Contacts</button>');
})