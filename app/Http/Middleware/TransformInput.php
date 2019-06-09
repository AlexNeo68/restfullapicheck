<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        $transformedInput = [];

        foreach ($request->all() as $input => $value) {
            $transformedInput[$transformer::originalAtrribute($input)] = $value;
        }

        $request->replace($transformedInput);

        $response = $next($request);

        if($response->exception && $response->exception instanceof ValidationException){
            $data = $response->getData();
            $transformedError = [];
            foreach($data->error as $field => $value){
                $transformedField = $transformer::transformedAtrribute($field);
                $transformedError[$transformedField] = str_replace($field, $transformedField, $value);
            }
            $data->error = $transformedError;
            $response->setData($data);
        }

        return $response;
    }
}
