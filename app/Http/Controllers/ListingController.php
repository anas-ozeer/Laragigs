<?php

namespace App\Http\Controllers;
use Log;
use App\Models\Listing;
use App\View\Components\listing as ComponentsListing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index',[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(5)
        ]);
    }

    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email'=> ['required', 'email'],
            'website' => 'required',
            'tags'=> 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formField['logo'] = $request['logo']->store('logos', 'public');
        }

        if (!auth()->check()) {
            return redirect('/login')->with('error', 'You must be logged in to create a listing.');
        }

        $formField['user_id']=auth()->id();


        Listing::create($formField);

        return redirect('/');
    }

    public function edit(Listing $listing) {

        if (auth()->user()->id != $listing['user_id']) {
            abort(403);
        }
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    public function update(Request $request, Listing $listing) {
        $formField = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email'=> ['required', 'email'],
            'website' => 'required',
            'tags'=> 'required',
            'description' => 'required',
            'logo' => 'image'
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request['logo']->store('logos', 'public');
        }


        $listing->update($formField);

        return redirect('/');
    }

    public function destroy(Listing $listing)
    {

        if (auth()->user()->id != $listing['user_id']) {
            abort(403);
        }
        // Check if the listing exists
        if ($listing) {
            // Delete the listing
            $listing->delete();

            // Redirect to the home page with a success message
            return redirect('/')->with('success', 'Listing deleted successfully.');
        }

        // If the listing does not exist, redirect with an error message
        return redirect('/')->with('error', 'Listing not found.');
    }

    public function manage() {
        return view('listings.manage',['listings'=> auth()->user()->listings()->get()]);
    }

}
