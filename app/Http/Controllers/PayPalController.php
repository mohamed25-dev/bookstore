<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PayPalController extends Controller
{

    public function createPayment($id)
    {
        $clientId = "AexXm3q3WdlRb-SDY7GfS2i-ntwQKE5DivMW_TfpOGfL--p8nu8U5OecMsf6yIIZL70fWgKUFF_1zDd6";
        $clientSecret = "EF0roQrlzLMzgu2AUVhFEw89ulZzNUg12FcoU1EDDYfMWYs79m6NB__n36c9FokPZjg3hCQXphYoI2kv";
        $baseUrl = url('/');

        $items = [];
        $total = 0;

        $books = User::find($id)->booksInCart;
        
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->headers["PayPal-Partner-Attribution-Id"] = "PARTNER_ID_ASSIGNED_BY_YOUR_PARTNER_MANAGER";

        foreach ($books as $book) {
            $item = array();
            $item['name'] = $book->title;
            $item['quantity'] = $book->pivot->number_of_copies;
            $item['unit_amount'] = array();
            $item['unit_amount']['currency_code'] = 'USD';
            $item['unit_amount']['value'] = $book->price;

            $total += $book->price * $book->pivot->number_of_copies;
            $items[] = $item;
        }

        $applicationContext = array(
            'brand_name' => 'مكتبتي',
            'locale' => 'en-US',
            'user_action' => 'PAY_NOW',
            "cancel_url" => "$baseUrl/cart",
            "return_url" => "$baseUrl/cart"
        );

        $request->body = array(
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    'reference_id' => 'reference_id',
                    'description' => 'BOOKS',
                    'custom_id' => 'Maktabaty-Books',
                    // 'soft_descriptor' => 'Maktabaty',
                    'amount' =>
                    array(
                        'currency_code' => 'USD',
                        'value' => $total,
                        'breakdown' =>
                        array(
                            'item_total' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => $total,
                            ),
                        ),
                    ),
                    'items' => $items
                ],
            ],
            "application_context" => $applicationContext
        );

        try {

            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            $user = User::find($id);
            $books = $user->booksInCart;
            foreach($books as $book) {
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE]);
                $book->save();
            } 

            echo json_encode($response->result);
            // return $response->result

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function executePayment(Request $request, $id)
    {
        $clientId = "AexXm3q3WdlRb-SDY7GfS2i-ntwQKE5DivMW_TfpOGfL--p8nu8U5OecMsf6yIIZL70fWgKUFF_1zDd6";
        $clientSecret = "EF0roQrlzLMzgu2AUVhFEw89ulZzNUg12FcoU1EDDYfMWYs79m6NB__n36c9FokPZjg3hCQXphYoI2kv";

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        $request = new OrdersCaptureRequest($id);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            echo json_encode($response->result);

        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}
