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
    
    // public function downloadDocuments($id)
    // {
    //     // $requisition = Requisition::findOrFail($id)->first();
    //     $requisition = Requisition::findOrFail($id);
    //     $activityid = $requisition->activity->id;

    //     // Sum of accountabilities for all requisitions under this activity
    //     $activity_budget = $requisition->activity->budget;
       
    //     $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityid) {
    //         $query->where('activity_id', $activityid);
    //     })->sum('amount_used');

    //     Log::info($usedAmount);
    //     Log::info($activity_budget);
    //     $remaining = $activity_budget - $usedAmount;

    //     $accountability= Accountability::where('requisition_id', $id)->first();

    //     // Create unique temporary directory with timestamp
    //     $tempDirName = 'temp_' . uniqid() . '_' . time();
    //     $tempDir = storage_path('app/temp/' . $tempDirName);
    //     $zipPath = null;

    //     try {
    //         // Ensure the temp directory exists with proper permissions
    //         if (!File::exists($tempDir)) {
    //             File::makeDirectory($tempDir, 0755, true);
    //         }

    //         // Set proper permissions on the directory
    //         chmod($tempDir, 0755);
            
    //         // Generate PDFs
    //         $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition, 'remaining'=>$remaining]);
    //         $requisitionPath = $tempDir . '/requisition_form.pdf';
    //         $requisitionPdf->save($requisitionPath);
    //         chmod($requisitionPath, 0644); // Set file permissions
    //         // //concept note
    //         // $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition, 'remaining'=>$remaining]);
    //         // $requisitionPath = $tempDir . '/requisition_form.pdf';
    //         // $conceptpath = storage_path('app/public/' .$requisition->concept_note);
    //         // $requisitionPdf->save($requisitionPath);
    //         // chmod($requisitionPath, 0644); // Set file permissions
            
    //         $accountabilityPdf = PDF::loadView('accountability_report', ['accountability' => $accountability]);
    //         $accountabilityPath = $tempDir . '/accountability_form.pdf';
    //         $accountabilityPdf->save($accountabilityPath);
    //         chmod($accountabilityPath, 0644); // Set file permissions
            
    //         // Create ZIP file path
    //         $zipFileName = 'requisition_' . $requisition->code . '_documents_' . time() . '.zip';
    //         $zipPath = storage_path('app/temp/' . $zipFileName);
            
    //         // Create and open ZIP file
    //         $zip = new ZipArchive();
    //         $zipResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
    //         if ($zipResult !== true) {
    //             throw new \Exception('Failed to create ZIP file: ' . $zipResult);
    //         }
            
    //         // Add files to ZIP
    //         Log::info([$accountabilityPath]);
    //         $zip->addFile($requisitionPath, 'requisition_form.pdf');
    //         $zip->addFile($accountabilityPath, 'accountability_form.pdf');
            
    //         // Create receipts directory in ZIP
    //         $zip->addEmptyDir('receipts');
    //         $zip->addEmptyDir('Invoices');
    //         $zip->addEmptyDir('payment_proof');
            
    //         // Add receipts if they exist
    //         if ($accountability && $accountability->requisitionItemReceipts) {
    //             foreach ($accountability->requisitionItemReceipts as $receipt) {
                    
    //                 $tempDir = storage_path('app/temp/' . $tempDirName);
    //                 // $receiptPath = storage_path('app/public/' . $receipt->receipt_file);
    //                 $receiptPath = storage_path('app/public/' .$receipt->receipt_file);
    //                 $invoicePath = storage_path('app/public/' . $receipt->Invoice);
    //                 $proofPath = storage_path('app/public/'. $receipt->payment_proof);
                    
    //                 Log::info([$receiptPath]);
    //                 if (file_exists($receiptPath)) {
    //                     $zip->addFile($receiptPath, 'receipts/' . basename($receipt->receipt_file));
    //                     Log::info('Added receipt file to zip');
    //                 } else {
    //                     Log::warning('Receipt file not found: ' . $receiptPath);
    //                 }
            
    //                 if (file_exists($invoicePath)) {
    //                     $zip->addFile($invoicePath, 'Invoices/' . basename($receipt->Invoice));
    //                     Log::info('Added invoice file to zip');
    //                 } else {
    //                     Log::warning('Invoice file not found: ' . $invoicePath);
    //                 }
            
    //                 if (file_exists($proofPath)) {
    //                     $zip->addFile($proofPath, 'payment_proof/' . basename($receipt->payment_proof));
    //                     Log::info('Added proof file to zip');
    //                 } else {
    //                     Log::warning('Payment proof file not found: ' . $proofPath);
    //                 }
    //             }
    //         }
            
    //         // Close ZIP file
    //         $zip->close();
            
    //         // Set proper permissions on the ZIP file
    //         // chmod($zipPath, 0644);
            
    //         // Set headers for download
    //         $headers = [
    //             'Content-Type' => 'application/zip',
    //             'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
    //             'Cache-Control' => 'no-cache, no-store, must-revalidate',
    //             'Pragma' => 'no-cache',
    //             'Expires' => '0'
    //         ];
            
    //         // Return file for download and cleanup afterwards
    //         return response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
            
    //     } catch (\Exception $e) {
    //         // Log the error with details
    //         \Log::error('Download Documents Error: ' . $e->getMessage(), [
    //             'temp_dir' => $tempDir,
    //             'zip_path' => $zipPath,
    //             // 'user_id' => auth()->user()->id(),
    //             'requisition_id' => $id
    //         ]);
            
    //         // Clean up
    //         if (File::exists($tempDir)) {
    //             File::deleteDirectory($tempDir);
    //         }
    //         if ($zipPath && File::exists($zipPath)) {
    //             unlink($zipPath);
    //         }
            
    //         throw $e;
    //     }
    // }

    public function downloadDocuments($id)
    {
        @set_time_limit(180);

        while (ob_get_level()) {
            ob_end_clean();
        }

        $requisition = Requisition::findOrFail($id);
        $accountability = Accountability::with('requisitionItemReceipts')->where('requisition_id', $id)->first();

        // Keep remaining budget calculation consistent with the requisition report page.
        if ($requisition->program?->type == 2) {
            $activityBudget = $requisition->adminoutcome?->budget ?? 0;
            $activityId = $requisition->activity?->id;
        } else {
            $activityBudget = $requisition->activity?->budget ?? 0;
            $activityId = $requisition->activity?->id;
        }

        $usedAmount = 0;
        if ($activityId) {
            $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityId) {
                $query->where('activity_id', $activityId);
            })->sum('amount_used');
        }
        $remaining = $activityBudget - $usedAmount;

        $tempDirName = 'temp_' . uniqid() . '_' . time();
        $tempDir = storage_path('app/temp/' . $tempDirName);
        $zipPath = null;

        try {
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true);
            }

            $zipFileName = 'requisition_' . $requisition->code . '_documents_' . time() . '.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);

            $zip = new ZipArchive();
            $zipResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            if ($zipResult !== true) {
                throw new \Exception('Failed to create ZIP file: ' . $zipResult);
            }

            // 1) Requisition report PDF
            $requisitionPdfPath = $tempDir . '/01_requisition_request.pdf';
            $requisitionPdf = PDF::loadView('requisition_request', [
                'requisition' => $requisition,
                'remaining' => $remaining,
            ]);
            $this->applyFastPdfOptions($requisitionPdf);
            $requisitionPdf->save($requisitionPdfPath);
            $zip->addFile($requisitionPdfPath, '01_requisition_request.pdf');

            // 2) Concept note file
            $conceptNotePath = $this->resolveConceptNotePath($requisition);
            if ($conceptNotePath && File::exists($conceptNotePath) && is_readable($conceptNotePath)) {
                $zip->addFile($conceptNotePath, 'concept_note/' . basename($conceptNotePath));
            }

            // 3) Accountability report + all accountability attachments (only if accountability exists)
            if ($accountability) {
                $accountabilityPdfPath = $tempDir . '/02_accountability_report.pdf';
                $accountabilityPdf = PDF::loadView('accountability_report', ['accountability' => $accountability]);
                $this->applyFastPdfOptions($accountabilityPdf);
                $accountabilityPdf->save($accountabilityPdfPath);
                $zip->addFile($accountabilityPdfPath, '02_accountability_report.pdf');

                foreach ($this->normalizeFileList($accountability->narrative_report) as $path) {
                    $this->addPublicStorageFileToZip($zip, $path, 'accountability/narrative_reports');
                }
                foreach ($this->normalizeFileList($accountability->proof_of_funds_returned) as $path) {
                    $this->addPublicStorageFileToZip($zip, $path, 'accountability/returned_funds_receipts');
                }
                foreach ($this->normalizeFileList($accountability->proof_of_funds_to_be_returned) as $path) {
                    $this->addPublicStorageFileToZip($zip, $path, 'accountability/staff_return_receipts');
                }
                foreach ($this->normalizeFileList($accountability->attachments) as $path) {
                    $this->addPublicStorageFileToZip($zip, $path, 'accountability/attachments');
                }

                foreach ($accountability->requisitionItemReceipts as $receipt) {
                    foreach ($this->normalizeFileList($receipt->Invoice) as $path) {
                        $this->addPublicStorageFileToZip($zip, $path, 'accountability/item_receipts/invoices');
                    }
                    foreach ($this->normalizeFileList($receipt->payment_proof) as $path) {
                        $this->addPublicStorageFileToZip($zip, $path, 'accountability/item_receipts/payment_proofs');
                    }
                    foreach ($this->normalizeFileList($receipt->receipt_file) as $path) {
                        $this->addPublicStorageFileToZip($zip, $path, 'accountability/item_receipts/receipts');
                    }
                }
            }

            $zip->close();

            if (!File::exists($zipPath) || filesize($zipPath) === 0) {
                throw new \Exception('ZIP file was not created properly or is empty.');
            }

            // Remove generated PDFs/folders but keep zip until sent.
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }

            return response()->download($zipPath, $zipFileName, [
                'Content-Type' => 'application/zip',
                'Content-Length' => filesize($zipPath),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Download Documents Error: ' . $e->getMessage(), [
                'requisition_id' => $id,
                'temp_dir' => $tempDir,
                'zip_path' => $zipPath,
                'trace' => $e->getTraceAsString(),
            ]);

            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            if ($zipPath && File::exists($zipPath)) {
                File::delete($zipPath);
            }

            return response()->json([
                'error' => 'Failed to generate documents package.',
            ], 500);
        }
    }

    private function normalizeFileList($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value));
        }

        if (is_string($value) && trim($value) !== '') {
            return [trim($value)];
        }

        return [];
    }

    private function addPublicStorageFileToZip(ZipArchive $zip, string $relativePath, string $zipDirectory): void
    {
        $cleanPath = ltrim($relativePath, '/\\');
        $fullPath = public_path('storage/' . $cleanPath);

        if (File::exists($fullPath) && is_readable($fullPath)) {
            $zip->addFile($fullPath, $zipDirectory . '/' . basename($fullPath));
        } else {
            Log::warning('File not found or unreadable for ZIP', [
                'relative_path' => $relativePath,
                'resolved_path' => $fullPath,
            ]);
        }
    }

    private function resolveConceptNotePath(Requisition $requisition): ?string
    {
        $conceptPath = $requisition->concept_note;

        if (!$conceptPath) {
            if ($requisition->program?->type == 2) {
                $existing = Requisition::where('outcome_id', $requisition->adminoutcome?->id)
                    ->whereNotNull('concept_note')
                    ->first();
                $conceptPath = $existing?->concept_note;
            } else {
                $existing = Requisition::where('activity_id', $requisition->activity?->id)
                    ->whereNotNull('concept_note')
                    ->first();
                $conceptPath = $existing?->concept_note;
            }
        }

        if (!$conceptPath) {
            return null;
        }

        return public_path('storage/' . ltrim($conceptPath, '/\\'));
    }

    private function applyFastPdfOptions($pdf): void
    {
        // Use print CSS and disable remote fetch for faster, more reliable generation.
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'defaultMediaType' => 'print',
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
            'isJavascriptEnabled' => false,
            'dpi' => 96,
            'defaultFont' => 'DejaVu Sans',
        ]);
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
        // $output->load('outcome.program');
        // $program = $output->outcome->program->first();

        // $MandE =  $program->activities->where('name', 'M and E')->pluck('name', 'id');

        $activities = $output->activities->pluck('name', 'id');

    //    $all_activities = $MandE->merge($activities);
    //    $all_activities = $MandE->concat($activities);

        return $activities;
    }
}