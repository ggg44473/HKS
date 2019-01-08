$(".js-range-slider").ionRangeSlider();

var $krSlider = $('#keyresult_slider');    
var krSlider_instance = $krSlider.data("ionRangeSlider");

$('#keyresult_initaial').on('change',function(){
  var min = $(this).val();
  var max = $('#keyresult_target').val();
  var from = $('#keyresult_now').val();
  krSlider_instance.update({
    min: min,
    max: max,
    from: from,
  });
  $('#keyresult_now').val(from);
});

$('#keyresult_target').on('change', function(){
  var min = $('#keyresult_initaial').val();
  var max = $(this).val();
  var from = $('#keyresult_now').val();
  krSlider_instance.update({
    min: min,
    max: max,
    from: from,
  });
  $('#keyresult_now').val(from);
});

$('#keyresult_now').on('change', function(){
  var min = $('#keyresult_initaial').val();
  var max = $('#keyresult_target').val();
  var from = $(this).val();
  krSlider_instance.update({
    min: min,
    max: max,
    from: from,
  });
  $('#keyresult_now').val(from);
});

$krSlider.on("change", function () {
  var $inp = $(this);
  var from = $inp.prop("value");
  $('#keyresult_now').val(from);
});
