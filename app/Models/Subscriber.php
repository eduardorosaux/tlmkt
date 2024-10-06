<?php

namespace App\Models;

use App\Traits\RepoResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;
    use RepoResponse;


    protected $fillable = ['email', 'status'];


    public function subscribeStore($request)
    {

        try {
      
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers'],
                ],
                [
                    'email.unique' => __('email_already_subscribed'),
                ]
            );
          
            $data               = [];
            $data['name']       = $request->name;
            $data['phone']      = $request->phone;
            $subscriber                 = new Subscriber();
            $subscriber->name           = $request->name;
            $subscriber->email          = $request->email;
            $subscriber->save();
            if (isMailSetupValid()) {
                // Mail::to(setting('contact_email'))->send(new SendContact($data));
            } 
            // Toastr::success(__('we_have_received_your_query_our_support_team_will_back_to_you_soon'));

            return $this->formatResponse(true, __('we_have_received_your_query_our_support_team_will_back_to_you_soon'), route('client.templates.index'), []);

            // return response()->json(['success' => __('we_have_received_your_query_our_support_team_will_back_to_you_soon')]);
            // return redirect()->back()->with('success',__('we_have_received_your_query_our_support_team_will_back_to_you_soon'));
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                dd($e->getMessage());            
            }            
            return $this->formatResponse(false, $e->getMessage(), route('client.templates.index'), []);
            return response()->json(['error' => $e->getMessage()]);
        }
    }




}
