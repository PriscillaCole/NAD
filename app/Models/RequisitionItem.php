<?php

namespace App\Models;

use App\Admin\Controllers\RequisitionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'budget_line_id',
        'admin_budget_line_id',
        'quantity',
        'unit_price',
        'unit_of_measure',
        'frequency',
        'total_price',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function budgetline()
    {
        return $this->belongsTo(BudgetLines::class, 'budget_line_id');
    }

    public function adminbudgetline()
    {
        return $this->belongsTo(AdminBudget_lines::class, 'admin_budget_line_id');
    }

      //relationship with activity receipts
      public function requisitionItemReceipts()
      {
          return $this->hasMany(RequisitionItemReceipt::class);
      }
 
}
