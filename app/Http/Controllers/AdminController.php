<?php

namespace App\Http\Controllers;

use App\Models\Familyname;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration form submission
    public function register(Request $request)
    {
        // Get the user's name from the input
        $name = $request->input('name');

        // Extract the first letter of the user's name
        $firstLetter = substr($name, 0, 1);

        // Generate the consonants from the user's name
        $consonants = preg_replace('/[aeiou\d]/i', '', $name);

        // If the first letter is a vowel, remove it from the consonants
        if (preg_match('/[aeiou\d]/i', $firstLetter)) {
            $accountName = $firstLetter . $consonants;
        } else {
            // If the first letter is a consonant, use it only once
            $accountName = $firstLetter . substr($consonants, 1);
        }

        // Generate a random six-digit number
        $randomNumber = mt_rand(100000, 999999);

        // Append the random number to the account ID
        $accountName .= $randomNumber;

        // Create and save the user to the database
        $user = new User([
            'name' => $name,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'account_id' => $accountName, // Set the "Account ID"
        ]);

        $user->save();
        return redirect()->route('myAccount', ['account_id' => $accountName]);
    }


    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login form submission
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            return redirect()->route('myAccount', ['account_id' => $user->account_id]);
        } 
        return redirect()->route('login')
        ->withErrors(['email' => 'Invalid username or password'])
        ->withInput($request->except('password'));
    }

    // Handle user logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
    public function myAccount($account_id)
    {
        try {
            $user = User::where('account_id', $account_id)->firstOrFail();
            return view('MyAccount', ['account_id' => $account_id]);
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('not_found'); // Redirect to a custom 404 page or handle the error in some other way.
        }
    }
    public function showRegisterFamily()
    {
        $apiUrl = 'https://restcountries.com/v3.1/all';
        $response = Http::get($apiUrl);
        $countriesData = $response->json();
        
        $countries = [];
        foreach ($countriesData as $country) {
            $name = $country['name']['common'];
            $countries[$name] = $name;
        }
        return view('family.register', compact('countries'));
    }
    public function registerFamily(Request $request)
    {
        $user = Auth::user();
        if ($user->familynames()->count() >= 2) {
            return redirect()->back()->with('error', 'You can only register a maximum of 2 family names.');
        }
        $familyName = $request->input('family_name');
        $country = $request->input('country');
        $flag_url = $request->input('flag_url');
        $valuation = $request->input('valuation');

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
        $user->familynames()->attach($family);
        return redirect()->route('myAccount', ['account_id' => $user->account_id]);
    }

    public function showFamilyPage($family_code)
    {
        try {
            $family = Familyname::where('family_code', $family_code)->firstOrFail();
            return view('family/family-info', ['family_code' => $family_code], compact('family'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('not_found'); // Redirect to a custom 404 page or handle the error in some other way.
        }
    }
}