<?php
namespace App\Http\Controllers\Admin\CRM;
use App\Services\CRM\MembershipTierService;
use App\Http\Requests\Admin\CRM\MembershipTierRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class MembershipTierController extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.crm.membership-tiers.index', [
            'title' => 'Danh Sách MembershipTier'
        ]);
    }
}
