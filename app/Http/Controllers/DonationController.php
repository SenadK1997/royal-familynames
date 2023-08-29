<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familyname;
use App\Models\FamilynameSupport;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class DonationController extends Controller
{
    // FOR NEW REGISTRATION
    public function requestPayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $amount = $request->price;
        $amount = str_replace(',', '', $amount);
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success', [
                    'family_name' => $request->input('family_name'),
                    'country' => $request->input('country'),
                    'flag_url' => $request->input('flag_url')
                ]),
                "cancel_url" => route('payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        if (isset($response['id'])) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
            ->back()
            ->with('error', 'Something went wrong');
        } else {
            return redirect()
            ->back()
            ->with('error', $response['message'] ?? 'Something went wrong');
        }
    }
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $valuation = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $user = Auth::user();
            $familyName = ucwords($request->query('family_name'));
            $country = $request->query('country');
            $flag_url = $request->query('flag_url');
            $firstLetter = substr($familyName, 0, 1);
            $consonants = preg_replace('/[aeiou\d]/i', '', $familyName);
            if (preg_match('/[aeiou\d]/i', $firstLetter)) {
                $familyCodeName = $firstLetter . $consonants;
            } else {
                $familyCodeName = $firstLetter . substr($consonants, 1);
            }
            $randomNumber = mt_rand(100000, 999999);
            $familyCodeName .= $randomNumber;
            $family = new Familyname([
                'family_name' => $familyName,
                'country' => $country,
                'flag_url' => $flag_url,
                'valuation' => $valuation,
                'family_code' => $familyCodeName
            ]);
    
            $family->save();
            $user->price_paid += $valuation;
            $user->save();
            $user->familynames()->attach($family, ['supported_amount' => $valuation]);
            return redirect()->route('myAccount', ['account_id' => $user->account_id])->with('success', 'You successfully registered your family');
        } else {
            return redirect()
            ->back()
            ->with('error', 'Something went wrongs');
        }
    }
    public function paymentCancel()
    {
        return redirect()
        ->back()
        ->with('error', $response['message'] ?? 'You have canceled the transaction');
    }
    // FOR SUPPORT
    public function requestSupport(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $amount = $request->price;
        $amount = str_replace(',', '', $amount);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('support.success', [
                    'family_code' => $request->input('family_code'),
                ]),
                "cancel_url" => route('payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        if (isset($response['id'])) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
            ->back()
            ->with('error', 'Something went wrong');
        } else {
            return redirect()
            ->back()
            ->with('error', $response['message'] ?? 'Something went wrong');
        }
    }
    public function supportSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $user = Auth::user();
            $family_code = $request->query('family_code');
            $family = Familyname::where('family_code', $family_code)->firstOrFail();
            $existingSupport = FamilynameSupport::where('user_id', $user->id)
                ->where('familyname_id', $family->id)
                ->first();
            
            if ($existingSupport) {
                // Update the existing support amount
                $user->price_paid += $amount;
                $user->save();

                $existingSupport->support_amount += $amount;
                $existingSupport->save();

                $family->valuation += $amount;
                $family->save();
            } else {
                // Create a new support record
                $user->price_paid += $amount;
                $user->save();
                $family->valuation += $amount;
                $family->save();
        
                $newSupport = new FamilynameSupport([
                    'user_id' => $user->id,
                    'familyname_id' => $family->id,
                    'support_amount' => $amount
                ]);
                $newSupport->save();
            }
            
            // Update family's valuation and user's price_paid
            return redirect()->route('myAccount', ['account_id' => $user->account_id])
            ->with('success', 'Family supported successfully');
        } else {
            return redirect()
            ->back()
            ->with('error', 'Something went wrongs');
        }
    }
    // FOR EXISTING
    public function requestExisting(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $amount = $request->price;
        $amount = str_replace(',', '', $amount);
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('existing.success', [
                    'family_code' => $request->input('family_code'),
                ]),
                "cancel_url" => route('payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        if (isset($response['id'])) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
            ->back()
            ->with('error', 'Something went wrong');
        } else {
            return redirect()
            ->back()
            ->with('error', $response['message'] ?? 'Something went wrong');
        }
    }
    public function existingSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $user = Auth::user();
            $family_code = $request->query('family_code');
            $family = Familyname::where('family_code', $family_code)->firstOrFail();
            
            // Check if the user is already registered with the family
            if ($user->familynames->contains($family)) {
                // Update the valuation of the existing family registration
                $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $user->price_paid += $amount;
            
                // Get the pivot model for the user-family relationship
                $pivotModel = $user->familynames()->where('familyname_id', $family->id)->first()->pivot;
            
                // Update the supported_amount in the pivot model
                $existingSupportedAmount = $pivotModel->supported_amount ?? 0;
                $updatedSupportedAmount = $existingSupportedAmount + $amount;
                $pivotModel->supported_amount = $updatedSupportedAmount;
                $pivotModel->save();
            
                // Update the user and family models
                $user->save();
                $family->valuation += $amount;
                $family->save();
            
                return redirect()->route('myAccount', ['account_id' => $user->account_id])->with('success', 'Family supported successfully');
            } else {
                // If not registered, attach the family to the user
                $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $user->price_paid += $amount;
                $user->save();
                $family->valuation += $amount;
                $family->save();
                $user->familynames()->attach($family, ['supported_amount' => $amount]);
                return redirect()->route('myAccount', ['account_id' => $user->account_id]);
            }
        } else {
            return redirect()
            ->back()
            ->with('error', 'Something went wrong');
        }
    }
    // public function registerFamily(Request $request)
    // {
    //     $user = Auth::user();
    //     $familyName = ucwords($request->input('family_name'));
    //     $country = $request->input('country');
    //     $flag_url = $request->input('flag_url');
    //     $valuation = $request->input('amount');

    //     $firstLetter = substr($familyName, 0, 1);

    //     // Generate the consonants from the user's name
    //     $consonants = preg_replace('/[aeiou\d]/i', '', $familyName);
    //     // If the first letter is a vowel, remove it from the consonants
    //     if (preg_match('/[aeiou\d]/i', $firstLetter)) {
    //         $familyCodeName = $firstLetter . $consonants;
    //     } else {
    //         // If the first letter is a consonant, use it only once
    //         $familyCodeName = $firstLetter . substr($consonants, 1);
    //     }
    //     // Generate a random six-digit number
    //     $randomNumber = mt_rand(100000, 999999);

    //     // Append the random number to the familyCode ID
    //     $familyCodeName .= $randomNumber;

    //     $family = new Familyname([
    //         'family_name' => $familyName,
    //         'country' => $country,
    //         'flag_url' => $flag_url,
    //         'valuation' => $valuation,
    //         'family_code' => $familyCodeName
    //     ]);

    //     $family->save();
    //     $user->price_paid += $valuation;
    //     $user->save();
    //     $user->familynames()->attach($family, ['supported_amount' => $valuation]);
    //     return redirect()->route('myAccount', ['account_id' => $user->account_id]);
    // }
    // public function familyRegistrationExisting(Request $request)
    // {
    //     $user = Auth::user();
    //     $family_code = $request->input('family_code');
    //     $family = Familyname::where('family_code', $family_code)->firstOrFail();
        
    //     // Check if the user is already registered with the family
    //     if ($user->familynames->contains($family)) {
    //         // Update the valuation of the existing family registration
    //         $amount = $request->input('amount');
    //         $user->price_paid += $amount;
        
    //         // Get the pivot model for the user-family relationship
    //         $pivotModel = $user->familynames()->where('familyname_id', $family->id)->first()->pivot;
        
    //         // Update the supported_amount in the pivot model
    //         $existingSupportedAmount = $pivotModel->supported_amount ?? 0;
    //         $updatedSupportedAmount = $existingSupportedAmount + $amount;
    //         $pivotModel->supported_amount = $updatedSupportedAmount;
    //         $pivotModel->save();
        
    //         // Update the user and family models
    //         $user->save();
    //         $family->valuation += $amount;
    //         $family->save();
        
    //         return redirect()->route('myAccount', ['account_id' => $user->account_id])->with('success', 'Family supported successfully');
    //     } else {
    //         // If not registered, attach the family to the user
    //         $amount = $request->input('amount');
    //         $user->price_paid += $amount;
    //         $user->save();
    //         $family->valuation += $amount;
    //         $family->save();
    //         $user->familynames()->attach($family, ['supported_amount' => $amount]);
    //         return redirect()->route('myAccount', ['account_id' => $user->account_id]);
    //     }
    // }
    // public function supportFamily(Request $request)
    // {
    //     $user = Auth::user();
    //     $family_code = $request->input('family_code');
    //     $family = Familyname::where('family_code', $family_code)->firstOrFail();
    //     $amount = $request->input('amount');
    //     $existingSupport = FamilynameSupport::where('user_id', $user->id)
    //         ->where('familyname_id', $family->id)
    //         ->first();
        
    //     if ($existingSupport) {
    //         // Update the existing support amount
    //         $user->price_paid += $amount;
    //         $user->save();

    //         $existingSupport->support_amount += $amount;
    //         $existingSupport->save();

    //         $family->valuation += $amount;
    //         $family->save();
    //     } else {
    //         // Create a new support record
    //         $user->price_paid += $amount;
    //         $user->save();
    //         $family->valuation += $amount;
    //         $family->save();
    
    //         $newSupport = new FamilynameSupport([
    //             'user_id' => $user->id,
    //             'familyname_id' => $family->id,
    //             'support_amount' => $amount
    //         ]);
    //         $newSupport->save();
    //     }
        
    //     // Update family's valuation and user's price_paid
    //     return redirect()->route('myAccount', ['account_id' => $user->account_id])
    //     ->with('success', 'Family supported successfully');
    // }
}
