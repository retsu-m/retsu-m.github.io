@extends('layouts.admin')

@section('title', 'プロジェクト管理 - Receipt Campaign CMS Admin')

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
                        <h2 class="text-2xl font-bold text-gray-900">プロジェクト管理</h2>
                        <p class="mt-1 text-sm text-gray-600">プロジェクトの作成、編集、削除を行います</p>
                    </div>
                    <a href="{{ route('admin.projects.create') }}" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i>新規プロジェクト
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <form method="GET" action="{{ route('admin.projects.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">検索</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" 
                                   placeholder="プロジェクト名、クライアント名、メールアドレス">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="">すべて</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>アクティブ</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>完了</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                <i class="fas fa-search mr-2"></i>検索
                            </button>
                            <a href="{{ route('admin.projects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                リセット
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Projects Table -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="overflow-hidden">
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
                                @forelse($projects as $project)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $project->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $project->client_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $project->client_email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($project->status === 'active') bg-green-100 text-green-800
                                            @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $project->status === 'active' ? 'アクティブ' : ($project->status === 'completed' ? '完了' : '非アクティブ') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $project->created_at->format('Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">詳細</a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">編集</a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('本当に削除しますか？')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        プロジェクトが見つかりません
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($projects->hasPages())
                        <div class="mt-6">
                            {{ $projects->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
