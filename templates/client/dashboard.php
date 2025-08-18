<?php
session_start();

// If client is not logged in, redirect to login page
if (!isset($_SESSION['client_id'])) {
    header('Location: login.php');
    // exit;
}

// We can also fetch the projects for this client
require_once ROOT_PATH . '/src/lib/Database.php';
$pdo = Database::getConnection();
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['client_id']]);
$projects = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クライアントダッシュボード - レシートキャンペーンCMS</title>
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
                 <a href="dashboard.php" class="text-xl font-semibold text-gray-900">キャンペーン管理</a>
            </div>
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">プロジェクトメニュー</h2>
                <nav class="space-y-2">
                    <a href="dashboard.php" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-secondary rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path></svg>
                        ダッシュボード
                    </a>
                    <a href="setup.php" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        プロジェクト設定
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
                            <span class="text-sm text-gray-700">ようこそ, <?php echo htmlspecialchars($_SESSION['client_company'] ?: $_SESSION['client_email'], ENT_QUOTES, 'UTF-8'); ?> 様</span>
                            <a href="logout.php" class="text-sm text-red-600 hover:text-red-800">ログアウト</a>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">ダッシュボード</h2>
                    <p class="mt-2 text-sm text-gray-600">管理しているプロジェクトの概要です。</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">あなたのプロジェクト一覧</h3>
                    <?php if (empty($projects)): ?>
                        <p class="text-gray-500">まだプロジェクトがありません。</p>
                    <?php else: ?>
                        <ul class="space-y-3">
                        <?php foreach ($projects as $project): ?>
                            <li class="bg-gray-50 p-4 rounded-md border flex justify-between items-center">
                                <span class="font-medium"><?php echo htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="text-sm text-gray-600">ステータス: <span class="font-semibold"><?php echo htmlspecialchars($project['status'], ENT_QUOTES, 'UTF-8'); ?></span></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
