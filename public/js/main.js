var page = {
    formValidation: function () {
        // remove all warnings and errors alert from the inputs
        page.resetInputAlerts();
        // validate date
        if(is.not.dateString(page.date.val())) {
            console.log('invalid date');
            page.date.parent('.form-group').addClass('has-error');
            return false;
        }

        // validate first clock in/out
        if( ! is.all.timeString(page.in1.val(), page.out1.val())) {
            console.log('arrival and departure #1 must be set');
            page.in1.parent('.form-group').addClass('has-error');
            page.out1.parent('.form-group').addClass('has-error');
            return false;
        }

        // validate second clock in/out (optional)
        if(( ! is.empty(page.in2.val()) && is.empty(page.out2.val()))
            || ( ! is.empty(page.out2.val()) && is.empty(page.in2.val()))
        ) {
            console.log('arrival #2 must have a departure');
            page.in2.parent('.form-group').addClass('has-warning');
            page.out2.parent('.form-group').addClass('has-warning');
            return false;
        }

        // validate third clock in/out (optional)
        if(( ! is.empty(page.in3.val()) && is.empty(page.out3.val()))
             || ( ! is.empty(page.out3.val()) && is.empty(page.in3.val()))
        ) {
            console.log('arrival #3 must have a departure');
            page.in3.parent('.form-group').addClass('has-warning');
            page.out3.parent('.form-group').addClass('has-warning');
            return false;
        }

        //Validate time
        if( ! is.all.timeString(page.in2.val(), page.out2.val())
            && ! is.all.empty(page.in2.val(), page.out2.val())
        ) {
            console.log('Invalid time in arrival or departure #2');
            page.in2.parent('.form-group').addClass('has-error');
            page.out2.parent('.form-group').addClass('has-error');
            return false;
        }

        if( ! is.all.timeString(page.in3.val(), page.out3.val())
            && ! is.all.empty(page.in3.val(), page.out3.val())
        ) {
            console.log('Invalid time in arrival or departure #3');
            page.in3.parent('.form-group').addClass('has-error');
            page.out3.parent('.form-group').addClass('has-error');
            return false;
        }

        return true;
    },
    // properties
    date: $('input[name="date"]'),
    in1: $('input[name="in1"]'),
    out1: $('input[name="out1"]'),
    in2: $('input[name="in2"]'),
    out2: $('input[name="out2"]'),
    in3: $('input[name="in3"]'),
    out3: $('input[name="out3"]'),
    timetable: $('#timetable'),
    registrationForm: $('form#workday-registration'),

    config: function () {
        // setup date regex for dd/mm/yyyy
        var dateRegex = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
        is.setRegexp(dateRegex, 'dateString');
        // setup date regex for dd/mm/yyyy
        var timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
        is.setRegexp(timeRegex, 'timeString');

        // focused input on start
        page.in1.focus();

        // current day as default value to date
        // TODO: change this method
        var today = new Date($.now());
        var date  = (today.getDate() < 10 ? '0' : '') + today.getDate();
        var month = (today.getMonth() < 10 ? '0' : '') + (today.getMonth()+1);

        page.date.val(
            date+'/'+month+'/'+today.getFullYear()
        );
    },

    init: function () {
        page.config();

        var timeOptions = {
            clearIfNotMatch: true,
            onComplete: function (time, event, currentField) {
                $(currentField).parent().parent()
                    .next()
                    .find('input').focus();
            },
        };

        //date
        page.date.datepicker();
        page.date.mask('00/00/0000');

        // times
        page.in1.mask('00:00', timeOptions);
        page.out1.mask('00:00', timeOptions);
        page.in2.mask('00:00', timeOptions);
        page.out2.mask('00:00', timeOptions);
        page.in3.mask('00:00', timeOptions);
        page.out3.mask('00:00', timeOptions);

        page.registrationForm.submit(function (event) {
            if( ! page.formValidation()) {
                event.preventDefault();
            }
        });

        // delete workday
        $('.delete-item').on({
            click: function () {
                if( ! confirm('Tem certeza que deseja deletar este registro?'))
                    return false;

                $.ajax({
                    method: 'delete',
                    url: $(this).attr('meta-route'),
                    success: function (data) {
                        $('tr[item-id="'+data.id+'"]').fadeOut();
                    }
                });
            }
        });
    },

    resetInputAlerts: function () {
        page.timetable.find('.form-group').removeClass('has-success');
        page.timetable.find('.form-group').removeClass('has-warning');
        page.timetable.find('.form-group').removeClass('has-error');
    }
};

$(document).ready(page.init());