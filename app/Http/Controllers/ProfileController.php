<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        $user->bio = $request->input('bio');
        $user->lokasi = $request->input('lokasi');

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            // --- PERUBAHAN: Menggunakan GD Library untuk resize gambar ---
            $this->resizeImage($path, 300, 300);

            $user->avatar_path = $path;
        }

        $user->save();

        if ($request->has('genres')) {
            $user->genres()->sync($request->input('genres'));
        } else {
            $user->genres()->detach();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Fungsi helper untuk me-resize gambar menggunakan GD Library.
     *
     * @param string $path Path file relatif terhadap storage/app/public.
     * @param int $width Lebar target.
     * @param int $height Tinggi target.
     */
    private function resizeImage(string $path, int $width, int $height): void
    {
        $fullPath = storage_path("app/public/{$path}");

        // Dapatkan informasi gambar
        [$originalWidth, $originalHeight, $imageType] = getimagesize($fullPath);

        // Buat gambar sumber berdasarkan tipe file
        $sourceImage = match ($imageType) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG => imagecreatefrompng($fullPath),
            IMAGETYPE_GIF => imagecreatefromgif($fullPath),
            default => null,
        };

        if ($sourceImage === null) {
            return; // Lewati jika format tidak didukung
        }

        // Buat kanvas tujuan
        $destinationImage = imagecreatetruecolor($width, $height);

        // Menjaga transparansi untuk PNG
        if ($imageType === IMAGETYPE_PNG) {
            imagealphablending($destinationImage, false);
            imagesavealpha($destinationImage, true);
            $transparent = imagecolorallocatealpha($destinationImage, 255, 255, 255, 127);
            imagefilledrectangle($destinationImage, 0, 0, $width, $height, $transparent);
        }

        // Salin dan resize gambar
        imagecopyresampled(
            $destinationImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $originalWidth,
            $originalHeight
        );

        // Simpan gambar yang sudah di-resize ke path yang sama
        match ($imageType) {
            IMAGETYPE_JPEG => imagejpeg($destinationImage, $fullPath),
            IMAGETYPE_PNG => imagepng($destinationImage, $fullPath),
            IMAGETYPE_GIF => imagegif($destinationImage, $fullPath),
        };

        // Bebaskan memori
        imagedestroy($sourceImage);
        imagedestroy($destinationImage);
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
