<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class CheckListAudit extends Model
{
	protected $table = 'checklist_audits';

	protected $fillable = [
    	'branch_id', 'list_id', 'checklist', 'comment', 'image', 'date'
    ];

    protected $primaryKey = 'id';
}
