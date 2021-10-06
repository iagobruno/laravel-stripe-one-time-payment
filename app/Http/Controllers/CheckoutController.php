<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Stripe\Checkout\Session as CheckoutSession;

class CheckoutController extends Controller
{
    public function redirect()
    {
        $priceId = 'price_1JhJUJHcBcdIHl3NsXYetfTS';

        $checkoutSession = CheckoutSession::create([
            'customer_email' => Auth::user()->email,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'success_url' => route('checkout.callback') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.callback') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        return redirect($checkoutSession->url);
    }

    public function callback()
    {
        $checkoutSession = CheckoutSession::retrieve(request('session_id'));

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
