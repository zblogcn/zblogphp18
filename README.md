# Z-BlogPHP 1.8

[![GitHub Stars](https://img.shields.io/github/stars/zblogcn/zblogphp18)](https://github.com/zblogcn/zblogphp18/stargazers)
[![GitHub Forks](https://img.shields.io/github/forks/zblogcn/zblogphp18)](https://github.com/zblogcn/zblogphp18/network/members)
[![GitHub Issues](https://img.shields.io/github/issues/zblogcn/zblogphp18)](https://github.com/zblogcn/zblogphp18/issues)
[![GitHub Solved Issues](https://img.shields.io/github/issues-closed/zblogcn/zblogphp18)](https://github.com/zblogcn/zblogphp18/issues?q=is%3Aissue+is%3Aclosed)
[![GitHub Last Commit](https://img.shields.io/github/last-commit/zblogcn/zblogphp18)](https://github.com/zblogcn/zblogphp18/commits/main)

## 📌 项目介绍

新版本的 zbp，目前的设想是把新功能在这里实现，之后再合并到主版本里。

Z-BlogPHP 是由 Z-Blog 社区提供的博客程序，一直致力于给国内用户提供优秀的博客写作体验。从 2005 年起发布第一版，至今已有 20 年的历史，是目前国内为数不多的持续提供更新的开源 CMS 系统之一。我们的目标是使用户沉浸于写作、记录生活，不需要关注繁琐的设置等，让用户专注于创作。对于用户而言，它简单易用，体积小，速度快，支持数据量大。对开发者而言，它又有着强大的可定制性、丰富的插件接口和独立的主题模板。期待 Z-BlogPHP 能成为您写博客的上佳选择。

GitHub: https://github.com/zblogcn/zblogphp18

## 说明

· 后台模板化

```php
<?php
return array (
    // ……
    'ZC_MANAGE_UI' => 2,
);
```

## 🚀 快速开始

### 1️⃣ 克隆

```bash
git clone https://github.com/zblogcn/zblogphp18.git

```

### 2️⃣ 后台样式的工程化开发（rollup）

新版提供两套后台主题，分别为经典版（`backend-legacy`）与新样式版（`backend-toyean`）。两者均采用 rollup 进行构建最终 css 或 js 产物。

点击查看对应文档：

- [backend-legacy/dev_rollup#readme](https://github.com/zblogcn/zblogphp18/tree/main/zb_system/admin2/backend-legacy/dev_rollup#readme "backend-legacy/dev_rollup#readme")
- [backend-toyean/dev_rollup#readme](https://github.com/zblogcn/zblogphp18/tree/main/zb_system/admin2/backend-toyean/dev_rollup#readme "backend-toyean/dev_rollup#readme")

