$(document).ready(function () {
  var s = document.location
  $("#divNavBar a").each(function () {
    if (this.href == s.toString().split("#")[0]) {
      $(this).addClass("on")
      return false
    }
  })
  $(".menu-toggle").click(function () {
    $(this).toggleClass("open");
    $("body").toggleClass("hidden");
    $("#divNavBar ul").toggleClass("active");
  });
  $(window).resize(function() {
    $(".menu-toggle").removeClass("open");
    $("body").removeClass("hidden");
    $("#divNavBar ul").removeClass("active");
  });
  // 返回顶部
  const backToTop = $('<div id="backToTop"><i></i></div>').appendTo('body');
  $(window).scroll(function(){
    if($(window).scrollTop() > 200){
        backToTop.fadeIn();
    }else{
        backToTop.fadeOut();
    }
  });
  backToTop.click(function(){
    $('html, body').animate({scrollTop:0}, 400);
  });
})

zbp.plugin.unbind("comment.reply.start", "system")
zbp.plugin.on("comment.reply.start", "default", function (id) {
  var i = id
  $("#inpRevID").val(i)
  var frm = $('#divCommentPost')
  var cancel = $("#cancel-reply")

  if (!frm.hasClass("reply-frm"))
    frm.before($("<div id='temp-frm' style='display:none'>")).addClass("reply-frm")
  $('#AjaxComment' + i).before(frm)

  cancel.show().click(function () {
    var temp = $('#temp-frm')
    $("#inpRevID").val(0)
    if (!temp.length || !frm.length) return
    temp.before(frm)
    temp.remove()
    $(this).hide()
    frm.removeClass("reply-frm")
    return false
  })
  try {
    $('#txaArticle').focus()
  } catch (e) {

  }
  return false
})

zbp.plugin.on("comment.get", "default", function (logid, page) {
  $('span.commentspage').html("Waiting...")
})

zbp.plugin.on("comment.got", "default", function () {
  $("#cancel-reply").click()
})

zbp.plugin.on("comment.post.success", "default", function () {
  $("#cancel-reply").click()
})