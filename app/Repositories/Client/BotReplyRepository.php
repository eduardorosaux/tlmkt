<?php
namespace App\Repositories\Client;
use App\Models\BotReply;
use App\Traits\RepoResponse;

class BotReplyRepository
{
    use RepoResponse;

    private $model;

    public function __construct(BotReply $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return BotReply::latest()->withPermission()->paginate(setting('pagination'));
    }

    public function store($request)
    {
        $reply             = new $this->model;
        $reply->client_id  = auth()->user()->client_id;
        switch ($request->reply_type) {
            case 'canned_response':
                $reply->reply_text     = $request->reply_text;
                $reply->reply_using_ai = 0;
                $reply->keywords       = null;
                break;
            case 'exact_match':
                $reply->keywords       = $request->keywords;
                $reply->reply_text     = $request->reply_using_ai == '1' ? null : $request->reply_text;
                $reply->reply_using_ai = $request->reply_using_ai == '1' ? 1 : null;
                break;
            case 'contains':
                $reply->keywords       = $request->keywords;
                $reply->reply_text     = $request->reply_using_ai == '1' ? null : $request->reply_text;
                $reply->reply_using_ai = $request->reply_using_ai == '1' ? 1 : null;
                break;
            default:
                // Handle default case if needed
                break;
        }
        $reply->name       = $request->name;
        $reply->status     = $request->status;
        $reply->reply_type = $request->reply_type;
        $reply->save();
    }

    public function find($id)
    {
        return BotReply::withPermission()->find($id);
    }

    public function update($request, $id)
    {
        $reply             = BotReply::find($id);
        $reply->client_id  = auth()->user()->client_id;
        $reply->name       = $request->name;
		$reply->status     = $request->status;
        $reply->reply_type = $request->reply_type;
        switch ($request->reply_type) {
            case 'canned_response':
                $reply->reply_text     = $request->reply_text;
                $reply->reply_using_ai = 0;
                $reply->keywords       = null;
                break;
            case 'exact_match':
                $reply->keywords       = $request->keywords;
                $reply->reply_text     = $request->reply_using_ai == '1' ? null : $request->reply_text;
                $reply->reply_using_ai = $request->reply_using_ai == '1' ? 1 : 0;
                break;
            case 'contains':
                $reply->keywords       = $request->keywords;
                $reply->reply_text     = $request->reply_using_ai == '1' ? null : $request->reply_text;
                $reply->reply_using_ai = $request->reply_using_ai == '1' ? 1 : 0;
                break;
            default:
                // Handle default case if needed
                break;
        }
        $reply->save();
    }

    public function destroy($id)
    {
        return BotReply::withPermission()->destroy($id);
    }

    public function cannedResponses()
    {
        return BotReply::where('reply_type', 'canned_response')->withPermission()->get();
    }

    public function statusChange($request)
    {
        $id = $request['id'];

        return BotReply::find($id)->update($request);
    }
}
