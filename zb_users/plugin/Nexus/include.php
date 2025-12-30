<?php

//注册插件
RegisterPlugin("Nexus", "ActivePlugin_Nexus");


function ActivePlugin_Nexus()
{
    global $zbp;
    //把backend.xml信息注册到系统去
    $zbp->RegisterBackEndApp('Nexus', $zbp->usersdir . 'plugin/Nexus/backend.xml');
}
