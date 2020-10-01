<?php

namespace App\Http\Controllers;

use App\Services\CustomersDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;

/**
 * Class CustomersController
 *
 * @package App\Http\Controllers
 */
class CustomersController extends Controller
{
    /**
     * @var CustomersDataService $customersService
     */
    protected $customersService;

    /**
     * CustomersController constructor.
     *
     * @param CustomersDataService $customersService
     */
    public function __construct(CustomersDataService $customersService)
    {
        $this->customersService = $customersService;
    }

    /**
     * Show list of customers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $queryParams = $request->all();
        $customers = $this->customersService->getPaginatedList($queryParams);

        $message = isset($customers['data']) ? 'Success' : 'Empty list';
        $code = isset($customers['data']) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        $response = array_merge([
            'message' => $message
        ], $customers);

        return response()->json($response, $code);
    }

    /**
     * Show customer details
     *
     * @param int $customerId
     * @return JsonResponse
     */
    public function show(int $customerId)
    {
        $customer = $this->customersService->getDetails($customerId);

        $message = isset($customer['data']) ? 'Success' : 'Customer not found';
        $code = isset($customer['data']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        $response = array_merge([
            'message' => $message
        ], $customer);

        return response()->json($response, $code);
    }

    /**
     * Import customers from API provider
     */
    public function import()
    {
        $this->customersService->import();

        return response()->json([
            'message' => 'Import ongoing...'
        ], 200);
    }
}
