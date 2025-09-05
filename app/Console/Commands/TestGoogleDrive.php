<?php 
// app/Console/Commands/TestGoogleDrive.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Drive;

class TestGoogleDrive extends Command
{
    protected $signature = 'test:drive';
    protected $description = 'Test Google Drive API connection';

    public function handle()
    {
        try {
            $client = new Client();
            $client->setAuthConfig(storage_path('app/google/credentials.json'));
            // القراءة فقط تكفي هنا
            $client->addScope(Drive::DRIVE_READONLY);

            $service = new Drive($client);

            // المجلد الهدف (المجلد الثاني الذي يحتوي على ملفات PDF)
            $folderId = '1liphJiso9RMJfXeSp5Wd98utjniDQ8sUByfkk66jXrq2v66wiare0s1OSLt3Xq9o9JXmhFyA';

            $pageToken = null;
            $found = false;

            do {
                $params = [
                    // البحث داخل المجلد الهدف فقط + استبعاد العناصر المحذوفة + تقييد نوع الملف إلى PDF
                    'q' => "'{$folderId}' in parents and mimeType = 'application/pdf' and trashed = false",
                    'pageSize' => 100,
                    'pageToken' => $pageToken,
                    'fields' => 'nextPageToken, files(id, name, mimeType, webViewLink)',
                    // دعم Shared Drives إن وُجدت
                    'supportsAllDrives' => true,
                    'includeItemsFromAllDrives' => true,
                ];

                $response = $service->files->listFiles($params);
                $files = $response->getFiles();

                if ($files && count($files) > 0) {
                    $found = true;
                    foreach ($files as $file) {
                        $this->info("📄 {$file->getName()} ({$file->getWebViewLink()})");
                    }
                }

                $pageToken = $response->getNextPageToken();
            } while ($pageToken);

            if (!$found) {
                // كفحص إضافي: اعرض أي عناصر (أي نوع) داخل المجلد لمعرفة إن كانت المشكلة بنوع الملف فقط
                $fallback = $service->files->listFiles([
                    'q' => "'{$folderId}' in parents and trashed = false",
                    'pageSize' => 10,
                    'fields' => 'files(id, name, mimeType, webViewLink)',
                    'supportsAllDrives' => true,
                    'includeItemsFromAllDrives' => true,
                ]);

                if (count($fallback->getFiles()) === 0) {
                    $this->warn("لا يوجد ملفات داخل المجلد المحدد. تحقق من الصلاحيات أو من أن الحساب لديه وصول للمجلد.");
                } else {
                    $this->info("لم يتم العثور على ملفات PDF، لكن هناك عناصر أخرى داخل المجلد:");
                    foreach ($fallback->getFiles() as $file) {
                        $this->line("- {$file->getName()} [{$file->getMimeType()}]");
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->error('حدث خطأ أثناء الاتصال بـ Google Drive: ' . $e->getMessage());
        }
    }
}
