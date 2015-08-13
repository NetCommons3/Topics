$(document).ready(function() {
  var unit = 'input[name="data[TopicFrameSetting][unit_type]"]';
  $(unit).click(function() {
    if ($(unit + ':checked').val() === '0') {
      $('input[name="data[TopicFrameSetting][unit_type]"]:eq(0)').prop(
          'checked', true
      );
      $('#TopicFrameSettingDisplayDays').prop('disabled', false);
      $('#TopicFrameSettingDisplayNumber').prop('disabled', true);
    } else {
      $('input[name="data[TopicFrameSetting][unit_type]"]:eq(1)').prop(
          'checked', true
      );
      $('#TopicFrameSettingDisplayDays').prop('disabled', true);
      $('#TopicFrameSettingDisplayNumber').prop('disabled', false);
    }
  });

  $('#TopicFrameSettingSelectRoom').click(function() {
    if ($('#TopicFrameSettingSelectRoom').prop('checked')) {
      $('#TopicSelectedRoomRoomId').prop('disabled', false);
      $('#TopicFrameSettingShowMyRoom').prop('disabled', false);
    } else {
      $('#TopicSelectedRoomRoomId').prop('disabled', true);
      $('#TopicFrameSettingShowMyRoom').prop('disabled', true);
    }
  });
  $('#TopicSelectedRoomRoomId').prop(
      'disabled',
      $('#TopicFrameSettingSelectRoom').prop('checked') === false
  );
  $('#TopicFrameSettingShowMyRoom').prop(
      'disabled',
      $('#TopicFrameSettingSelectRoom').prop('checked') === false
  );
});
