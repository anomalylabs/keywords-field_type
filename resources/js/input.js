(function () {

    let fields = Array.prototype.slice.call(
        document.querySelectorAll('input[data-provides="anomaly.field_type.tags"]')
    );

    fields.forEach(function (field) {
        if (!field.hasAttribute('readonly') && !field.hasAttribute('disabled')) {

            let config = {
                enforceWhitelist: (field.dataset.enforce_options == 'true'),
                dropdown: {
                    enabled: 0
                }
            };

            if (field.dataset.options != '[]') {
                config.whitelist = JSON.parse(field.dataset.options);
            }

            let tags = new Tagify(field, config);

            tags.DOM.input.addEventListener('paste', function (event) {

                event.preventDefault();

                document.execCommand('insertHTML', false, event.clipboardData.getData('text/plain'));
            });

        }
    });

});
