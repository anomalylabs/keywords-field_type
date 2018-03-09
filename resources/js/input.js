(function (window, document) {

    let fields = Array.from(
        document.querySelectorAll('input[data-provides="anomaly.field_type.tags"]')
    );

    fields.forEach(function (field) {
        if (!field.hasAttribute('readonly') && !field.hasAttribute('disabled')) {
            new Choices(field, {
                removeItemButton: true,
                duplicateItems: false,
            });
        }
    });

})(window, document);
