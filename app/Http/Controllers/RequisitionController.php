<?php

namespace App\Http\Controllers;

use App\Models\Accountability;
use App\Models\Outcome;
use App\Models\Output;
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
    
    public function downloadDocuments($id)
    {
        // $requisition = Requisition::findOrFail($id)->first();
        $requisition = Requisition::findOrFail($id);

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

   
    // function to fetch activities under a program
    public function getProgramOutcomes($id)
    {
        // $user = auth()->user()->id;
        // dd($user);
        $program = Program::find($id);
       $outcomes = $program->outcomes->pluck('name', 'id');
        return $outcomes;
    }

    // function to fetch activities under a program
    public function getOutcomeOutputs($id)
    {
        // $user = auth()->user()->id;
        // dd($user);
        $outcome = Outcome::find($id);
       $outputs = $outcome->outputs->pluck('name', 'id');
        return $outputs;
    }

    // function to fetch activities under a program
    public function getOutputActivities($id)
    {
        // $user = auth()->user()->id;
        // dd($user);
        $output = Output::find($id);
       $activities = $output->activities->pluck('name', 'id');
        return $activities;
    }
}