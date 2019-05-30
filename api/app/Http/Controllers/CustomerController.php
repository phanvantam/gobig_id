<?php

namespace App\Http\Controllers;

use App\Repositories\ScriptRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $script;
    protected $customer;
    protected $request;

    public function __construct(
        ScriptRepositoryInterface $script,
        CustomerRepositoryInterface $customer,
        Request $request
    ) {
        $this->script = $script;
        $this->customer = $customer;
        $this->request = $request;
    }

    public function index()
    {

        $name = [
            'key_name' => $this->request->input('key_name','')
        ];
        $result = $this->customer->getByFilter(1, $name);
        $pageCustomer = [
            'customer'=> $result->all(),
            'paginate'=> [
                'total_page' => ceil($result->total()/$result->perPage()),
                'current_page' => $result->currentPage(),
            ]
        ];


        return $this->response($pageCustomer);
    }
    //
}
