#!/bin/bash
# Sports Wholesale - 重置本地环境（删除 WordPress 数据重新安装）
# 用法: ./reset.sh

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
DEV_DIR="$SCRIPT_DIR/../wordpress-dev"
PID_FILE="/tmp/wp-server.pid"

echo "⚠️  即将删除以下内容："
echo "   - $DEV_DIR/ (WordPress 完整目录)"
echo "   - 数据库 sportswholesale_db"
echo ""
read -p "确认重置？(y/N): " confirm
if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    echo "已取消"
    exit 0
fi

# 停止服务器
if [ -f "$PID_FILE" ]; then
    kill "$(cat "$PID_FILE")" 2>/dev/null
    rm -f "$PID_FILE"
fi

# 删除 WordPress 目录
rm -rf "$DEV_DIR"

# 删除数据库
mysql -uroot -e "DROP DATABASE IF EXISTS sportswholesale_db;" 2>/dev/null

echo "✅ 重置完成，运行 ./start.sh 重新安装"
