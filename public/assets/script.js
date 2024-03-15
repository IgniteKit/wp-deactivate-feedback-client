// Copyright (C) 2024  Darko Gjorgjijoski. All Rights Reserved.
// Copyright (C) 2024  IDEOLOGIX MEDIA DOOEL. All Rights Reserved.
// Copyright (C) 2024  IgniteKit. All Rights Reserved.
// All Rights Reserved.
// This file is licensed under the GPLv2 License.
// License text available at https://opensource.org/licenses/gpl-2.0.php

/**
 * Global scripts
 */
document.querySelectorAll('.iwpdf-field > input[type=radio][name=deactivation_reason]').forEach(function (item) {
    item.addEventListener('click', function (e) {
        var parent = item.closest('.iwpdf-form-row');
        if (parent) {
            var form = item.closest('.iwpdf-form');
            form.querySelectorAll('.iwpdf-form-row').forEach(function (item2) {
                item2.classList.remove('iwpdf-form-row-current');
            })
            parent.classList.add('iwpdf-form-row-current');
        }
    });
});

var IgniteKitDeactivateFeedback = {};

/**
 * The deactivation handler
 * @param params {object}
 * @constructor
 */
IgniteKitDeactivateFeedback.FormHandler = function (params) {
    this.name = params['name'] ? params['name'] : '';
    this.slug = params['slug'] ? params['slug'] : '';
    this.prefix = params['prefix'] ? params['prefix'] : '';
    this.apiUrl = params['api_url'] ? params['api_url'] : '';
    this.start();
}

/**
 * Returns the deactivate plugin
 * @returns {*}
 */
IgniteKitDeactivateFeedback.FormHandler.prototype.getDeactivateButton = function () {
    return document.getElementById('deactivate-' + this.slug);
}

/**
 * Deactivate the plugin
 */
IgniteKitDeactivateFeedback.FormHandler.prototype.deactivatePlugin = function () {
    var Element = this.getDeactivateButton();
    if (!Element) {
        console.log('IgniteKit Deactivator: Plugin could not be found.');
        return;
    }
    window.location.href = Element.href;
}

/**
 * Bind events related to specific plugin
 */
IgniteKitDeactivateFeedback.FormHandler.prototype.start = function () {

    var self = this;
    if (self.name === '') {
        return;
    }

    /**
     * Trigger the deactivatem Modal.
     */
    var Element = self.getDeactivateButton();
    if (!Element) {
        console.log('IgniteKit Deactivator: Plugin could not be found.');
        return;
    }
    Element.addEventListener('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        MicroModal.show(self.prefix + 'deactivate_feedback')
    });

    /**
     * Handle direct deactivate.
     */
    var FormDeactivateButton = document.querySelector('#' + self.prefix + 'deactivate_feedback .iwpdf-deactivate');
    if (FormDeactivateButton) {
        FormDeactivateButton.addEventListener('click', function (e) {
            e.preventDefault();
            self.deactivatePlugin();
        })
    }

    /**
     * Handle form deactivate.
     */
    var FormDeactivate = document.getElementById(self.prefix + 'deactivate_feedback--form');
    FormDeactivate.addEventListener('submit', function (e) {
        e.preventDefault();
        var form = FormDeactivate.closest('form');
        if (form) {
            form.classList.add('iwpdf-form-loading')
        }
        var button = FormDeactivate.querySelector('.iwpdf-form-submit');
        if (button) {
            button.setAttribute('disabled', '');
        }
        var formData = new FormData(this);
        var httpReq = new XMLHttpRequest();
        httpReq.open('POST', FormDeactivate.action, true);
        httpReq.onreadystatechange = function () {
            if (httpReq.readyState === 4) {
                self.deactivatePlugin();
                setTimeout(function(){
                    if (form) {
                        form.classList.remove('iwpdf-form-loading');
                    }
                    if (button) {
                        button.removeAttribute('disabled');
                    }
                },2000);
            }
        };
        httpReq.send(formData);
    });

}