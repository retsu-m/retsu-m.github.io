@extends('layouts.admin')

@section('title', 'プロジェクト詳細 - Receipt Campaign CMS Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Receipt Campaign CMS</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">管理者</span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-sign-out-alt mr-1"></i>ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-sm min-h-screen">
            <nav class="mt-5 px-2">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    ダッシュボード
                </a>
                <a href="{{ route('admin.projects.index') }}" class="bg-primary text-white group flex items-center px-2 py-2 text-base font-medium rounded-md mt-1">
                    <i class="fas fa-folder mr-3"></i>
                    プロジェクト管理
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md mt-1">
                    <i class="fas fa-users mr-3"></i>
                    ユーザー管理
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-8">
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">プロジェクト詳細</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->name }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-edit mr-2"></i>編集
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>戻る
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">基本情報</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">プロジェクト名</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $project->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">フォルダ名</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $project->folder_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">説明</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $project->description ?: '未設定' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ステータス</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($project->status === 'active') bg-green-100 text-green-800
                                            @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $project->status === 'active' ? 'アクティブ' : ($project->status === 'completed' ? '完了' : '非アクティブ') }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Client Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">クライアント情報</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">クライアント名</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $project->client_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">メールアドレス</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $project->client_email }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Campaign Information -->
                    @if($project->campaign_title || $project->campaign_description || $project->start_date || $project->end_date)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">キャンペーン情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dl class="space-y-4">
                                    @if($project->campaign_title)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">キャンペーンタイトル</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $project->campaign_title }}</dd>
                                    </div>
                                    @endif
                                    @if($project->campaign_description)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">キャンペーン説明</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $project->campaign_description }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                            <div>
                                <dl class="space-y-4">
                                    @if($project->start_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">開始日</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $project->start_date->format('Y年m月d日') }}</dd>
                                    </div>
                                    @endif
                                    @if($project->end_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">終了日</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $project->end_date->format('Y年m月d日') }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">システム情報</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">作成日時</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('Y年m月d日 H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">更新日時</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $project->updated_at->format('Y年m月d日 H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Related Users -->
                    @if($project->users->count() > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">関連ユーザー</h3>
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ユーザー名</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ステータス</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($project->users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($user->status === 'active') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $user->status === 'active' ? 'アクティブ' : '非アクティブ' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
