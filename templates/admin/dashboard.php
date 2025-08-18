<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    // exit; // Removed for sandbox compatibility
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード - レシートキャンペーンCMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- サイドメニュー -->
        <div class="w-64 bg-white shadow-sm min-h-screen">
            <div class="p-4 border-b">
                 <a href="dashboard.php" class="text-xl font-semibold text-gray-900">レシートキャンペーンCMS</a>
            </div>
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">管理者メニュー</h2>
                <nav class="space-y-2">
                    <a href="dashboard.php" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-primary rounded-md">
                        <!-- Dashboard Icon -->
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path></svg>
                        ダッシュボード
                    </a>
                    <a href="projects.php" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                        <!-- Projects Icon -->
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        プロジェクト管理
                    </a>
                    <a href="users.php" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                        <!-- Users Icon -->
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                        ユーザー管理
                    </a>
                </nav>
            </div>
        </div>

        <!-- メインコンテンツ -->
        <div class="flex-1">
            <nav class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-end h-16">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">管理者: <?php echo htmlspecialchars($_SESSION['admin_username'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <a href="logout.php" class="text-sm text-red-600 hover:text-red-800">ログアウト</a>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">ダッシュボード</h2>
                    <p class="mt-2 text-sm text-gray-600">システム全体の概要を確認できます</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p>ようこそ、管理者ダッシュボードへ。</p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
