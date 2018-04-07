<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Support\Facades\Session;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
        $this->authorize('edit',$channel);

        return view('channels.settings.edit',['channel' => $channel]);
    }
    public function update(ChannelUpdateRequest $request,Channel $channel)
    {
        $this->authorize('update',$channel);

        $channel->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        if ($request->file('image')){
            $image = $request->file('image');
            $image->move(storage_path() . '/uploads/images', $fileId = uniqid(true) . '.png');
            $this->dispatch(new UploadImage($channel,$fileId));
        }



        Session::flash('success', 'The Channel was successfully updated');
        return redirect()->to(url('/channels/' . $channel->slug . '/edit'));
        //die('update');
    }
}
