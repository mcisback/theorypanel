<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\ImageDataUri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'avatar' => ['required', 'string', new ImageDataUri]
            ]);

            // Check if it is already hashed
            if(preg_match('/^\$2[ay]\$\d{2}\$/', $validated['password'])) {
                unset($validated['password']);
            }

            $manager = new ImageManager(new Driver());

            $image = $manager->read($validated['avatar'], [
                DataUriImageDecoder::class,
            ]);

            $image->resize(100, 100);

            $validated['avatar'] = $image->toPng()->toDataUri();

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => __('Profilo aggiornato correttamente'),
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __($e->getMessage()),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
