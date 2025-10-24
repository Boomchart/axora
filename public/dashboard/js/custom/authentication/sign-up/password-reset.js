"use strict";
var KTSignupGeneral = (function () {
    var e,
        t,
        a,
        s,
        r = function () {
            return 100 === s.getScore();
        };
    return {
        init: function () {
            (e = document.querySelector("#kt_sign_up_form")),
                (t = document.querySelector("#kt_sign_up_submit")),
                (s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]'))),
                (a = FormValidation.formValidation(e, {
                    fields: {
                        email: { validators: { notEmpty: { message: "Email address is required" }, emailAddress: { message: "The value is not a valid email address" } } },
                        password: {
                            validators: {
                                notEmpty: { message: "The password is required" },
                                callback: {
                                    message: "Please enter valid password",
                                    callback: function (e) {
                                        if (e.value.length > 0) return r();
                                    },
                                },
                            },
                        },
                        "confirm-password": {
                            validators: {
                                notEmpty: { message: "The password confirmation is required" },
                                identical: {
                                    compare: function () {
                                        return e.querySelector('[name="password"]').value;
                                    },
                                    message: "The password and its confirm are not the same",
                                },
                            },
                        },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger({ event: { password: !1 } }), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),

                e.querySelector('input[name="password"]').addEventListener("input", function () {
                    this.value.length > 0 && a.updateFieldStatus("password", "NotValidated");
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSignupGeneral.init();
});
