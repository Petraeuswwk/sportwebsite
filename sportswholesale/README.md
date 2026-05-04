# Sports Wholesale - WordPress Theme

外贸体育用品批发商 B2B 产品目录主题，支持中/英/阿/西四语即时切换。

## 功能特性

- **四语切换**：中文、English、العربية、Español，右上角下拉菜单即时切换
- **RTL 支持**：阿拉伯语自动启用 `dir="rtl"`，Bootstrap 5 + CSS 逻辑属性完美镜像
- **产品目录**：自定义文章类型 `product`，含价格、MOQ、材质、多图画廊等字段
- **分类管理**：乒乓球、羽毛球、网球、匹克球、跳绳，支持筛选和排序
- **询盘系统**：弹窗/独立页面表单，Honeypot 反垃圾，保存到后台 + 邮件通知
- **示例数据**：激活时自动插入 8 个产品和 5 个分类
- **响应式设计**：Bootstrap 5 网格，移动端适配
- **无插件依赖**：不依赖 ACF、WPML 等第三方插件

## 快速开始（本地开发）

### 前置条件

需要 Homebrew、PHP、MySQL、wp-cli。脚本会自动检测并安装缺失的依赖。

```bash
# 如果还没装 PHP 和 wp-cli
brew install php wp-cli
```

### 一键启动

```bash
cd sportswholesale
./start.sh
```

首次运行会自动完成：创建数据库 → 下载 WordPress → 生成配置 → 安装 → 链接主题 → 激活 → 启动服务器。

**之后再运行 `./start.sh` 只会启动服务器，不会重复安装。**

### 浏览器访问

| 页面 | 地址 |
|------|------|
| 前台首页 | http://localhost:8080 |
| 产品目录 | http://localhost:8080/products/ |
| 后台管理 | http://localhost:8080/wp-admin/ |
| 切换中文 | http://localhost:8080/?lang=zh |
| 切换英文 | http://localhost:8080/?lang=en |
| 切换阿拉伯语(RTL) | http://localhost:8080/?lang=ar |
| 切换西班牙语 | http://localhost:8080/?lang=es |

后台登录：`admin` / `admin123`

### 停止服务器

```bash
./stop.sh
```

### 重置环境

如果需要清除所有数据重新安装：

```bash
./reset.sh      # 删除 WordPress 目录和数据库
./start.sh      # 重新安装
```

### 常用调试命令

```bash
cd ../wordpress-dev

# 查看产品列表
wp post list --post_type=product --fields=ID,post_title

# 查看分类
wp term list product_category --fields=term_id,name,slug

# 重新插入示例数据
wp option delete sportswholesale_sample_data_inserted
wp theme activate sportswholesale

# 查看 PHP 错误日志
tail -f wp-content/debug.log
```

## 部署到线上服务器

1. 将 `sportswholesale/` 文件夹压缩为 `.zip`
2. WordPress 后台 → 外观 → 主题 → 安装主题 → 上传 → 激活
3. 激活后自动创建 CPT、分类和示例产品

## 翻译指南

所有前端字符串已用 `__()` / `_e()` 包裹，文本域为 `sportswholesale`。

### 使用 Poedit 翻译

1. 打开 [Poedit](https://poedit.net/)
2. 打开 `languages/sportswholesale.pot` 或对应语言的 `.po` 文件
3. 翻译每条 `msgid` 对应的 `msgstr`
4. 导出为 `.mo` 文件（与 `.po` 同目录）

### 语言文件说明

| 文件 | 语言 | 方向 |
|------|------|------|
| `zh_CN.po/.mo` | 简体中文 | LTR |
| `en_US.po/.mo` | English | LTR |
| `ar.po/.mo` | العربية | RTL |
| `es_ES.po/.mo` | Español | LTR |

语言切换通过 `sportswholesale_lang` Cookie 实现（有效期 30 天），也可通过 URL 参数 `?lang=zh|en|ar|es` 切换。

## 目录结构

```
sportswholesale/
├── start.sh                     # 一键启动脚本
├── stop.sh                      # 停止服务器
├── reset.sh                     # 重置环境
├── style.css                    # 主题声明
├── functions.php                # 核心函数
├── header.php                   # 头部 + 导航 + 语言切换器
├── footer.php                   # 页脚
├── front-page.php               # 首页
├── archive-product.php          # 产品归档页
├── single-product.php           # 产品详情页
├── page-inquiry.php             # 独立询盘页面
├── index.php                    # 回退模板
├── inc/
│   ├── locale-filter.php        # 语言检测与 locale 钩子
│   ├── language-switcher.php    # 语言切换器输出
│   ├── post-types.php           # CPT 和分类法注册
│   ├── meta-boxes.php           # 产品自定义字段
│   ├── inquiry-handler.php      # 询盘表单处理
│   └── theme-setup.php          # 主题设置、示例数据、资源入队
├── template-parts/
│   ├── content-product-card.php
│   └── inquiry-form.php
├── assets/
│   ├── css/main.css             # 主样式（逻辑属性，RTL 兼容）
│   └── js/main.js               # 交互脚本
└── languages/                   # 翻译文件
```

## 自定义

### 添加新产品分类

在 `inc/theme-setup.php` 的 `sportswholesale_get_category_colors` 和 `sportswholesale_get_category_icons` 过滤器中添加对应条目，或直接在后台 → 产品 → 分类中添加。

### 修改配色

编辑 `assets/css/main.css` 中的 CSS 自定义属性（`:root` 部分）。

### 修改联系信息

编辑 `footer.php` 中的邮箱、电话、地址等占位内容。

### 钩子扩展

主题提供以下 `apply_filters` 钩子：

- `sportswholesale_languages` - 可用语言列表
- `sportswholesale_countries` - 国家下拉列表
- `sportswholesale_category_icons` - 分类图标
- `sportswholesale_category_colors` - 分类颜色

## 系统要求

- WordPress 6.0+
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.3+

## 许可证

GPL v2 or later
