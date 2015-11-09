<?php namespace App\Http\Controllers\JsonApi;

use App\User;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;
use \Illuminate\Contracts\Validation\ValidationException;

/**
 * @package Neomerx\LimoncelloShot
 */
class UserController extends JsonApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->checkParametersEmpty();

        $attributes = array_get($this->getDocument(), 'data.attributes', []);

        $rules = [
            'username' => 'required|slug',
            'email'    => 'email',
            'password' => 'required',
        ];

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = \Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = new User();
        $user->fill($attributes);
        $user->save();

        return $this->getCreatedResponse($user);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        $this->checkParametersEmpty();

        return $this->getResponse(User::find(Auth::user()->id)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update()
    {
        $this->checkParametersEmpty();

        $attributes = array_get($this->getDocument(), 'data.attributes', []);
        $attributes = array_filter($attributes, function ($value) {
            return $value !== null;
        });

        $rules = [
            'username' => 'slug',
            'email'    => 'email',
        ];

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = \Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $workday = User::find(Auth::user()->id)->firstOrFail();
        $workday->fill($attributes);
        $workday->save();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        $this->checkParametersEmpty();

        $workday = User::find(Auth::user()->id)->firstOrFail();
        $workday->delete();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
    }

    /**
     * Verify the existence of specified resource.
     *
     * @param string $email
     * @return Response
     */
    public function exists($email)
    {
        $this->checkParametersEmpty();
        $user = User::where('email', $email)->firstOrFail();

        $exists = false;
        if ($user instanceof User)
            $exists = true;

        return $this->getResponse(User::where('email', $email)->firstOrFail(), Response::HTTP_OK, []);

        return response()->json([
            'exists' => $exists
        ]);
    }
}
