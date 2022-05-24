let init_select2 = (event) => {
    $('select.select2').map((index, item) => {
        $(item).select2({
            // closeOnSelect: !item.hasAttribute('multiple'),
            tags: item.classList.contains('tags')
        });
    });
};

// for turbolink
$(document).on('turbolinks:load', init_select2);

let interval, counter = 0, limit = 10000;
interval = window.setInterval(function () {
    let styles = document.styleSheets, result;
    for (let index = 0; index < styles.length; index++) {
        let classes, list = ['rules', 'cssRules'];
        list.map((item) => {
            try {
                classes = styles[index][item];
            } catch (e) {
                return;
            }
            for (let index2 = 0; index2 < classes.length; index2++) {
                if (classes[index2].selectorText === '.form-control') result = classes[index2];
                else continue;
            }
        });
    }
    counter++;
    if (result || (counter >= limit)) {
        window.clearInterval(interval);
        init_select2();
    }
}, 1);
