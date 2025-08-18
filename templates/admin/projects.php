<?php
session_start();
require_once ROOT_PATH . '/src/lib/Database.php';

// If user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    // exit; // Removed for sandbox compatibility
}

// Fetch all projects with their client user's email
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query(
        "SELECT p.*, u.email as client_email
         FROM projects p
         JOIN users u ON p.user_id = u.id
         ORDER BY p.created_at DESC"
    );
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    // For now, just show an error and die. In a real app, log this.
    die("Database error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト管理 - レシートキャンペーンCMS</title>
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
                    <a href="dashboard.php" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path></svg>
                        ダッシュボード
                    </a>
                    <a href="projects.php" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-primary rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        プロジェクト管理
                    </a>
                    <a href="users.php" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
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

                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">新しいプロジェクトが正常に作成されました。</span>
                </div>
                <?php endif; ?>

                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">プロジェクト管理</h2>
                        <p class="mt-2 text-sm text-gray-600">すべてのキャンペーンプロジェクトを管理できます</p>
                    </div>
                    <div>
                        <!-- This button will be implemented in the next step -->
                        <a href="project_create.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-secondary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            新規プロジェクト作成
                        </a>
                    </div>
                </div>

                <!-- プロジェクト一覧 -->
                <div class="bg-white shadow rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">プロジェクト名</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">クライアント</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ステータス</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">作成日</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (empty($projects)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                            プロジェクトがまだありません。
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($project['client_email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php
                                                    switch ($project['status']) {
                                                        case 'published': echo 'bg-green-100 text-green-800'; break;
                                                        case 'archived': echo 'bg-red-100 text-red-800'; break;
                                                        default: echo 'bg-yellow-100 text-yellow-800'; break;
                                                    }
                                                ?>
                                            ">
                                                <?php echo htmlspecialchars($project['status'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('Y/m/d', strtotime($project['created_at'])); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="project_edit.php?id=<?php echo $project['id']; ?>" class="text-primary hover:text-blue-700">詳細・編集</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
