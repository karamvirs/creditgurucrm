tinymce.init({selector: 'textarea',entity_encoding : 'raw'});
$(function () {
    var tags = [];
    tags.clients = '{{first_name}}, {{last_name}}, {{report}}, {{quoted_amount}}, {{paid_amount}}, {{balance_amount}},{{attachment}}';
    tags.leads = '{{first_name}}, {{last_name}}, {{report}}, {{quoted_amount}}, {{paid_amount}}, {{balance_amount}},{{attachment}}';
    tags.payment = '{{first_name}}, {{last_name}}, {{report}}, {{quoted_amount}}, {{paid_amount}}, {{balance_amount}} ,{{paid}}, {{link}}';
    $('#module_c').change(function () {
        $('#tags_span').remove();
        sel = $(this).val();
        if (sel != 0) {
            $('#Default_CET_CustomEmailTemplates_Subpanel').append("<tr id='tags_span' ><td></td><td>" + tags[sel] + "</td></tr>");
        }
    });

    if ($('#module_c').val() != 0) {
        $('#tags_span').remove();
        $('#Default_CET_CustomEmailTemplates_Subpanel').append("<tr id='tags_span' ><td></td><td>" + tags[$('#module_c').val()] + "</td></tr>");
    }



})