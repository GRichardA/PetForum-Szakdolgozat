<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle uploaded avatar
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            try {
                // Create a local Image Manager instance using the correct static constructors
                $manager = extension_loaded('imagick') ? ImageManager::imagick() : ImageManager::gd();

                // Try to use Intervention API if available
                $imageObj = $manager->read($file);

                if (method_exists($imageObj, 'fit')) {
                    // Use Intervention to resize and encode
                    $image = $imageObj->fit(400, 400, function ($constraint) {
                        $constraint->upsize();
                    })->encode('png', 90);

                    $contents = (string) $image;
                } else {
                    // Fallback to GD-based processing if fluent 'fit' is not available
                    $contents = $this->processAvatarWithGd($file->getPathname());
                }

                $filename = 'avatars/' . uniqid('avatar_') . '.png';
                Storage::disk('public')->put($filename, $contents);

                // delete old uploaded avatar if existed
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $data['avatar'] = $filename;
                $data['avatar_choice'] = null;
            } catch (\Throwable $e) {
                Log::error('Avatar processing failed: '. $e->getMessage(), ['exception' => $e, 'userId' => $user->id]);
                return back()->withErrors(['avatar' => 'A kép feldolgozása sikertelen volt. Kérlek próbáld újra.']);
            }
        } elseif ($request->filled('avatar_choice')) {
            // User selected a default avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = null;
            $data['avatar_choice'] = $request->avatar_choice;
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profilod frissítve.');
    }

    /**
     * Process image with plain GD functions: crop center square and resize to 400x400 PNG.
     * Returns binary PNG string.
     *
     * @param string $path
     * @return string
     */
    private function processAvatarWithGd(string $path): string
    {
        if (!file_exists($path)) {
            throw new \RuntimeException('Uploaded file not found: ' . $path);
        }

        $info = getimagesize($path);
        if ($info === false) {
            throw new \RuntimeException('Could not read image info.');
        }

        $mime = $info['mime'] ?? '';
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $src = imagecreatefrompng($path);
                break;
            case 'image/gif':
                $src = imagecreatefromgif($path);
                break;
            default:
                throw new \RuntimeException('Unsupported image type: ' . $mime);
        }

        if (!$src) {
            throw new \RuntimeException('Failed to create image resource from file.');
        }

        $width = imagesx($src);
        $height = imagesy($src);
        $size = min($width, $height);

        $src_x = (int) floor(($width - $size) / 2);
        $src_y = (int) floor(($height - $size) / 2);

        $dst = imagecreatetruecolor(400, 400);

        // preserve transparency for PNG/GIF
        if (in_array($mime, ['image/png', 'image/gif'], true)) {
            imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        $resampled = imagecopyresampled(
            $dst,
            $src,
            0, 0,
            $src_x, $src_y,
            400, 400,
            $size, $size
        );

        if (!$resampled) {
            imagedestroy($src);
            imagedestroy($dst);
            throw new \RuntimeException('Resampling image failed.');
        }

        ob_start();
        imagepng($dst, null, 9);
        $contents = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        if ($contents === false) {
            throw new \RuntimeException('Failed to encode PNG.');
        }

        return $contents;
    }
}
