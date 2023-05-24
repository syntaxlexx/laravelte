<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;

trait CustomControllerResponsesTrait
{
    /**
     * return a standardized error message
     *
     * @param string $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respError($message = 'An error occurred', $code = 422)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'message' => $message,
                'alert' => 'error',
            ], $code);
        }

        return redirect()->back()->with('error', $message);
    }

    /**
     * return a standardized success message
     *
     * @param string $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respSuccess($message = 'Action Successful', $code = 200)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'message' => $message,
                'alert' => 'success',
            ], $code);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * return a standardized success message
     *
     * @param string $message
     * @param array $data
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respSuccessWithData($message = 'Action Successful', array $data = [], $code = 200)
    {
        if (request()->wantsJson()) {
            return response()->json(array_merge([
                'message' => $message,
                'alert' => 'success',
            ], $data), $code);
        }

        return redirect()->back()->with(
            array_merge(
                ['success' => $message],
                ['flash_success_data' => $data]
            )
        );
    }

    /**
     * provide a common function to return messages to the user
     *
     * @param string|bool|array $result
     * @param string $messageOnSuccess
     * @param string $messageOnError
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respJuicer($result, $messageOnSuccess = 'Action Successful', $messageOnError = 'An error occurred')
    {
        if ($result)
            return $this->respSuccess($messageOnSuccess);

        return $this->respError($messageOnError);
    }

    /**
     * throw validation error
     */
    public function respValidationError(array $errors)
    {
        throw ValidationException::withMessages($errors);
    }
}
