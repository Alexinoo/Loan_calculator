/* Function For Displaying Alert  */
function openalert(message, vElementIDForFocus = '') {
  openalert_custom('Alert', message, 'Close', '', vElementIDForFocus);
}
function openalert_custom(title, msg, btn_text, callback, vElementIDForFocus) {
  $('#alert_message').html(msg);
  $('.alert_div').dialog({
    modal: true,
    dialogClass: 'vldtn_alert_msg_dlg',
    stack: true,
    buttons: [
      {
        text: btn_text,
        click: function () {
          $(this).dialog('close');
          if (vElementIDForFocus != '') {
            $('#' + vElementIDForFocus).focus();
          }
          if (callback) callback();
        },
      },
    ],
    title: title,
  });
}

/* Function For Validating date */

function isValidDate(checkdate) {
  var dateRegex =
    /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-./])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
  return dateRegex.test(checkdate);
}

setTimeout(function () {
  $('.msgouter').fadeOut('slow');
}, 2000);
