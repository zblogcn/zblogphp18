<?php exit(); ?>
<!DOCTYPE html>
<html lang="{$language}">

<head>
    <meta charset="utf-8" />
    <meta name="generator" content="{$zblogphp}" />

    <title>{$name} - {$title}</title>
    <link rel="stylesheet" href="{$host}zb_system/admin2/{$backendtheme}/style/{$backendtheme}.css?v={$version}">
    <!-- <link rel="stylesheet" href="{$host}zb_system/image/icon/icon.css?v={$version}"> -->
    <script src="{$host}zb_system/script/jquery-2.2.4.min.js?v={$version}"></script>
    <!-- <script src="{$host}zb_system/script/zblogphp.js?v={$version}"></script> -->
    <script src="{$host}zb_system/script/md5.js?v={$version}"></script>
    <!-- <script>
        window.__ADMIN_JS_CONFIG_URL__ = '{$zbp.ajaxurl}admin2';
    </script> -->
    <!-- <script src="{$host}zb_system/admin2/script/c_admin_js_add.js?v={$version}"></script> -->
    <!-- <script src="{$host}zb_system/admin2/{$backendtheme}/script/{$backendtheme}.js?v={$version}"></script> -->
    <!-- <link rel="stylesheet" href="{$host}zb_system/css/admin.css"> -->
    {$header}
    {php}HookFilterPlugin('Filter_Plugin_Login_Header');{/php}
</head>
<style>

body {
    margin: 0;
    padding: 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-container {
    max-width: 400px;
    width: 100%;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.login-form h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #2d3748;
    font-weight: 600;
    font-size: 1.5em;
}

.login-form label {
    display: block;
    margin: 0.5rem 0;
    color: #2d3748;
    font-weight: 500;
}

.login-form .checkbox {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.login-form .checkbox input {
    margin-right: 0.5rem;
    flex-shrink: 0;
}

.login-form .checkbox label {
    display: inline;
    cursor: pointer;
}

.login-form input[type="text"],
.login-form input[type="password"] {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    font-size: 1rem;
    margin: 0.5rem 0;
    transition: border-color 0.2s;
    height: 40px;
    line-height: 40px;
}

.login-form input[type="text"]:focus,
.login-form input[type="password"]:focus {
    outline: none;
    border-color: #4299e1;
}

.login-form .submit {
    text-align: center;
}

.login-form .button:hover {
    background: #3182ce;
}

.validcode-input-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.validcode-input-wrapper input {
    flex: 1;
    margin-bottom: 0;
    height: 40px;
    padding: 0 0.75rem;
    line-height: 40px;
}

.captcha-img {
    vertical-align: middle;
    cursor: pointer;
    height: 40px;
}

@media (max-width: 480px) {
    .login-container {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .validcode-input-wrapper {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }
    
    .validcode-input-wrapper input {
        height: auto;
        padding: 0.75rem;
        line-height: normal;
    }
    
    .captcha-img {
        width: 100%;
        height: auto;
    }
}
</style>

<body class="admin-login body-login">
    <main class="login-container login">
        <form class="login-form" method="post" action="#">
            <h2>{$lang['msg']['login']}</h2>
            <input type="hidden" name="csrfToken" value="{$zbp.GetCSRFToken('login','minute')}">
            <dl>
                <dd class="username">
                    <label for="edtUserName">{$lang['msg']['username']}</label>
                    <input type="text" id="edtUserName" name="edtUserName" size="20" value="{php}echo GetVars('username', 'COOKIE');{/php}" tabindex="1" />
                </dd>

                <dd class="password">
                    <label for="edtPassWord">{$lang['msg']['password']}</label>
                    <input type="password" id="edtPassWord" name="edtPassWord" size="20" tabindex="2" />
                </dd>

                {if $zbp->option['ZC_LOGIN_VERIFY_ENABLE']}
                <dd class="validcode">
                    <label for="edtValidcode">{$lang['msg']['validcode']}</label>
                    <div class="validcode-input-wrapper">
                        <input type="text" maxlength="{$zbp.option['ZC_VERIFYCODE_LENGTH']}" id="edtValidcode" name="verify" size="20" tabindex="10" />
                        <img class="captcha-img" src="{$host}zb_system/script/c_validcode.php?id=login&time=m" onClick="javascript:this.src='{$host}zb_system/script/c_validcode.php?id=login&time=m&tm='+Math.random();" alt="validcode" />
                    </div>
                </dd>
                {/if}

                {php}<?php
                    $input_classname = $input_id = $input_label = $input_html = $input_style = '';
                    $input_tabindex = 9998;
                    $input_type = 'text';
                    foreach ($GLOBALS['hooks']['Filter_Plugin_Login_Input_Insert'] as $fpname => &$fpsignal) {
                        $fpreturn = $fpname($input_classname, $input_id, $input_label, $input_tabindex, $input_type, $input_style);
                        if (null !== $input_label) { ?>{/php}
                <dd class="{$input_classname}">
                    <label for="{$input_id}">{$input_label}</label>
                    <input type="{$input_type}" id="{$input_id}" name="{$input_id}" size="20" tabindex="{$input_tabindex}" style="{$input_style}"/>
                </dd>
                {php}<?php
                        } else {
                            $input_html = $input_id; ?>{/php}
                <dd class="{$input_classname}">
                    {$input_html}
                </dd>
                {php}<?php
                        }
                    }
                ?>{/php}
            </dl>

            <dl>
                <dd class="checkbox"><input type="checkbox" name="chkRemember" id="chkRemember"  tabindex="98" /><label for="chkRemember">{$lang['msg']['stay_signed_in']}</label></dd>
                <dd class="submit"><input id="btnPost" name="btnPost" type="submit" value="{$lang['msg']['login']}" class="button" tabindex="99"/></dd>
            </dl>
            <input type="hidden" name="username" id="username" value="" />
            <input type="hidden" name="password" id="password" value="" />
            <input type="hidden" name="savedate" id="savedate" value="1" />
        </form>
    </main>
    <script>
        $("#btnPost").click(function() {
            var strUserName = $("#edtUserName").val();
            var strPassWord = $("#edtPassWord").val();
            var strSaveDate = $("#savedate").val()

            if (strUserName === "" || strPassWord === "") {
                alert("{$lang['error']['66']}");
                return false;
            }

            if ($("#edtValidcode").val() === "" && "{$zbp->option['ZC_LOGIN_VERIFY_ENABLE']}" === "1") {
                alert("{$lang['error']['66']}");
                return false;
            }


            $("form").attr("action", "{$zbp->cmdurl}?act=verify");
            $("#edtUserName").val("");
            $("#edtPassWord").val("");
            $("#username").val(strUserName);
            $("#password").val(MD5(strPassWord));
            $("#savedate").val(strSaveDate);
        })

        $("#chkRemember").click(function() {
            $("#savedate").attr("value", $("#chkRemember").prop("checked") == true ? 30 : 1);
        })
    </script>
</body>

</html>