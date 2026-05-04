#!/bin/bash
# Sports Wholesale - 一键启动本地开发环境
# 用法: ./start.sh
# 首次运行会自动下载 WordPress 并安装，之后再运行只启动服务器

set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
DEV_DIR="$SCRIPT_DIR/../wordpress-dev"
DB_NAME="sportswholesale_db"
DB_USER="root"
SITE_URL="http://localhost:8080"
ADMIN_USER="admin"
ADMIN_PASS="admin123"
PID_FILE="/tmp/wp-server.pid"
PORT=8080

green()  { echo -e "\033[32m$1\033[0m"; }
yellow() { echo -e "\033[33m$1\033[0m"; }
red()    { echo -e "\033[31m$1\033[0m"; }

# wp-cli 需要更多内存，2>/dev/null 抑制 PHP 8.5 废弃警告
WP="php -d memory_limit=512M -d error_reporting=E_ALL^E_DEPRECATED $(which wp)"

# ============================================================
# 检查端口是否已被占用，直接复用
# ============================================================
EXISTING_PID=$(lsof -ti:$PORT 2>/dev/null | head -1)
if [ -n "$EXISTING_PID" ]; then
    green "✅ 服务器已在运行 (PID: $EXISTING_PID)"
    echo ""
    echo "  🌐 前台首页:     $SITE_URL"
    echo "  🔧 后台管理:     $SITE_URL/wp-admin/"
    echo "  👤 登录账号:     $ADMIN_USER / $ADMIN_PASS"
    echo ""
    echo "  🌍 语言切换:     $SITE_URL/?lang=zh|en|ar|es"
    echo "  停止服务器:      ./stop.sh"
    exit 0
fi

# 也检查 PID 文件
if [ -f "$PID_FILE" ] && kill -0 "$(cat "$PID_FILE")" 2>/dev/null; then
    green "✅ 服务器已在运行"
    echo "  停止服务器: ./stop.sh"
    exit 0
fi

echo "=========================================="
echo "  Sports Wholesale - 本地开发环境"
echo "=========================================="
echo ""

# ============================================================
# 检查依赖
# ============================================================
check_cmd() {
    if ! command -v "$1" &>/dev/null; then
        red "❌ 未安装 $1"
        return 1
    fi
    green "✅ $1 已就绪"
}

check_cmd brew || { echo "请先安装 Homebrew: https://brew.sh"; exit 1; }
check_cmd php  || { yellow "正在安装 PHP..."; brew install php; }
check_cmd wp   || { yellow "正在安装 wp-cli..."; brew install wp-cli; }
check_cmd mysql || { echo "请先安装 MySQL: brew install mysql"; exit 1; }

# ============================================================
# 启动 MySQL
# ============================================================
yellow "🗄️  检查 MySQL..."
brew services start mysql 2>/dev/null || true
sleep 2

if ! mysql -u"$DB_USER" -e "SELECT 1" &>/dev/null; then
    yellow "等待 MySQL 启动..."
    sleep 5
    if ! mysql -u"$DB_USER" -e "SELECT 1" &>/dev/null; then
        red "❌ 无法连接 MySQL，请检查: mysql -uroot -e 'SELECT 1'"
        exit 1
    fi
fi
green "✅ MySQL 已连接"

