// 共通ページネーション機能
class Pagination {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.currentPage = options.currentPage || 1;
        this.totalItems = options.totalItems || 0;
        this.itemsPerPage = options.itemsPerPage || 10;
        this.onPageChange = options.onPageChange || (() => {});
        this.onPageSizeChange = options.onPageSizeChange || (() => {});
        
        this.render();
    }

    // ページネーションの表示
    render() {
        const container = document.getElementById(this.containerId);
        if (!container) return;

        const totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
        const startItem = (this.currentPage - 1) * this.itemsPerPage + 1;
        const endItem = Math.min(this.currentPage * this.itemsPerPage, this.totalItems);

        container.innerHTML = `
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button ${this.currentPage <= 1 ? 'disabled' : ''} 
                            onclick="paginationInstance.goToPage(${this.currentPage - 1})"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        前へ
                    </button>
                    <button ${this.currentPage >= totalPages ? 'disabled' : ''} 
                            onclick="paginationInstance.goToPage(${this.currentPage + 1})"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        次へ
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div>
                            <p class="text-sm text-gray-700">
                                表示中: <span class="font-medium">${startItem}</span> から <span class="font-medium">${endItem}</span> まで / 全 <span class="font-medium">${this.totalItems}</span> 件
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label for="page-size-select" class="text-sm text-gray-700">表示件数:</label>
                            <select id="page-size-select" onchange="paginationInstance.changePageSize(this.value)"
                                    class="border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="10" ${this.itemsPerPage === 10 ? 'selected' : ''}>10件</option>
                                <option value="25" ${this.itemsPerPage === 25 ? 'selected' : ''}>25件</option>
                                <option value="50" ${this.itemsPerPage === 50 ? 'selected' : ''}>50件</option>
                                <option value="100" ${this.itemsPerPage === 100 ? 'selected' : ''}>100件</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            ${this.renderPageNumbers(totalPages)}
                        </nav>
                    </div>
                </div>
            </div>
        `;
    }

    // ページ番号の表示
    renderPageNumbers(totalPages) {
        if (totalPages <= 1) return '';

        let pageNumbers = '';
        
        // 前へボタン
        pageNumbers += `
            <button ${this.currentPage <= 1 ? 'disabled' : ''} 
                    onclick="paginationInstance.goToPage(${this.currentPage - 1})"
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="sr-only">前へ</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;

        // ページ番号
        const maxVisiblePages = 5;
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            pageNumbers += `
                <button onclick="paginationInstance.goToPage(${i})"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium ${i === this.currentPage 
                            ? 'z-10 bg-primary border-primary text-white' 
                            : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'}">
                    ${i}
                </button>
            `;
        }

        // 次へボタン
        pageNumbers += `
            <button ${this.currentPage >= totalPages ? 'disabled' : ''} 
                    onclick="paginationInstance.goToPage(${this.currentPage + 1})"
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="sr-only">次へ</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;

        return pageNumbers;
    }

    // ページ移動
    goToPage(page) {
        const totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
        if (page < 1 || page > totalPages) return;
        
        this.currentPage = page;
        this.onPageChange(page);
        this.render();
    }

    // 表示件数変更
    changePageSize(size) {
        this.itemsPerPage = parseInt(size);
        this.currentPage = 1; // 最初のページに戻る
        this.onPageSizeChange(size);
        this.render();
    }

    // データ更新
    updateData(totalItems, currentPage = 1) {
        this.totalItems = totalItems;
        this.currentPage = currentPage;
        this.render();
    }
}

// グローバルインスタンス（各ページで使用）
let paginationInstance = null; 