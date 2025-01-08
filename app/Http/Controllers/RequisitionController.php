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
use Illuminate\Support\Facades\Route;
use ZipArchive;




class RequisitionController extends Controller
{
    public function downloadDocuments($id)
    {
        // $route = Route::current(); 
        // dd($route->middleware());
        // if (!auth()->check()) {
        //     abort(403, 'Unauthorized');
        // }
        $requisition = Requisition::findOrFail($id);
        $accountability= Accountability::where('requisition_id', $id);

        // $accountability
        // dd($accountability);
        
        // Create a temporary directory
        $tempDir = storage_path('app/temp/' . uniqid());
        mkdir($tempDir, 0755, true);
        $zipPath = null;
        
        try {
            // dd(auth()->check()); 
            // Generate and save requisition form PDF
            $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition]);
            $requisitionPath = $tempDir . '/requisition_form.pdf';
            $requisitionPdf->save($requisitionPath);
            
            // Generate and save accountability form PDF
            $accountabilityPdf = PDF::loadView('accountability_report', ['accountability' => $requisition->accountability]);
            $accountabilityPath = $tempDir . '/accountability_form.pdf';
            $accountabilityPdf->save($accountabilityPath);
            
            $code= $requisition->code;
            // Create ZIP archive
            $zipFileName = 'requisition_' . $code . '_documents.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);
            
            $zip = new ZipArchive();
            $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
            // Add requisition form to ZIP
            $zip->addFile($requisitionPath, 'requisition_form.pdf');
            
            // Add accountability form to ZIP
            $zip->addFile($accountabilityPath, 'accountability_form.pdf');
            
            // Add all attached receipts to ZIP
            foreach ($requisition->accountability->requisitionItemReceipts as $receipt) {
                $receiptPath = storage_path('app/' . $receipt->file_path);
                if (file_exists($receiptPath)) {
                    $zip->addFile($receiptPath, 'receipts/' . basename($receipt->file_path));
                }
            }
            
            $zip->close();
            
            // Download ZIP file
            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ];
            
            // Clean up temporary files after sending the response
            $response = response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
            
            // Clean up the temp directory
            File::deleteDirectory($tempDir);
            
            return $response;
            
        } catch (\Exception $e) {
            // Clean up on error
            File::deleteDirectory($tempDir);
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            
            throw $e;
        }
    }
}