# ============================================================
# 创建数据库（已存在则跳过）
# ============================================================
DB_EXISTS=$(mysql -u"$DB_USER" -N -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='$DB_NAME';" 2>/dev/null)
if [ "$DB_EXISTS" = "$DB_NAME" ]; then
    green "✅ 数据库 $DB_NAME 已存在"
else
    yellow "📦 创建数据库 $DB_NAME..."
    mysql -u"$DB_USER" -e "CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    green "✅ 数据库已创建"
fi

# ============================================================
# 下载 WordPress（已存在则跳过）
# ============================================================
if [ -f "$DEV_DIR/wp-includes/version.php" ]; then
    green "✅ WordPress 已安装"
else
    yellow "📥 下载 WordPress（首次需要，请稍候）..."
    mkdir -p "$DEV_DIR"
    $WP core download --path="$DEV_DIR" --locale=zh_CN --force
    green "✅ WordPress 下载完成"
fi

cd "$DEV_DIR"

# ============================================================
# 生成配置文件（已存在则跳过）
# ============================================================
if [ -f "$DEV_DIR/wp-config.php" ]; then
    green "✅ 配置文件已存在"
else
    yellow "⚙️  生成 wp-config.php..."
    $WP config create \
        --dbname="$DB_NAME" \
        --dbuser="$DB_USER" \
        --locale=zh_CN \
        --skip-check \
        --force

    # 开启调试模式（替换默认的 WP_DEBUG 行）
    sed -i '' "s/define( 'WP_DEBUG', false );/define( 'WP_DEBUG', true );/" wp-config.php

    green "✅ 配置文件已生成（调试模式已开启）"
fi

# ============================================================
# 安装 WordPress（已安装则跳过）
# ============================================================
if $WP core is-installed 2>/dev/null; then
    green "✅ WordPress 已安装"
else
    yellow "🔧 安装 WordPress..."
    $WP core install \
        --url="$SITE_URL" \
        --title="Sports Wholesale Demo" \
        --admin_user="$ADMIN_USER" \
        --admin_password="$ADMIN_PASS" \
        --admin_email="admin@example.com" \
        --skip-email
    green "✅ WordPress 安装完成"
fi

# ============================================================
# 链接主题（已链接则跳过）
# ============================================================
THEME_LINK="$DEV_DIR/wp-content/themes/sportswholesale"
if [ -L "$THEME_LINK" ]; then
    green "✅ 主题已链接"
else
    yellow "🔗 链接主题..."
    ln -sf "$SCRIPT_DIR" "$THEME_LINK"
    green "✅ 主题已链接"
fi

# ============================================================
# 激活主题
# ============================================================
ACTIVE_THEME=$($WP option get stylesheet 2>/dev/null)
if [ "$ACTIVE_THEME" = "sportswholesale" ]; then
    green "✅ 主题已激活"
else
    yellow "🎨 激活主题..."
    $WP theme activate sportswholesale
    green "✅ 主题已激活（示例数据已插入）"
fi

# ============================================================
# 设置固定链接
# ============================================================
$WP rewrite structure '/%postname%/' 2>/dev/null || true

# ============================================================
# 启动服务器
# ============================================================
echo ""
echo "=========================================="
green "  ✅ 一切就绪，启动服务器..."
echo "=========================================="
echo ""
echo "  🌐 前台首页:     $SITE_URL"
echo "  🔧 后台管理:     $SITE_URL/wp-admin/"
echo "  👤 登录账号:     $ADMIN_USER / $ADMIN_PASS"
echo ""
echo "  🌍 语言切换测试:"
echo "     中文:         $SITE_URL/?lang=zh"
echo "     English:      $SITE_URL/?lang=en"
echo "     العربية:      $SITE_URL/?lang=ar"
echo "     Español:      $SITE_URL/?lang=es"
echo ""
echo "  停止服务器: ./stop.sh"
echo "=========================================="
echo ""

# 启动 WordPress 开发服务器
$WP server --host=0.0.0.0 --port=$PORT > /dev/null 2>&1 &
SERVER_PID=$!
echo "$SERVER_PID" > "$PID_FILE"

sleep 2
if kill -0 "$SERVER_PID" 2>/dev/null; then
    green "🚀 服务器已启动 (PID: $SERVER_PID)"
    echo ""
    echo "  按 Ctrl+C 停止，或运行: ./stop.sh"
    # 前台等待，Ctrl+C 可停止
    trap "kill $SERVER_PID 2>/dev/null; rm -f $PID_FILE; echo ''; green '服务器已停止'; exit 0" INT TERM
    wait $SERVER_PID
else
    red "❌ 服务器启动失败"
    rm -f "$PID_FILE"
    exit 1
fi
