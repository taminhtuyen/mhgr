<?php

namespace App\Http\Controllers\Admin\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CRM\CustomerRequest;
use App\Services\CRM\CustomerService;
use App\Http\Traits\HasTableSchema;
use Illuminate\Http\Request;
use Exception;

class CustomerController extends Controller
{
    use HasTableSchema;

    protected $service;

    /**
     * Inject CustomerService vào Controller
     */
    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    /**
     * Hiển thị danh sách khách hàng
     */
    public function index()
    {
        // Gọi Service để lấy dữ liệu (đã phân trang)
        // Lưu ý: Bạn cần viết hàm paginate() trong CustomerService
        $customers = $this->service->paginate(20);

        return view('admin.crm.customers.index', [
            'title' => 'Quản Lý Khách Hàng',
            'customers' => $customers
        ]);
    }

    /**
     * Hiển thị Form thêm mới
     */
    public function create()
    {
        return view('admin.crm.customers.create', [
            'title' => 'Thêm Mới Khách Hàng'
        ]);
    }

    /**
     * Xử lý lưu khách hàng mới
     */
    public function store(CustomerRequest $request)
    {
        try {
            // Dữ liệu đã được validate sạch sẽ bởi CustomerRequest
            $this->service->create($request->validated());

            return redirect()
                ->route('admin.crm.customers.index')
                ->with('success', 'Thêm mới khách hàng thành công!');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị Form chỉnh sửa
     */
    public function edit($id)
    {
        try {
            $customer = $this->service->find($id);

            return view('admin.crm.customers.edit', [
                'title' => 'Chỉnh Sửa Khách Hàng: ' . $customer->name,
                'customer' => $customer
            ]);

        } catch (Exception $e) {
            return redirect()
                ->route('admin.crm.customers.index')
                ->with('error', 'Không tìm thấy khách hàng yêu cầu.');
        }
    }

    /**
     * Xử lý cập nhật thông tin
     */
    public function update(CustomerRequest $request, $id)
    {
        try {
            $this->service->update($id, $request->validated());

            return redirect()
                ->route('admin.crm.customers.index')
                ->with('success', 'Cập nhật thông tin thành công!');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    /**
     * Xóa khách hàng (Soft delete)
     */
    public function destroy($id)
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->route('admin.crm.customers.index')
                ->with('success', 'Đã xóa khách hàng thành công.');

        } catch (Exception $e) {
            return redirect()
                ->route('admin.crm.customers.index')
                ->with('error', 'Không thể xóa: ' . $e->getMessage());
        }
    }
}
