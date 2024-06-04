<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\favorit;
use App\Models\ratings;
use App\Models\rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BukuControrller extends Controller
{
    function buku_all(){
        $buku = Buku::all();
        if($buku){
            return response()->json($buku, 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function buku_info($id){
        $buku = Buku::where('id',$id)->get();
        if($buku){
            return response()->json($buku, 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function ratings_all(){
        $rating = ratings::all();
        if($rating){
            return response()->json($rating, 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function ratings_info($id){
        $rating = ratings::where('buku_id', $id)->get();
        if($rating){
            return response()->json($rating, 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function ratings_avg($id){
        $rating = ratings::where('buku_id', $id)->avg('ratings');
        $rating_info = ratings::where('buku_id', $id)->first();
        if($rating){
            return response()->json([
                "buku_id" => $rating_info->buku_id,
                "avg" => $rating,
            ], 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function rental_all(){
        $rental = rental::all();
        if($rental){
            return response()->json($rental, 200);
        }else{
            return response()->json(['Error' => 'gak konek lekkk']);
        }
    }

    function rental_req(Request $request){
        $user_id = $request->user_id;
        $book_id = $request->book_id;
        $rental_date = $request->rental_date;
        $rental_deadline = $request->rental_deadline;
        $qty = $request->qty;
        $alamat = $request->alamat;

        $rental = rental::create([
            'user_id' => $user_id,
            'rental_book_id' => $book_id,
            'rental_date' => $rental_date,
            'rental_deadline' => $rental_deadline,
            'qty' => $qty,
            'condition_role' => 0,
            'denda' => 0,
            'status' => 0,
            'alamat' => $alamat,
        ]);

        if($rental){
            return response()->json(['succes' => 'Buku Dipinjam'], 200);
        }else{
            return response()->json(['Error' => 'Gagal meminjam buku'], 401);
        }
    }

    function upload_file(Request $request){
        try {
            $media = base64_decode($request->input('media'));
            if ($media === false) {
                Log::error('Base64 decode failed');
                return response()->json(['error' => 'Invalid base64 string'], 400);
            }
    
            $filename = $request->input('filename');
            $extension = $request->input('extension');
            $fullFilename = $filename;
    
            $upload = Storage::disk('public')->put($fullFilename, $media);
    
            if ($upload) {
                return response()->json(['success' => 'Cover uploaded successfully'], 200);
            } else {
                Log::error('Storage put failed');
                return response()->json(['error' => 'Failed to upload'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Upload file exception: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    function fav_user($id, $buku){
        $user_id = $id;
        $buku_id = $buku;
    
        // Find the active favorit record
        $active = favorit::where('user_id', $user_id)
                         ->where('buku_id', $buku_id)
                         ->first();
    
        if (is_null($active)) {
            // Create a new active favorit if it does not exist
            $favor = favorit::create([
                'user_id' => $user_id,
                'buku_id' => $buku_id,
                'is_active' => 1
            ]);
            $response = ['success' => 'Favorit Ditambahkan'];
        } elseif ($active->is_active == 0) {
            // Update the existing favorit to be active
            $active->is_active = 1;
            $favor = $active->save();
            $response = ['success' => 'Favorit Ditambahkan'];
        } else {
            // Update the existing favorit to be inactive
            $active->is_active = 0;
            $favor2 = $active->save();
            $response = ['success' => 'Favorit Dibuang'];
        }
    
        // Return the appropriate response
        if (isset($favor) && $favor) {
            return response()->json($response, 200);
        } elseif (isset($favor2) && $favor2) {
            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'Gagal'], 401);
        }
    }
    
}
