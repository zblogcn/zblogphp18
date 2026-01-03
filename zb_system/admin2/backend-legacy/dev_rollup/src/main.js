import "../sass/mz_admin2.scss";

$(document).ready(function() {

  // 处理 jq-hidden 类，用于后续动画效果
  $('.jq-hidden').each(function() {
    $(this).hide();
    $(this).removeClass('hidden');
  });

  // 显示 tags
  $(document).click(function(event) {
    $('#ulTag').slideUp("fast");
  });

  $('#showtags').click(function(event) {
    event.stopPropagation();
    const offset = $(event.target).offset();
    $('#ulTag').css({
      top: offset.top + $(event.target).height() + 20 + "px",
      left: offset.left
    });
    $('#ulTag').slideToggle("fast");
    if (tag_loaded === false) {
      const tag = ',' + $('#edtTag').val() + ',';
      const url = $(this).data('url');
      $.getScript(url, function() {
        $('#ajaxtags a').each(function() {
          if (tag.indexOf($(this).text()) != -1) {
            $(this).addClass('selected');
          }
        });
      });
      tag_loaded = true;
    }
    return false;
  });
});
