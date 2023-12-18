<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use App\Admin\TimeWall;
use DataTables;
class TimeWallController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = TimeWall::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('video_name', function ($row) {
                    return Str::title($row->video_name);
                })                
            
                   ->addColumn('thumbnail',function($row){
                    $img = "<img src='".url(asset($row->video_thumbnail))."' alt='' width='40' height='50'>";

                    return $img;
               })

               ->addColumn('video',function($row){
                $video = " <video width='150' height='auto' controls>
                            <source src='".url(asset($row->video_path))."' type='video/mp4'>
                            Your browser does not support the video tag.
                        </video>";

                return $video;
           })
                   
            ->addColumn('action', function ($row) {
                $editRoute = route('admin.timewall.edit', ['id' => $row->id]);
                $deleteRoute = route('admin.timewall.delete', ['id' => $row->id]);
            
                return '<span class="d-flex flex-row">
                            <a class="btn btn-primary" title="Edit" href="' . $editRoute . '"><i class="fas fa-edit color-muted m-r-5"></i></a>
                            <form action="'.$deleteRoute.'" method="POST">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this Time Wall?\')"><i class="fa fa-trash"></i></button>
                            </form>
                        </span>';
            })
                   ->rawColumns(['video_name','thumbnail','video','action'])
                ->make(true);
        }
        return view('admin.timewall.list');
    }

    public function create()
    {
        return view('admin.timewall.createOrUpdate');
    }

    public function store(Request $request)
    {
        $rules = [
            'video_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'video_name' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,avi,mov,wmv', // Allowing mp4, avi, mov, wmv formats, assuming a maximum video size of 20MB
            // Add other validation rules as needed
        ];
    
        $messages = [
            'video_thumbnail.required' => 'The video thumbnail is required.',
            'video_thumbnail.image' => 'The video thumbnail must be an image.',
            'video_thumbnail.mimes' => 'The video thumbnail must be a file of type: jpeg, png, jpg, gif, svg.',
            'video_name.required' => 'The video name is required.',
            'video_name.string' => 'The video name must be a string.',
            'video_name.max' => 'The video name may not be greater than 255 characters.',
            'video.required' => 'The video file is required.',
            'video.mimes' => 'The video file must be a file of type: mp4, avi, mov, wmv.',
            // Add other custom error messages as needed
        ];
    
        $request->validate($rules, $messages);

        try {
    
            if ($request->hasFile('video_thumbnail') && $request->hasFile('video')) {
                $thumbnail = $request->file('video_thumbnail');
                $thumbnail_file = $request->file('video_thumbnail');

                $video = $request->file('video');
                $video_file = $request->file('video');
        
                
                $thumbnailImage = $request->video_name .time(). '_' . Str::random(8) . '_' . microtime(true) . '.' . $thumbnail_file->getClientOriginalExtension();
        
                $destinationPath = 'admin/assets/video_thumbnails/';

                $videoData = $request->video_name .time(). '_' . Str::random(8) . '_' . microtime(true) . '.' . $video_file->getClientOriginalExtension();
        
                $videoDestinationPath = 'admin/assets/videos/';
        
                $request->file('video_thumbnail')->move(public_path($destinationPath), $thumbnailImage);
        
                $thumbnailFilePath = '/' . $destinationPath . '/' . $thumbnailImage;

                $request->file('video')->move(public_path($videoDestinationPath), $videoData);
        
                $videoFilePath = '/' . $videoDestinationPath . '/' . $videoData;
        
                DB::beginTransaction(); // Start a database transaction
        
                // Create a new CMS entry with the uploaded thumbnail path
                TimeWall::create([
                    'video_name' => $request->input('video_name'),
                    'video_thumbnail' => $thumbnailFilePath,
                    'video_path' => $videoFilePath,
                    'video_filename' => $videoData
                    // Add other fields as needed
                ]);

                DB::commit(); // Commit the transaction
        
                return redirect()->route('admin.timewall.list')->with('success', 'Time Wall updated successfully');
        
        
            }
            } catch (\Exception $e) {
                DB::rollBack(); // Roll back the transaction in case of an exception
        
                // Log the error
                Log::error('Error creating TimeWall: ' . $e->getMessage());
        
                // Redirect back with an error message
                return redirect()->back()->with('error', 'An error occurred while creating the Category. Please try again.');
            }
    }

    public function edit($id)
    {
        $timeWall = TimeWall::findOrFail($id);
        $mode = 'edit';

        return view('admin.timewall.createOrUpdate', compact('timeWall','mode'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'video_name' => 'required|string|max:255',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv', // Allowing mp4, avi, mov, wmv formats, assuming a maximum video size of 20MB
            // Add other validation rules as needed
        ];

        $messages = [
            'video_thumbnail.image' => 'The video thumbnail must be an image.',
            'video_thumbnail.mimes' => 'The video thumbnail must be a file of type: jpeg, png, jpg, gif, svg.',
            'video_name.required' => 'The video name is required.',
            'video_name.string' => 'The video name must be a string.',
            'video_name.max' => 'The video name may not be greater than 255 characters.',
            'video.mimes' => 'The video file must be a file of type: mp4, avi, mov, wmv.',
            // Add other custom error messages as needed
        ];

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction(); // Start a database transaction

            $timeWall = TimeWall::findOrFail($id);

            // Handle Thumbnail Update
            if ($request->hasFile('video_thumbnail')) {
                // Delete the old thumbnail
                if ($timeWall->video_thumbnail) {
                    $this->deleteFile($timeWall->video_thumbnail);
                }

                $thumbnail_file = $request->file('video_thumbnail');
                $thumbnailImage = $request->video_name . time() . '_' . Str::random(8) . '_' . microtime(true) . '.' . $thumbnail_file->getClientOriginalExtension();

                $destinationPath = 'admin/assets/video_thumbnails/';
                $request->file('video_thumbnail')->move(public_path($destinationPath), $thumbnailImage);
                $thumbnailFilePath = '/' . $destinationPath . '/' . $thumbnailImage;

                // Update TimeWall with new thumbnail path
                $timeWall->update(['video_thumbnail' => $thumbnailFilePath]);
            }

            // Handle Video Update
            if ($request->hasFile('video')) {
                // Delete the old video
                if ($timeWall->video_path) {
                    $this->deleteFile($timeWall->video_path);
                }

                $video_file = $request->file('video');
                $videoData = $request->video_name . time() . '_' . Str::random(8) . '_' . microtime(true) . '.' . $video_file->getClientOriginalExtension();

                $videoDestinationPath = 'admin/assets/videos/';
                $request->file('video')->move(public_path($videoDestinationPath), $videoData);
                $videoFilePath = '/' . $videoDestinationPath . '/' . $videoData;

                // Update TimeWall with new video path
                $timeWall->update(['video_path' => $videoFilePath, 'video_filename' => $videoData]);
            }

            // Update other fields as needed
            $timeWall->update([
                'video_name' => $request->input('video_name'),
                // Add other fields as needed
            ]);

            DB::commit(); // Commit the transaction

            return redirect()->route('admin.timewall.list')->with('success', 'Time Wall updated successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction in case of an exception

            // Log the error
            Log::error('Error updating TimeWall: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the Time Wall. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $timeWall = TimeWall::findOrFail($id);

            // Delete associated files
            $this->deleteFile($timeWall->video_thumbnail);
            $this->deleteFile($timeWall->video_path);

            DB::beginTransaction(); // Start a database transaction

            // Delete the record from the database
            $timeWall->delete();

            DB::commit(); // Commit the transaction

            return redirect()->route('admin.timewall.list')->with('success', 'Time Wall deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction in case of an exception

            // Log the error
            Log::error('Error deleting TimeWall: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->route('admin.timewall.list')->with('error', 'An error occurred while deleting the Time Wall. Please try again.');
        }
    }

    private function deleteFile($path)
    {
        $filePath = public_path($path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
