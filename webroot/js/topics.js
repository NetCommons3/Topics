$(document).ready(function() {
  $('input[name="data[TopicFrameSetting][unit_type]"]').click(function() {
    //   console.debug($('input[name="data[TopicFrameSetting][unit_type]"]:checked').val());
    //   console.debug($('input[name="data[TopicFrameSetting][unit_type]"]:eq(0)').prop('checked'));
    //   console.debug($('input[name="data[TopicFrameSetting][unit_type]"]:eq(1)').prop('checked'));
    // console.debug(typeof $('input[name="data[TopicFrameSetting][unit_type]"]:checked').val());
    if ($('input[name="data[TopicFrameSetting][unit_type]"]:checked').val() === '0') {
      $('input[name="data[TopicFrameSetting][unit_type]"]:eq(0)').prop('checked', true);
      $('#TopicFrameSettingDisplayDays').prop('disabled', false);
      $('#TopicFrameSettingDisplayNumber').prop('disabled', true);
    } else {
      $('input[name="data[TopicFrameSetting][unit_type]"]:eq(1)').prop('checked', true);
      $('#TopicFrameSettingDisplayDays').prop('disabled', true);
      $('#TopicFrameSettingDisplayNumber').prop('disabled', false);
    }
  });

  $('#TopicFrameSettingSelectRoom').click(function() {
      // console.debug($('#TopicFrameSettingSelectRoom').prop('checked'));
    //   console.debug($('input[name="data[TopicFrameSetting][select_room]"]:eq(0)').prop('checked'));
    //   console.debug($('input[name="data[TopicFrameSetting][select_room]"]:eq(1)').prop('checked'));
    // console.debug(typeof $('input[name="data[TopicFrameSetting][select_room]"]').val());
    // if ($('#TopicFrameSettingSelectRoom:checked').val() === '1') {
    if ($('#TopicFrameSettingSelectRoom').prop('checked')) {
    // console.debug(0);
      // $('input[name="data[TopicFrameSetting][select_room]"]:eq(0)').prop('checked', true);
      // $('#TopicFrameSettingSelectRoom').prop('checked', false);
      $('#TopicSelectedRoomRoomId').prop('disabled', false);
      $('#TopicFrameSettingShowMyRoom').prop('disabled', false);
    } else {
    // console.debug(1);
      // $('input[name="data[TopicFrameSetting][select_room]"]:eq(1)').prop('checked', true);
      // $('input[name="data[TopicFrameSetting][select_room]"]:eq(0)').prop('checked', false);
      $('#TopicSelectedRoomRoomId').prop('disabled', true);
      $('#TopicFrameSettingShowMyRoom').prop('disabled', true);
    }
  });
  $('#TopicSelectedRoomRoomId').prop('disabled', $('#TopicFrameSettingSelectRoom').prop('checked') === false);
  $('#TopicFrameSettingShowMyRoom').prop('disabled', $('#TopicFrameSettingSelectRoom').prop('checked') === false);
});