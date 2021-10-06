<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

class PurchaseController extends Controller
{
    public function redirectToCheckout()
    {
        $priceId = 'price_1JhJUJHcBcdIHl3NsXYetfTS';
        $callbackUrl = route('checkout.callback') . '?session_id={CHECKOUT_SESSION_ID}';
        $checkoutSession = \Stripe\Checkout\Session::create([
            'customer_email' => Auth::user()->email,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'success_url' => $callbackUrl,
            'cancel_url' => $callbackUrl,
        ]);

        return redirect($checkoutSession->url);
    }

    public function callback()
    {
        $checkoutSession = \Stripe\Checkout\Session::retrieve(request('session_id'));

        if ($checkoutSession->payment_status === 'paid') {
            $user = Auth::user();
            $user->has_bought = true;
            $user->save();

            return redirect('/')->with('success', 'Obrigado por comprar! O livro já está disponível para download abaixo.');
        } else {
            return redirect('/')->with('error', 'Não foi possível concluir o pagamento.');
        }
    }
}
