#!/bin/bash
# Sports Wholesale - 停止本地开发服务器
# 用法: ./stop.sh

PID_FILE="/tmp/wp-server.pid"

if [ -f "$PID_FILE" ]; then
    PID=$(cat "$PID_FILE")
    if kill -0 "$PID" 2>/dev/null; then
        kill "$PID"
        rm -f "$PID_FILE"
        echo "✅ 服务器已停止 (PID: $PID)"
    else
        rm -f "$PID_FILE"
        echo "⚠️  服务器进程已不存在，已清理 PID 文件"
    fi
else
    # 尝试通过端口查找
    PID=$(lsof -ti:8080 2>/dev/null)
    if [ -n "$PID" ]; then
        kill "$PID"
        echo "✅ 服务器已停止 (PID: $PID)"
    else
        echo "⚠️  没有发现运行中的服务器"
    fi
fi
