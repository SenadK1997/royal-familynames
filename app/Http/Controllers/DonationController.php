<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;
use App\Models\Familyname;
use App\Models\FamilynameSupport;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function registerFamily(Request $request)
    {
        $user = Auth::user();
        $familyName = $request->input('family_name');
        $country = $request->input('country');
        $flag_url = $request->input('flag_url');
        $valuation = $request->input('amount');

        $firstLetter = substr($familyName, 0, 1);

        // Generate the consonants from the user's name
        $consonants = preg_replace('/[aeiou\d]/i', '', $familyName);
        // If the first letter is a vowel, remove it from the consonants
        if (preg_match('/[aeiou\d]/i', $firstLetter)) {
            $familyCodeName = $firstLetter . $consonants;
        } else {
            // If the first letter is a consonant, use it only once
            $familyCodeName = $firstLetter . substr($consonants, 1);
        }
        // Generate a random six-digit number
        $randomNumber = mt_rand(100000, 999999);

        // Append the random number to the familyCode ID
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
        return redirect()->route('myAccount', ['account_id' => $user->account_id]);
    }
    public function familyRegistrationExisting(Request $request)
    {
        $user = Auth::user();
        $family_code = $request->input('family_code');
        $family = Familyname::where('family_code', $family_code)->firstOrFail();
        
        // Check if the user is already registered with the family
        if ($user->familynames->contains($family)) {
            // Update the valuation of the existing family registration
            $amount = $request->input('amount');
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
            $amount = $request->input('amount');
            $user->price_paid += $amount;
            $user->save();
            $family->valuation += $amount;
            $family->save();
            $user->familynames()->attach($family, ['supported_amount' => $amount]);
            return redirect()->route('myAccount', ['account_id' => $user->account_id]);
        }
    }
    public function supportFamily(Request $request)
    {
        $user = Auth::user();
        $family_code = $request->input('family_code');
        $family = Familyname::where('family_code', $family_code)->firstOrFail();
        $amount = $request->input('amount');
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
    }
}
