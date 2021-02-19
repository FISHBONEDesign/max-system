$(document).on('change', 'input.custom-file-input', function (event) {
    let fullname = this.value,
        rule = /^.*[\\\/]([^\\\/]*)$/,
        filename = fullname ? fullname.match(rule)[1] : 'Choose file';
    $(`label.custom-file-label[for="${this.id}"]`).html(filename);
});
