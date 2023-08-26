<?php

namespace App\Http\Controllers;

use App\Models\Familyname;
use App\Models\FamilynameSupport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function homepage(Request $request)
    {
        $searchQuery = $request->input('query');
        
        $familynames = Familyname::when($searchQuery, function ($query) use ($searchQuery) {
            return $query->where('family_name', 'like', '%' . $searchQuery . '%');
        })
        ->orderBy('valuation', 'desc')
        ->paginate(10);
    
        $ranking = ($familynames->currentPage() - 1) * $familynames->perPage() + 1;
    
        return view('LandingPage', compact('familynames', 'ranking', 'searchQuery'));
    }
    public function showAbout()
    {
        return view('about');
    }
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

        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'Email already in use');
            // return response()->json(['message' => 'Email is already registered']);
        }
        // Create and save the user to the database
        $user = new User([
            'name' => $name,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'account_id' => $accountName, // Set the "Account ID"
        ]);

        $user->save();
        // return redirect()->route('myAccount', ['account_id' => $accountName]);
        $request->session()->flush();
        return redirect()->route('login');
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
        $families = Familyname::all();
        try {
            $user = User::where('account_id', $account_id)->firstOrFail();

            
            $userSupported = $user->getSupportedFamily;

            // $userFamily = $user->familynames->first();
            // $rank = null;
            // $secondFamilyRank = null;
            // $attachedFamilyCount = $user->familynames->count();

            // if ($userFamily) {
            //     // Sve familije sortirane od najvece valuation
            //     $sortedFamilynames = Familyname::orderBy('valuation', 'desc')->get();
                
            //     // User rank of prve family id
            //     $userRank = $sortedFamilynames->search(function ($family) use ($userFamily) {
            //         return $family->id === $userFamily->id;
            //     });
                
            //     if ($userRank !== false) {
            //         $rank = $userRank + 1;
            //     }
            // }
            // Sve familije attachane za usera
            $userAttachedFamilies = $user->familynames;
            $sortedFamilynames = Familyname::orderBy('valuation', 'desc')->get();
            $rank = null;
            $secondFamilyRank = null;

            if ($userAttachedFamilies->count() > 1) {
                // User has more than one attached family
                $userFamily = $userAttachedFamilies->skip(1)->first(); // Get the first family
                $secondFamily = $userAttachedFamilies->first(); // Get the second family

                $userRank = $sortedFamilynames->search(function ($family) use ($userFamily) {
                    return $family->id === $userFamily->id;
                });

                if ($userRank !== false) {
                    $rank = $userRank + 1; // Adding 1 to make it human-readable rank
                }

                $secondFamilyRank = $sortedFamilynames->search(function ($family) use ($secondFamily) {
                    return $family->id === $secondFamily->id;
                });

                if ($secondFamilyRank !== false) {
                    $secondFamilyRank += 1; // Adding 1 to make it human-readable rank
                }
            } else if ($userAttachedFamilies->count() === 1) {
                // User has only one attached family
                $userFamily = $userAttachedFamilies->first();

                $userRank = $sortedFamilynames->search(function ($family) use ($userFamily) {
                    return $family->id === $userFamily->id;
                });

                if ($userRank !== false) {
                    $rank = $userRank + 1; // Adding 1 to make it human-readable rank
                }
            }
            $numberOfUsersFirstFamily = 0;
            $numberOfUsersSecondFamily = 0;
            foreach ($userAttachedFamilies as $family) {
                $usersCount = $family->users->count();
                
                if ($family->id === $userFamily->id) {
                    $numberOfUsersFirstFamily = $usersCount;
                } else {
                    $numberOfUsersSecondFamily = $usersCount;
                }
            }





            // if ($userFamily) {
            //     // Sve familije sortirane od najvece valuation
            //     $sortedFamilynames = Familyname::orderBy('valuation', 'desc')->get();
            //     // User rank of prve family id
            //     $userRank = $sortedFamilynames->search(function ($family) use ($userFamily) {
            //         return $family->id === $userFamily->id;
            //     });
            //     if ($userRank !== false) {
            //         $rank = $userRank + 1;
            //     }
            // }
            // // Sve familije attachane za usera
            // $userAttachedFamilies = $user->familynames;
            // // Broj Pripadnika familije
            // $numberOfUsersFirstFamily = 0;
            // $numberOfUsersSecondFamily = 0;
            // foreach ($userAttachedFamilies as $family) {
            //     // Racunanje korisnika za familiju
            //     $usersCount = $family->users->count();
                
            //     if ($family->id === $userFamily->id) {
            //         $numberOfUsersFirstFamily = $usersCount;
            //     } else {
            //         $numberOfUsersSecondFamily += $usersCount;
            //     }
            // }

            // // If the user has more than one attached family, calculate the rank for the second family
            // if ($userAttachedFamilies->count() > 1) {
            //     $secondFamily = $userAttachedFamilies->skip(1)->first();
            //     $secondFamilyRank = $sortedFamilynames->search(function ($family) use ($secondFamily) {
            //         return $family->id === $secondFamily->id;
            //     });
                
            //     if ($secondFamilyRank !== false) {
            //         $secondFamilyRank += 1; // Adding 1 to make it human-readable rank
            //     }
            // }
        
            return view('MyAccount', [
                'account_id' => $account_id,
                'rank' => $rank,
                'numberOfUsersFirstFamily' => $numberOfUsersFirstFamily,
                'numberOfUsersSecondFamily' => $numberOfUsersSecondFamily,
                'secondFamilyRank' => $secondFamilyRank,
                'userSupported' => $userSupported
            ], compact('families', 'user', 'userAttachedFamilies'));
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

    public function showFamilyPage($family_code)
    {
        try {
            $family = Familyname::where('family_code', $family_code)->firstOrFail();
            $users = $family->users->sortByDesc(function($user) {
                return $user->pivot->supported_amount;
            });
            $supporters = $family->supporters->sortByDesc(function($supporter) {
                return $supporter->pivot->support_amount;
            });
            return view('family/family-info', ['family_code' => $family_code], compact('family', 'users', 'supporters'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('not_found'); // Redirect to a custom 404 page or handle the error in some other way.
        }
    }
    public function registerExistingFamily($family_code)
    {
        try {
            $family = Familyname::where('family_code', $family_code)->firstOrFail();
            return view('family/register-existing', ['family_code' => $family_code], compact('family'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('not_found'); // Redirect to a custom 404 page or handle the error in some other way.
        }
    }
    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();
        if($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = uniqid() . '_' . $avatar->getClientOriginalName();
            $userAvatar = Image::make($avatar)->fit(150, 150);
            $userAvatar->save(storage_path('app/public/images/' . $avatarName), 100);
            $user->avatar = $avatarName;
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile picture updated successfully');
    }
    public function uploadSocialMedia(Request $request)
    {
        $user = Auth::user();
        $domain = 'http://';
        $website_url = $request->input('website');
        $instagram_url = $request->input('instagram');
        $linkedin_url = $request->input('linkedin');
        $twitter_url = $request->input('twitter');
        $tiktok_url = $request->input('tiktok');
        if ($website_url) {
            $user->website_url = $domain . $website_url;
        }
        if ($instagram_url) {
            $user->instagram_url = $domain . $instagram_url;
        }
        if ($linkedin_url) {
            $user->linkedin_url = $domain . $linkedin_url;
        }
        if ($twitter_url) {
            $user->twitter_url = $domain . $twitter_url;
        }
        if ($tiktok_url) {
            $user->tiktok_url = $domain . $tiktok_url;
        }
        
        $user->save();

        return redirect()->back()->with('success', 'Social media links updated successfully');
    }
    public function uploadQuote(Request $request)
    {
        $user = Auth::user();
        $quote = $request->input('quote');

        $user->quote = $quote;

        $user->save();

        return redirect()->back()->with('success', 'Quote updated successfully');
    }
    public function showSupportFamily(Request $request, $family_code)
    {
        $family = Familyname::where('family_code', $family_code)->firstOrFail();
        return view('support-family', compact('family'));
    }

    public function getUserQuote($userId)
    {
        $user = User::where('id', $userId)->firstOrFail();

        if ($user) {
            return response()->json([
                'quote' => $user->quote,
                'avatar' => $user->avatar,
                'name' => $user->name
            ]);
        } else {
            return response()->json(['quote' => 'User not found']);
        }
    }
}