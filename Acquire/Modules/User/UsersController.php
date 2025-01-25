<?php

namespace Acquire\Modules\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function selfRequest(Request $request)
    {
        return $request->user();
    }
}
