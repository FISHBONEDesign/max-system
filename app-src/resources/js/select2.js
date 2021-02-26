let init_select2 = (event) => {
    $('select.select2').map((index, item) => {
        $(item).select2({
            // closeOnSelect: !item.hasAttribute('multiple'),
            tags: item.classList.contains('tags')
        });
    });
};

let interval, counter = 0, limit = 100;
interval = window.setInterval(function () {
    let styles = document.styleSheets;
    for (let index = 0; index < styles.length; index++) {
        let classes, result, list = ['rules', 'cssRules'];
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
        if (result) {
            window.clearInterval(interval);
            init_select2();
        }
    }
    counter++;
    if (counter >= limit) window.clearInterval(interval);
}, 1);
