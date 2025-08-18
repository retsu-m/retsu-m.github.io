<?php
session_start();
require_once ROOT_PATH . '/src/lib/Database.php';

// If user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    // exit; // Removed for sandbox compatibility
}

$errorMessage = '';
$successMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectName = $_POST['project_name'] ?? '';
    $clientEmail = $_POST['client_email'] ?? '';
    $clientPassword = $_POST['client_password'] ?? '';
    $clientCompanyName = $_POST['company_name'] ?? '';

    if (empty($projectName) || empty($clientEmail) || empty($clientPassword)) {
        $errorMessage = 'すべての必須項目を入力してください。';
    } elseif (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = '有効なメールアドレスを入力してください。';
    } else {
        $pdo = Database::getConnection();
        try {
            // Check if user already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$clientEmail]);
            if ($stmt->fetch()) {
                $errorMessage = 'このメールアドレスは既に使用されています。';
            } else {
                // Use a transaction to ensure both inserts succeed or fail together
                $pdo->beginTransaction();

                // 1. Create the client user
                $passwordHash = password_hash($clientPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare(
                    "INSERT INTO users (email, password_hash, company_name) VALUES (?, ?, ?)"
                );
                $stmt->execute([$clientEmail, $passwordHash, $clientCompanyName]);
                $userId = $pdo->lastInsertId();

                // 2. Create the project
                $stmt = $pdo->prepare(
                    "INSERT INTO projects (user_id, project_name) VALUES (?, ?)"
                );
                $stmt->execute([$userId, $projectName]);

                $pdo->commit();

                // Redirect to project list on success
                header('Location: projects.php?success=1');
                // exit;
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $errorMessage = 'データベースエラー: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規プロジェクト作成 - レシートキャンペーンCMS</title>
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
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">新規プロジェクト作成</h2>
                    <p class="mt-2 text-sm text-gray-600">新しいキャンペーンプロジェクトとクライアントアカウントを作成します。</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 max-w-xl">
                    <form method="POST" action="project_create.php">

                        <?php if ($errorMessage): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="space-y-4">
                            <div>
                                <label for="project_name" class="block text-sm font-medium text-gray-700">プロジェクト名 *</label>
                                <input type="text" name="project_name" id="project_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                             <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700">クライアント会社名</label>
                                <input type="text" name="company_name" id="company_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label for="client_email" class="block text-sm font-medium text-gray-700">クライアント メールアドレス *</label>
                                <input type="email" name="client_email" id="client_email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label for="client_password" class="block text-sm font-medium text-gray-700">クライアント 初期パスワード *</label>
                                <input type="password" name="client_password" id="client_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="projects.php" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                キャンセル
                            </a>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-secondary border border-transparent rounded-md hover:bg-green-700">
                                作成
                            </button>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
