<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function destroy($id)
    {
        $user = User::find($id);

        // Cek relasi dengan customer
        if (Customer::where('id_user', $user->id)->exists()) {
            return redirect()->back()->withErrors([
                'errors' => 'Data gagal dihapus, data masih memiliki relasi.'
            ]);
        }

        // Hapus foto jika ada
        if ($user->photo) {
            $path = public_path('images/users/' . $user->photo);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
