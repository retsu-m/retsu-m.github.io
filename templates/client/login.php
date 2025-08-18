<?php
session_start();

// If client is already logged in, redirect to their dashboard
if (isset($_SESSION['client_id'])) {
    header('Location: dashboard.php');
    // exit;
}

require_once ROOT_PATH . '/src/lib/Database.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errorMessage = 'メールアドレスとパスワードを入力してください。';
    } else {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $client = $stmt->fetch();

            if ($client && password_verify($password, $client['password_hash'])) {
                // Password is correct, set session variables
                $_SESSION['client_id'] = $client['id'];
                $_SESSION['client_email'] = $client['email'];
                $_SESSION['client_company'] = $client['company_name'];

                session_regenerate_id(true);

                header('Location: dashboard.php');
                // exit;
            } else {
                $errorMessage = 'メールアドレスまたはパスワードが正しくありません。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラーが発生しました。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クライアントログイン - レシートキャンペーンCMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 bg-secondary rounded-lg flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    クライアントログイン
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    プロジェクト管理画面
                </p>
            </div>

            <div class="bg-white py-8 px-6 shadow rounded-lg">
                <form class="space-y-6" method="POST" action="login.php">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            メールアドレス
                        </label>
                        <input id="email" name="email" type="email" required
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary focus:z-10 sm:text-sm"
                               placeholder="登録したメールアドレス">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            パスワード
                        </label>
                        <input id="password" name="password" type="password" required
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary focus:z-10 sm:text-sm"
                               placeholder="パスワードを入力">
                    </div>

                    <?php if ($errorMessage): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <p><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <?php endif; ?>

                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-secondary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            ログイン
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center">
                <a href="../index.php" class="text-sm text-gray-600 hover:text-gray-900">
                    ← ログイン画面選択に戻る
                </a>
            </div>
        </div>
    </div>
</body>
</html>
