jQuery(document).ready(function () {

    // Init
    if (typeof rkwEcosystemIntroOptions !== 'undefined') {

        var rkwEcosystemIntro = introJs();
        rkwEcosystemIntro.setOptions(rkwEcosystemIntroOptions);

        // set values of tooltip back to container-div
        rkwEcosystemIntro.onbeforechange(function (targetElement) {

            // targetElement.id is the element-id defined above
            if (jQuery(targetElement).attr('data-step').length) {

                var step = parseInt(jQuery(targetElement)
                                        .attr('data-step')) - 1;
                if (rkwEcosystemIntro._direction == 'backward') {
                    step = parseInt(jQuery(targetElement)
                                        .attr('data-step')) + 1;
                }

                var stepContainer = jQuery('#rkw-ecosystem-container-step' + step);
                var stepContainerForm = jQuery('#rkw-ecosystem-container-step' + step)
                    .parent('form');
                var tooltipContainer = jQuery('.introjs-tooltipReferenceLayer')
                    .find('.introjs-tooltiptext')
                    .first();

                if (
                    (stepContainer.length)
                    && (stepContainerForm.length)
                    && (tooltipContainer.length)
                ) {

                    // set dynamic values to original form
                    var fieldsTextarea = tooltipContainer.find('textarea')
                        .serializeArray();
                    jQuery.each(fieldsTextarea, function (i, field) {
                        stepContainer.find("textarea[name='" + field.name + "']")
                            .val(field.value);
                    });
                    var fieldsRadio = tooltipContainer.find('input:checked')
                        .serializeArray();
                    jQuery.each(fieldsRadio, function (i, field) {
                        stepContainer.find('input[name="' + field.name + '"][value="' + field.value + '"]')
                            .prop('checked', 'checked');
                    });

                    // submit
                    stepContainerForm.submit();
                }
            }
        });

        // copy content of relevant container-div into tool-tip.
        // we override everything else with this
        rkwEcosystemIntro.onafterchange(function (targetElement) {

            setTimeout(function () {

                // targetElement.id is the element-id defined above
                if (jQuery(targetElement)
                    .attr('data-step').length) {

                    var step = parseInt(jQuery(targetElement)
                                            .attr('data-step'));
                    var stepContainer = jQuery('#rkw-ecosystem-container-step' + step)
                        .first();
                    var stepContainerForm = jQuery('#rkw-ecosystem-container-step' + step)
                        .parent('form');
                    var stepContainerInnerOriginal = stepContainer.find('.rkw-ecosystem-container-inner')
                        .first();
                    var tooltipContainer = jQuery('.introjs-tooltipReferenceLayer')
                        .find('.introjs-tooltiptext')
                        .first();

                    if (
                        (stepContainer.length)
                        && (tooltipContainer.length)
                        && (stepContainerInnerOriginal.length)
                    ) {

                        // clone & copy dynamic values since these are not cloned
                        var innerContainerClone = stepContainerInnerOriginal.clone();
                        var fieldsTextarea = stepContainerInnerOriginal.find('textarea')
                            .serializeArray();
                        jQuery.each(fieldsTextarea, function (i, field) {
                            innerContainerClone.find("textarea[name='" + field.name + "']")
                                .val(field.value);
                        });
                        var fieldsRadio = stepContainerInnerOriginal.find('input:checked')
                            .serializeArray();
                        jQuery.each(fieldsRadio, function (i, field) {
                            innerContainerClone.find('input[name="' + field.name + '"][value="' + field.value + '"]')
                                .prop('checked', 'checked');
                        });

                        innerContainerClone.find('textarea, input')
                            .removeClass('no-jcf');
                        tooltipContainer.html('');
                        tooltipContainer.append(innerContainerClone);
                        jQuery(document)
                            .trigger('rkw-ajax-api-content-changed', tooltipContainer);

                        // realign the hints
                        rkwEcosystemIntro.refresh();

                    }

                    // Set function to skip button for submit of form before closing overlay
                    jQuery('.introjs-skipbutton').on('mousedown', function () {
                        if (
                            (stepContainer.length)
                            && (stepContainerForm.length)
                            && (tooltipContainer.length)
                        ) {

                            // set dynamic values to original form
                            var fieldsTextarea = tooltipContainer.find('textarea')
                                .serializeArray();
                            jQuery.each(fieldsTextarea, function (i, field) {
                                stepContainer.find("textarea[name='" + field.name + "']")
                                    .val(field.value);
                            });
                            var fieldsRadio = tooltipContainer.find('input:checked')
                                .serializeArray();
                            jQuery.each(fieldsRadio, function (i, field) {
                                stepContainer.find('input[name="' + field.name + '"][value="' + field.value + '"]')
                                    .prop('checked', 'checked');
                            });

                            // submit
                            stepContainerForm.submit();
                        }
                    });
                    jQuery('.introjs-skipbutton').on('touchstart', function () {
                        if (
                            (stepContainer.length)
                            && (stepContainerForm.length)
                            && (tooltipContainer.length)
                        ) {

                            // set dynamic values to original form
                            var fieldsTextarea = tooltipContainer.find('textarea')
                                .serializeArray();
                            jQuery.each(fieldsTextarea, function (i, field) {
                                stepContainer.find("textarea[name='" + field.name + "']")
                                    .val(field.value);
                            });
                            var fieldsRadio = tooltipContainer.find('input:checked')
                                .serializeArray();
                            jQuery.each(fieldsRadio, function (i, field) {
                                stepContainer.find('input[name="' + field.name + '"][value="' + field.value + '"]')
                                    .prop('checked', 'checked');
                            });

                            // submit
                            stepContainerForm.submit();
                        }
                    });
                }

            }, 500);

        });

        // start guided tour on click on start-button
        jQuery('.start').on('click', function (event) {
            event.preventDefault();
            rkwEcosystemIntro.start();

        });

        // start guided tour on click on elements
        jQuery('.guided').on('click', function (event) {
            event.preventDefault();
            rkwEcosystemIntro._currentStep = jQuery(this).attr('data-step') - 2;
            rkwEcosystemIntro.start();
        });
    }
});

