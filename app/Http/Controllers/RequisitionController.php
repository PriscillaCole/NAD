<?php

namespace App\Http\Controllers;

use App\Models\Accountability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\Program;
use App\Models\Staff;
use App\Models\Requisition;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use ZipArchive;




class RequisitionController extends Controller
{
    // public function downloadDocuments($id)
    // {
    //     // $route = Route::current(); 
    //     // dd($route->middleware());
    //     // if (!auth()->check()) {
    //     //     abort(403, 'Unauthorized');
    //     // }
    //     $requisition = Requisition::findOrFail($id);
    //     $accountability= Accountability::where('requisition_id', $id);

    //     // $accountability
    //     // dd($accountability);
        
    //     // Create a temporary directory
    //     // $tempDir = storage_path('app/temp/' . uniqid());
    //     // mkdir($tempDir, 0755, true);
    //     // $zipPath = null;

    //     $tempDir = storage_path('app/temp/' . uniqid());
    //         if (!File::isDirectory($tempDir)) {
    //             File::makeDirectory($tempDir, 0777, true, true);
    //         }
    //     $zipPath = null;
        
    //     try {
    //         // dd(auth()->check()); 
    //         // Generate and save requisition form PDF
    //         $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition]);
    //         $requisitionPath = $tempDir . '/requisition_form.pdf';
    //         $requisitionPdf->save($requisitionPath);
            
    //         // Generate and save accountability form PDF
    //         $accountabilityPdf = PDF::loadView('accountability_report', ['accountability' => $requisition->accountability]);
    //         $accountabilityPath = $tempDir . '/accountability_form.pdf';
    //         $accountabilityPdf->save($accountabilityPath);
            
    //         $code= $requisition->code;
    //         // Create ZIP archive
    //         $zipFileName = 'requisition_' . $code . '_documents.zip';
    //         $zipPath = storage_path('app/temp/' . $zipFileName);
            
    //         $zip = new ZipArchive();
    //         $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
    //         // Add requisition form to ZIP
    //         $zip->addFile($requisitionPath, 'requisition_form.pdf');
            
    //         // Add accountability form to ZIP
    //         $zip->addFile($accountabilityPath, 'accountability_form.pdf');
            
    //         $accountability= Accountability::where('requisition_id', $id)->first();

    //         // // Add all attached receipts to ZIP
    //         foreach ($accountability->requisitionItemReceipts as $receipt) {
    //             $receiptPath = storage_path('app/receipts' . $receipt->receipt_file);
    //             if (file_exists($receiptPath)) {
    //                 $zip->addFile($receiptPath, 'receipts/' . basename($receipt->file_path));
    //             }
    //         }
            
    //         $zip->close();
            
    //         // Download ZIP file
    //         $headers = [
    //             'Content-Type' => 'application/zip',
    //             'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
    //         ];
            
    //         // Clean up temporary files after sending the response
    //         $response = response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
            
    //         // Clean up the temp directory
    //         File::deleteDirectory($tempDir);
            
    //         return $response;
            
    //     } catch (\Exception $e) {
    //         // Clean up on error
    //         File::deleteDirectory($tempDir);
    //         if (file_exists($zipPath)) {
    //             unlink($zipPath);
    //         }
            
    //         throw $e;
    //     }
    // }

    public function downloadDocuments($id)
{
    $requisition = Requisition::findOrFail($id)->first();
    $accountability= Accountability::where('requisition_id', $id)->first();

    // Create unique temporary directory with timestamp
    $tempDirName = 'temp_' . uniqid() . '_' . time();
    $tempDir = storage_path('app/temp/' . $tempDirName);
    $zipPath = null;

    try {
        // Ensure the temp directory exists with proper permissions
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        // Set proper permissions on the directory
        chmod($tempDir, 0755);
        
        // Generate PDFs
        $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition]);
        $requisitionPath = $tempDir . '/requisition_form.pdf';
        $requisitionPdf->save($requisitionPath);
        chmod($requisitionPath, 0644); // Set file permissions
        
        $accountabilityPdf = PDF::loadView('accountability_report', ['accountability' => $accountability]);
        $accountabilityPath = $tempDir . '/accountability_form.pdf';
        $accountabilityPdf->save($accountabilityPath);
        chmod($accountabilityPath, 0644); // Set file permissions
        
        // Create ZIP file path
        $zipFileName = 'requisition_' . $requisition->code . '_documents_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        // Create and open ZIP file
        $zip = new ZipArchive();
        $zipResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        if ($zipResult !== true) {
            throw new \Exception('Failed to create ZIP file: ' . $zipResult);
        }
        
        // Add files to ZIP
        Log::info([$accountabilityPath]);
        $zip->addFile($requisitionPath, 'requisition_form.pdf');
        $zip->addFile($accountabilityPath, 'accountability_form.pdf');
        
        // Create receipts directory in ZIP
        $zip->addEmptyDir('receipts');
        $zip->addEmptyDir('Invoices');
        $zip->addEmptyDir('payment_proof');
        
        // Add receipts if they exist
        if ($accountability && $accountability->requisitionItemReceipts) {
            foreach ($accountability->requisitionItemReceipts as $receipt) {
                
                $tempDir = storage_path('app/temp/' . $tempDirName);
                $receiptPath = storage_path('app/public/' .$receipt->receipt_file);
                $invoicePath = storage_path('app/public/' . $receipt->Invoice);
                $proofPath = storage_path('app/public/'. $receipt->payment_proof);
                
                Log::info([$receiptPath]);
                if (file_exists($receiptPath)) {
                    $zip->addFile($receiptPath, 'receipts/' . basename($receipt->receipt_file));
                    Log::info('Added receipt file to zip');
                } else {
                    Log::warning('Receipt file not found: ' . $receiptPath);
                }
        
                if (file_exists($invoicePath)) {
                    $zip->addFile($invoicePath, 'Invoices/' . basename($receipt->Invoice));
                    Log::info('Added invoice file to zip');
                } else {
                    Log::warning('Invoice file not found: ' . $invoicePath);
                }
        
                if (file_exists($proofPath)) {
                    $zip->addFile($proofPath, 'payment_proof/' . basename($receipt->payment_proof));
                    Log::info('Added proof file to zip');
                } else {
                    Log::warning('Payment proof file not found: ' . $proofPath);
                }
            }
        }
        
        // Close ZIP file
        $zip->close();
        
        // Set proper permissions on the ZIP file
        // chmod($zipPath, 0644);
        
        // Set headers for download
        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];
        
        // Return file for download and cleanup afterwards
        return response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
        
    } catch (\Exception $e) {
        // Log the error with details
        \Log::error('Download Documents Error: ' . $e->getMessage(), [
            'temp_dir' => $tempDir,
            'zip_path' => $zipPath,
            // 'user_id' => auth()->user()->id(),
            'requisition_id' => $id
        ]);
        
        // Clean up
        if (File::exists($tempDir)) {
            File::deleteDirectory($tempDir);
        }
        if ($zipPath && File::exists($zipPath)) {
            unlink($zipPath);
        }
        
        throw $e;
    }
}
}