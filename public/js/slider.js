$(".js-range-slider").ionRangeSlider();

$('.kr-init').on('change',function(){
  var min = $(this).val();
  var max = $(this).parents('.form-row').find('.kr-target').val();
  var from = $(this).parents('.form-row').find('.kr-now').val();
  $(this).parents('.form-row').find('.kr-slider').data("ionRangeSlider").update({
    min: min,
    max: max,
    from: from,
  });
});

$('.kr-target').on('change', function(){
  var min = $(this).parents('.form-row').find('.kr-init').val();
  var max = $(this).val();
  var from = $(this).parents('.form-row').find('.kr-now').val();
  $(this).parents('.form-row').find('.kr-slider').data("ionRangeSlider").update({
    min: min,
    max: max,
    from: from,
  });
});

$('.kr-now').on('change', function(){
  var min = $(this).parents('.form-row').find('.kr-init').val();
  var max = $(this).parents('.form-row').find('.kr-target').val();
  var from = $(this).val();
  $(this).parents('.form-row').find('.kr-slider').data("ionRangeSlider").update({
    min: min,
    max: max,
    from: from,
  });
});

$('.kr-slider').on("change", function () {
  var $inp = $(this);
  var from = $inp.prop("value");
  $(this).parents('.form-row').find('.kr-now').val(from);
});
