<?php

namespace App\Http\Controllers;

use Response;

class ApiController extends Controller {

    protected $statusCode = 200;

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function respondNotFound($message = 'Not Found!') {
        $this->setStatusCode(404);
        return $this->respondWithError($message);
    }

    public function respond($data, $headers = []) {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message) {
        return $this->respond([
            'error' => [
                'message'       => $message,
                'status_code'   => $this->getStatusCode()
            ]
        ]);
    }

}
