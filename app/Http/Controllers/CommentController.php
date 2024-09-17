<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Staff;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use App\Models\Requisition;

class CommentController extends Controller
{
    // In CommentController.php
    public function store(Request $request)
    {
        $logged_in_user = Admin::user();

        $commented_by = Staff::where('user_id', $logged_in_user->id)->first()->id;
        $validated = $request->validate([
            'action' => 'required|string',
            'reason' => 'required|string',
            'requisition_id' => 'required|integer'
        ]);
    
        // Store the data
        Comments::create([
            'status' => $validated['action'],
            'comment' => $validated['reason'],
            'requisition_id' => $validated['requisition_id'],
            'commented_by' => $commented_by
        ]);

        //update the requisition status based on the action
        $requisition = Requisition::find($validated['requisition_id']);
        $requisition->status = $validated['action'];
        $requisition->save();
    
        return response()->json(['success' => true]);
    }
    
}
