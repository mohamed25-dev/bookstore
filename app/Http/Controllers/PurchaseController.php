<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use Illuminate\Http\Request;

use PayPal\Api\PaymentExecution;


class PurchaseController extends Controller
{
    public function createPayment(Request $request) 
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AexXm3q3WdlRb-SDY7GfS2i-ntwQKE5DivMW_TfpOGfL--p8nu8U5OecMsf6yIIZL70fWgKUFF_1zDd6', 
                'EF0roQrlzLMzgu2AUVhFEw89ulZzNUg12FcoU1EDDYfMWYs79m6NB__n36c9FokPZjg3hCQXphYoI2kv')
        );

        $shipping = 0;
        $tax = 0;
    
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
    
        $books = User::find($request->userId)->booksInCart;
        $itemsArray = array();
        $total = 0;
        foreach($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
            
            $item = new Item();
            $item->setName($book->title)
            ->setCurrency('USD')
            ->setQuantity($book->pivot->number_of_copies)
            ->setSku($book->id) // Similar to `item_number` in Classic API
            ->setPrice($book->price);
            
            array_push($itemsArray, $item);
        }

        $itemList = new ItemList();
        $itemList->setItems($itemsArray);
    
        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($total);
    
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total + $tax + $shipping)
            ->setDetails($details);
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
    
        $baseUrl = url('/');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/cart")
            ->setCancelUrl("$baseUrl/cart");
    
        $payment = new Payment();
        $payment->setIntent("payer")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
    
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            echo $ex;
            exit(1);
        }
        $approvalUrl = $payment->getApprovalLink();
        return $payment; 
    }

    public function executePayment(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AexXm3q3WdlRb-SDY7GfS2i-ntwQKE5DivMW_TfpOGfL--p8nu8U5OecMsf6yIIZL70fWgKUFF_1zDd6', 
                'EF0roQrlzLMzgu2AUVhFEw89ulZzNUg12FcoU1EDDYfMWYs79m6NB__n36c9FokPZjg3hCQXphYoI2kv')
        );
    
        $paymentId = $request->paymentID;
        $payment = Payment::get($paymentId, $apiContext);
    
        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->payerID);
        
        // $transaction = new Transaction();
        // $amount = new Amount();
        // $details = new Details();
    
        // $details->setShipping(2.2)
        //     ->setTax(1.3)
        //     ->setSubtotal(17.50);
    
        // $amount->setCurrency('USD');
        // $amount->setTotal(21);
        // $amount->setDetails($details);
        // $transaction->setAmount($amount);

        // $execution->addTransaction($transaction);
        try {
            $result = $payment->execute($execution, $apiContext);  
            $user = User::find($request->userId);
            $books = $user->booksInCart;
            foreach($books as $book) {
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE]);
                $book->save();
            }          
        } catch (Exception $ex) {
            echo $ex;
        }
    
        return $result;
    }
}
