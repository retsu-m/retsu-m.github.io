// 共通コンポーネント管理
class Components {
    // 管理者ナビゲーションのレンダリング
    static renderAdminNavigation(currentPage = 'dashboard') {
        return `
            <!-- ナビゲーションバー -->
            <nav class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <a href="dashboard.html" class="text-xl font-semibold text-gray-900">レシートキャンペーンCMS</a>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">管理者: <span id="admin-name">admin</span></span>
                            <button onclick="logout()" class="text-sm text-red-600 hover:text-red-800">ログアウト</button>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex">
                <!-- サイドメニュー -->
                <div class="w-64 bg-white shadow-sm min-h-screen">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">管理者メニュー</h2>
                        <nav class="space-y-2">
                            <a href="dashboard.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'dashboard' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                ダッシュボード
                            </a>
                            <a href="projects.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'projects' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                プロジェクト管理
                            </a>
                            <a href="users.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'users' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                ユーザー管理
                            </a>
                        </nav>
                    </div>
                </div>
        `;
    }

    // クライアントナビゲーションのレンダリング
    static renderClientNavigation(currentPage = 'dashboard', projectName = '[プロジェクト名]') {
        return `
            <!-- サイドメニュー -->
            <div class="w-64 bg-white shadow-sm min-h-screen">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">プロジェクトメニュー</h2>
                    <nav class="space-y-2">
                        <a href="dashboard.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'dashboard' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            ダッシュボード
                        </a>
                        <a href="users.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'users' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            ユーザー作成
                        </a>
                        <a href="submissions.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'submissions' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            応募者管理
                        </a>
                        <a href="setup.html" class="flex items-center px-3 py-2 text-sm font-medium ${currentPage === 'setup' ? 'text-white bg-primary rounded-md' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md'}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            プロジェクトセットアップ
                        </a>
                    </nav>
                </div>
            </div>
        `;
    }

    // クライアントヘッダーのレンダリング
    static renderClientHeader(projectName = '[プロジェクト名]', userName = '田中太郎') {
        return `
            <!-- ヘッダー -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold text-gray-900">${projectName}レシートキャンペーン</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">${userName.charAt(0)}</span>
                                </div>
                                <span class="text-sm text-gray-700">${userName}</span>
                            </div>
                            <button onclick="logout()" class="text-sm text-gray-600 hover:text-gray-900">
                                ログアウト
                            </button>
                        </div>
                    </div>
                </div>
            </header>
        `;
    }

    // 共通の認証チェック関数
    static checkAdminAuth() {
        const adminName = localStorage.getItem('adminName');
        
        if (!adminName) {
            window.location.href = 'login.html';
            return false;
        }
        
        const adminNameElement = document.getElementById('admin-name');
        if (adminNameElement) {
            adminNameElement.textContent = adminName;
        }
        
        return true;
    }

    // 共通のログアウト関数
    static logout() {
        localStorage.removeItem('adminName');
        window.location.href = 'login.html';
    }

    // 共通のクライアントログアウト関数
    static logoutClient() {
        if (confirm('ログアウトしますか？')) {
            localStorage.removeItem('userType');
            localStorage.removeItem('projectId');
            localStorage.removeItem('currentProject');
            window.location.href = '../index.html';
        }
    }

    // ページタイトルのレンダリング
    static renderPageTitle(title, subtitle = '') {
        return `
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">${title}</h2>
                ${subtitle ? `<p class="mt-2 text-sm text-gray-600">${subtitle}</p>` : ''}
            </div>
        `;
    }

    // ボタンコンポーネント
    static renderButton(text, type = 'primary', size = 'md', onClick = '', disabled = false, icon = '') {
        const baseClasses = 'inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2';
        const sizeClasses = {
            sm: 'px-3 py-1.5 text-xs',
            md: 'px-4 py-2 text-sm',
            lg: 'px-6 py-3 text-base'
        };
        const typeClasses = {
            primary: 'border-transparent text-white bg-primary hover:bg-blue-700 focus:ring-primary',
            secondary: 'border-transparent text-white bg-secondary hover:bg-green-700 focus:ring-secondary',
            danger: 'border-red-300 text-red-700 bg-white hover:bg-red-50 focus:ring-red-500',
            outline: 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-primary'
        };

        const classes = `${baseClasses} ${sizeClasses[size]} ${typeClasses[type]} ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`;
        const clickHandler = onClick ? `onclick="${onClick}"` : '';
        const disabledAttr = disabled ? 'disabled' : '';

        return `
            <button ${clickHandler} ${disabledAttr} class="${classes}">
                ${icon ? `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg>` : ''}
                ${text}
            </button>
        `;
    }

    // カードコンポーネント
    static renderCard(title, content, footer = '') {
        return `
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    ${title ? `<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">${title}</h3>` : ''}
                    <div class="space-y-4">
                        ${content}
                    </div>
                </div>
                ${footer ? `<div class="px-4 py-4 sm:px-6 border-t border-gray-200">${footer}</div>` : ''}
            </div>
        `;
    }

    // 統計カードコンポーネント
    static renderStatCard(title, value, icon, color = 'blue') {
        const colorClasses = {
            blue: 'bg-blue-500',
            green: 'bg-green-500',
            yellow: 'bg-yellow-500',
            red: 'bg-red-500'
        };

        return `
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 ${colorClasses[color]} rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${icon}
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">${title}</dt>
                            <dd class="text-lg font-medium text-gray-900">${value}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        `;
    }
}

// グローバル関数として公開
window.Components = Components;  