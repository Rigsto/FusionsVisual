<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Photo;
use App\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $portfolios = Portofolio::paginate(4);
        $pages = 'medlist';
        return view('admin.portfolio.index', compact('pages', 'portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pages = 'upload';
        return view('admin.portfolio.upload', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validateImage();
        $input = $request->all();
        if ($file = $request->file('image')){
            $tmp = str_replace(" ", "-",$request->name);
            $type = $file->getClientOriginalExtension();
            $name = $tmp."_photoProfile.".$type;
            $file->move('images', $name);
            $image = Image::make('images/' . $name)->fit(700, 700);
            $image->save();
            $pic = Photo::where('path', $name)->first();
            if ($pic){
                $pic->update(['path'=>$name]);
            }else{
                $photo = Photo::create(['path'=>$name]);
                $input['photo_id'] = $photo->id;
            }
        }
        Portofolio::create([
            'nama' => $input['name'],
            'photo_id' => $input['photo_id'],
            'tipe' => $input['tipe'],
            'admin_id' => Auth::id(),
            'description' => $input['description']
        ]);
        return redirect('/admin/portfolio')->with('Success', 'Added New Portfolio');
    }

    private function validateImage()
    {
        return request()->validate([
            'image' => 'required|file|image|max:5000',

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
