<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BackupController extends Controller
{
    use AuthorizesRequests;
    
    protected $auditService;
    protected $backupPath;
    
    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
        $this->backupPath = storage_path('app/backups');
    }
    
    /**
     * Display a listing of backups.
     */
    public function index(): View
    {
        $this->authorize('manageBackups');
        
        // Ensure backup directory exists
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
        
        // Get all backup files
        $files = File::files($this->backupPath);
        
        $backups = [];
        foreach ($files as $file) {
            $name = $file->getFilename();
            
            // Get file size in MB
            $size = round($file->getSize() / 1024 / 1024, 2);
            
            // Get date from filename (format: backup_Y-m-d_H-i-s.sql)
            $parts = explode('_', $name);
            if (count($parts) >= 3) {
                $datePart = $parts[1] . '_' . substr($parts[2], 0, 8);
                $date = \DateTime::createFromFormat('Y-m-d_H-i-s', $datePart);
            } else {
                $date = \DateTime::createFromFormat('U', $file->getMTime());
            }
            
            $backups[] = [
                'name' => $name,
                'size' => $size,
                'date' => $date,
            ];
        }
        
        // Sort by date (newest first)
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });
        
        return view('superadmin.backups.index', compact('backups'));
    }
    
    /**
     * Create a new database backup.
     */
    public function create()
    {
        $this->authorize('manageBackups');
        
        // Ensure backup directory exists
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
        
        try {
            // Get database config
            $dbConfig = config('database.connections.' . config('database.default'));
            
            // Generate backup filename
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";
            $filePath = "{$this->backupPath}/{$filename}";
            
            // Create backup command
            if ($dbConfig['driver'] === 'mysql') {
                $command = sprintf(
                    'mysqldump -h %s -u %s %s %s > %s',
                    $dbConfig['host'],
                    $dbConfig['username'],
                    $dbConfig['password'] ? '-p' . $dbConfig['password'] : '',
                    $dbConfig['database'],
                    $filePath
                );
                
                exec($command);
                
                // Log the backup action
                $this->auditService->log(
                    'backup.create',
                    "Created database backup: {$filename}",
                    ['file' => $filename, 'size' => File::size($filePath)]
                );
                
                return redirect()->route('superadmin.backups.index')
                    ->with('success', 'Backup database berhasil dibuat.');
            } else {
                return redirect()->route('superadmin.backups.index')
                    ->with('error', 'Backup database hanya didukung untuk MySQL.');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('superadmin.backups.index')
                ->with('error', 'Terjadi kesalahan saat membuat backup: ' . $e->getMessage());
        }
    }
    
    /**
     * Download a backup file.
     */
    public function download(string $backup)
    {
        $this->authorize('manageBackups');
        
        $filePath = "{$this->backupPath}/{$backup}";
        
        if (File::exists($filePath)) {
            // Log the download action
            $this->auditService->log(
                'backup.download',
                "Downloaded database backup: {$backup}",
                ['file' => $backup]
            );
            
            return Response::download($filePath);
        } else {
            return redirect()->route('superadmin.backups.index')
                ->with('error', 'File backup tidak ditemukan.');
        }
    }
    
    /**
     * Delete a backup file.
     */
    public function destroy(string $backup)
    {
        $this->authorize('manageBackups');
        
        $filePath = "{$this->backupPath}/{$backup}";
        
        if (File::exists($filePath)) {
            File::delete($filePath);
            
            // Log the deletion action
            $this->auditService->log(
                'backup.delete',
                "Deleted database backup: {$backup}",
                ['file' => $backup]
            );
            
            return redirect()->route('superadmin.backups.index')
                ->with('success', 'File backup berhasil dihapus.');
        } else {
            return redirect()->route('superadmin.backups.index')
                ->with('error', 'File backup tidak ditemukan.');
        }
    }
}
