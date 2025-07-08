<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'スーパーマーケットA キャンペーン',
                'client_name' => '田中太郎',
                'client_email' => 'tanaka@example.com',
                'folder_name' => 'supermarket-a-campaign',
                'description' => '夏の特売キャンペーン',
                'campaign_title' => '夏の大特売',
                'campaign_description' => '夏の商品が最大50%オフ',
                'start_date' => '2024-07-01',
                'end_date' => '2024-07-31',
                'status' => 'active',
            ],
            [
                'name' => 'コンビニB プロモーション',
                'client_name' => '佐藤花子',
                'client_email' => 'sato@example.com',
                'folder_name' => 'convenience-b-promo',
                'description' => '新商品プロモーション',
                'campaign_title' => '新商品発売記念',
                'campaign_description' => '新商品をお得に購入できるキャンペーン',
                'start_date' => '2024-06-15',
                'end_date' => '2024-08-15',
                'status' => 'active',
            ],
            [
                'name' => 'ドラッグストアC セール',
                'client_name' => '鈴木一郎',
                'client_email' => 'suzuki@example.com',
                'folder_name' => 'drugstore-c-sale',
                'description' => '健康商品セール',
                'campaign_title' => '健康応援セール',
                'campaign_description' => '健康関連商品が特別価格',
                'start_date' => '2024-05-01',
                'end_date' => '2024-05-31',
                'status' => 'completed',
            ],
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create($project);
        }
    }
}
