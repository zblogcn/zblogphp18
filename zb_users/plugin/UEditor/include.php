<?php

//ZBP的第一个插件，ueditor插件

//注册插件
RegisterPlugin('UEditor', 'ActivePlugin_UEditor');

function ActivePlugin_UEditor()
{
    Add_Filter_Plugin('Filter_Plugin_Edit_Begin', 'ueditor_addscript_begin');
    Add_Filter_Plugin('Filter_Plugin_Edit_End', 'ueditor_addscript_end');
    Add_Filter_Plugin('Filter_Plugin_Html_Js_Add', 'ueditor_SyntaxHighlighter_print');
}

function ueditor_SyntaxHighlighter_print()
{
    global $zbp;
    if (!$zbp->option['ZC_SYNTAXHIGHLIGHTER_ENABLE']) {
        return;
    }

    echo "\r\n" . 'document.writeln("<script src=\'' . $zbp->host . 'zb_users/plugin/UEditor/third-party/prism/prism.js\' type=\'text/javascript\'><\/script><link rel=\'stylesheet\' type=\'text/css\' href=\'' . $zbp->host . 'zb_users/plugin/UEditor/third-party/prism/prism.css\'/>");';
    echo '$(function(){var compatibility={as3:"actionscript","c#":"csharp",delphi:"pascal",html:"markup",xml:"markup",vb:"basic",js:"javascript",plain:"markdown",pl:"perl",ps:"powershell"};var runFunction=function(doms,callback){doms.each(function(index,unwrappedDom){var dom=$(unwrappedDom);var codeDom=$("<code>");if(callback)callback(dom);var languageClass="prism-language-"+function(classObject){if(classObject===null)return"markdown";var className=classObject[1];return compatibility[className]?compatibility[className]:className}(dom.attr("class").match(/prism-language-([0-9a-zA-Z]+)/));codeDom.html(dom.html()).addClass("prism-line-numbers").addClass(languageClass);dom.html("").addClass(languageClass).append(codeDom)})};runFunction($("pre.prism-highlight"));runFunction($(\'pre[class*="brush:"]\'),function(preDom){var original;if((original=preDom.attr("class").match(/brush:([a-zA-Z0-9\#]+);/))!==null){preDom.get(0).className="prism-highlight prism-language-"+original[1]}});Prism.highlightAll()});';
    echo "\r\n";
}

function InstallPlugin_UEditor()
{
}

function UninstallPlugin_UEditor()
{
}

function ueditor_addscript_begin()
{
    global $zbp;
    echo '<script src="' . UEditor_Path('ueditor.config.php', 'host') . '"></script>';
    echo '<script src="' . UEditor_Path('ueditor.all.min.js', 'host') . '"></script>';
    echo '<style type="text/css">#editor_content{height:auto}</style>';
}

function ueditor_addscript_end()
{
    echo '<script src="' . UEditor_Path('script', 'host') . '"></script>';
}

function UEditor_Path($file, $t = 'path')
{
    global $zbp;
    $result = $zbp->{$t} . 'zb_users/plugin/UEditor/';

    switch ($file) {
    case 'script':
      return $result . 'script/script.js';

      break;

    default:
      return $result . $file;
  }
}
